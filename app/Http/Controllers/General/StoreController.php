<?php

namespace App\Http\Controllers\General;

use App\OrderStatus;
use App\Product;
use App\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Illuminate\Http\Request;
use App\Municipality;
use App\Department;
use App\Category;
use App\Store;
use App\Zone;
use App\User;

class StoreController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index()
    {
        try {
            if (! $this->user->hasPermissionTo('stores.index')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            if (request()->ajax())
            {
                if ($search = request()->search){

                    $stores = Store::where('short_name', 'LIKE', $search . '%')->orWhere('long_name', 'LIKE', $search . '%')
                        ->with(['categories'])->get()->toArray();

                    return response()->json(['stores' => $stores]);

                } else {

                    $stores = Store::with(['categories'])->orderBy('stores.updated_at', 'desc')->get();

                    return response()->json(['stores' => $stores]);
                }
            }

            $categories = Category::select('id', 'name', 'img')->where('status', '=', 1)->get();
            $stores = Store::with(['categories'])->orderBy('stores.updated_at', 'desc')->get();

            $departments = Department::select('id', 'name')->get();
            $municipalities =  Municipality::select('id', 'name')->get();
            $zones =  Zone::select('id', 'name')->get();

            return view('general.stores.index', compact('categories', 'stores', 'departments', 'municipalities', 'zones'));

        } catch (\Exception $e) {
            \Log::error('General\StoreController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            if (! $this->user->hasPermissionTo('stores.store')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $store = Store::where('email', $request->email)->first();
            if(isset($store))
                return redirect()->back()->with('toast_error', "Ya existe un negocio asociado al email ingresado");

            $user = User::where('email', $request->email)->first();
            if(isset($user->store))
                return redirect()->back()->with('toast_error', "Ya existe un negocio asociado al usuario con email {$user->email}");

            if (! isset($user)) {
                $username = explode('@', $request->email);
                $user = User::create([
                    'name' => $request->long_name,
                    'username' => $username[0],
                    'phone' => $request->phone,
                    'photo' => '',
                    'is_store' => true,
                    'role_id' => Role::where('slug', 'store')->first()->id,
                    'email' => $request->email,
                    'password' => ''
                ]);
                $user->sendEmailVerificationNotification();

            } else {
                $user->is_store = 1;
                $user->role_id = Role::where('slug', 'store')->first()->id;
                $user->save();
            }

            $store = Store::create([
                'user_id'           => $user->id,
                'long_name'         => $request->long_name,
                'short_name'        => $request->short_name,
                'description'       => $request->description,
                'address'           => $request->address,
                'phone'             => $request->phone,
                'mobile'            => $request->mobile,
                'email'             => $request->email,
                'logo'              => '',
                'cover'             => '',
                'rate_avg'          => 0,
                'department_id'     => $request->department_id,
                'municipality_id'   => $request->municipality_id,
                'zone_id'           => $request->zone_id
            ]);

            if ($request->hasFile('logo')) {
                $file = $request->logo;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs("/stores/$store->id/", $file, $name);

                    $store->logo = $name;
                    $store->save();
                }
            }

            if ($request->hasFile('cover')) {
                $file = $request->cover;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs("/stores/$store->id/", $file, $name);

                    $store->cover = $name;
                    $store->save();
                }
            }

            $store->categories()->sync($request->categories);

            return redirect()->route('stores.index')->with('toast_success', 'Se ha registrado un nuevo negocio!');

        } catch (\Exception $e) {
            \Log::error('General\StoreController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al procesar los datos');
        }
    }

    public function show($store)
    {
        try {
            if (! $this->user->hasPermissionTo('stores.show')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $store = Store::where('id', $store)->with(['user','categories', 'productCategories'])->first();
            $details = [
                'products'  => $store->products()->count(),
                'total'     => $store->orders()->count(),
                'delivered' => $store->whereHas('orders', function ($query) {
                    return $query->where('status', '=', OrderStatus::where('name', '=', 'Entregado')->first()->id);
                })->count(),
                'cancelled' => $store->whereHas('orders', function ($query) {
                    return $query->where('status', '=', OrderStatus::where('name', '=', 'Cancelado')->first()->id);
                })->count(),
            ];

            return response()->json(['store' => $store, 'details' => $details]);

        } catch (\Exception $e) {
            \Log::error('General\StoreController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al buscar al negocio"], 404);
        }
    }

    public function update(StoreRequest $request, Store $store)
    {
        try {
            if (! $this->user->hasPermissionTo('stores.update')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $user = User::where('email', $request->email)->first();
            if(isset($user) && $user->id !== $store->user_id)
                return redirect()->back()->with('toast_error', "Ya existe un usuario asociado al email `{$user->email}`");

            $store->update([
                'long_name'         => $request->long_name,
                'short_name'        => $request->short_name,
                'description'       => $request->description,
                'address'           => $request->address,
                'phone'             => $request->phone,
                'mobile'            => $request->mobile,
                'email'             => $request->email,
                'department_id'     => $request->department_id,
                'municipality_id'   => $request->municipality_id,
                'zone_id'           => $request->zone_id
            ]);

            if ($request->hasFile('logo')) {
                $file = $request->logo;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs("/stores/$store->id/", $file, $name);

                    $store->logo = $name;
                    $store->save();
                }
            }

            if ($request->hasFile('cover')) {
                $file = $request->cover;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs("/stores/$store->id/", $file, $name);

                    $store->cover = $name;
                    $store->save();
                }
            }

            $store->categories()->sync($request->categories);

            return redirect()->route('stores.index')->with('toast_success', "Se ha actualizado el negocio `{$store->short_name}`!");

        } catch (\Exception $e) {
            \Log::error('General\StoreController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al procesar los datos');
        }
    }

    public function destroy(Store $store)
    {
        try {
            if (! $this->user->hasPermissionTo('stores.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $store->user()->delete();
            $store->categories()->sync([]);
            $store->productCategories()->delete();
            $store->products()->delete();
            $store->delete();

            return response()->json(['message' => "Se ha eliminado el negocio!"]);

        } catch (\Exception $e) {
            \Log::error('General\StoreController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar el negocio"], 404);
        }
    }
}
