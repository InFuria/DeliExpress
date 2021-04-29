<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
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
            if (! $this->user->hasPermissionTo('clients.index')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $clients = Client::with(['addresses', 'orders'])->orderBy('clients.updated_at', 'desc')->get();

            if (request()->ajax())
            {
                if ($search = request()->search){

                    $clients = Client::where('first_name', 'LIKE', $search . '%')->orWhere('second_name', 'LIKE', $search . '%')
                        ->orWhere('first_lastname', 'LIKE', $search . '%')->orWhere('second_lastname', 'LIKE', $search . '%')
                        ->orWhere('email', 'LIKE', $search . '%')->orderBy('clients.updated_at', 'desc')
                        ->with(['addresses', 'orders'])->get()->toArray();

                    return response()->json(['clients' => $clients]);

                } else {

                    return response()->json(['clients' => $clients]);
                }
            }

            return view('general.clients.index', compact('clients'));

        } catch (\Exception $e) {
            \Log::error('General\ClientController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al cargar la pagina');
        }
    }


    public function store(ClientRequest $request)
    {
        try {
            if (! $this->user->hasPermissionTo('clients.store')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $client = Client::create([
                'first_name'        => $request->first_name,
                'second_name'       => $request->second_name,
                'first_lastname'    => $request->first_lastname,
                'second_lastname'   => $request->second_lastname,
                'phone'             => $request->phone,
                'mobile'            => $request->mobile,
                'email'             => $request->email
            ]);


            if (isset($request->addresses)){

                $addresses = [];
                foreach ($request->addresses as $address){
                    $addresses[] = ["client_id" => $client->id, "direction" => $address];
                }

                $client->addresses()->delete();
                $client->addresses()->createMany($addresses);
            }

            return redirect()->route('clients.index')->with('toast_success', 'Se ha registrado un nuevo cliente!');

        } catch (\Exception $e) {
            \Log::error('General\ClientController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al procesar los datos');
        }
    }


    public function show($client)
    {
        try {
            if (! $this->user->hasPermissionTo('clients.show')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $client = Client::where('id', $client)->withCount(['addresses', 'orders'])->with('addresses')->first();

            $status = OrderStatus::where('name', 'Entregado')->first()->id;
            $delivered = Client::join('orders', 'clients.id', '=', 'orders.client_id')
                ->selectRaw("COUNT(orders.id) as count")->where('orders.status', $status)->where('orders.client_id', $client->id)->first()->count;

            $status = OrderStatus::where('name', 'Cancelado')->first()->id;
            $canceled = Client::join('orders', 'clients.id', '=', 'orders.client_id')
                ->selectRaw("COUNT(orders.id) as count")->where('orders.status', $status)->where('orders.client_id', $client->id)->first()->count;


            return response()->json(['client' => $client, 'delivered' => $delivered, 'canceled' => $canceled]);

        } catch (\Exception $e) {
            \Log::error('General\ClientsController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al buscar al cliente"], 404);
        }
    }


    public function update(ClientRequest $request, Client $client)
    {
        try {
            if (! $this->user->hasPermissionTo('clients.update')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $client->update([
                'first_name'        => $request->first_name,
                'second_name'       => $request->second_name,
                'first_lastname'    => $request->first_lastname,
                'second_lastname'   => $request->second_lastname,
                'phone'             => $request->phone,
                'mobile'            => $request->mobile,
                'email'             => $request->email
            ]);

            if (isset($request->addresses)){

                $addresses = [];
                foreach ($request->addresses as $address){
                    $addresses[] = ["client_id" => $client->id, "direction" => $address];
                }

                $client->addresses()->delete();
                $client->addresses()->createMany($addresses);
            }

            return redirect()->route('clients.index')->with('toast_success', "Se ha actualizado al cliente $client->first_name $client->first_lastname!");

        } catch (\Exception $e) {
            \Log::error('General\ClientController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al actualizar los datos');
        }
    }


    public function destroy(Client $client)
    {
        try {
            if (! $this->user->hasPermissionTo('clients.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $client->addresses()->delete();
            $client->orders()->delete();
            $client->delete();

            return response()->json(['message' => "Se ha eliminado el cliente!"]);

        } catch (\Exception $e) {
            \Log::error('General\ClientController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar al cliente"], 404);
        }
    }

    public function status(Client $client)
    {
        try {
            if (! $this->user->hasPermissionTo('clients.status')){
                return redirect()->back()->with('message', 'No posee permisos suficientes para usar esta funcionalidad.');
            }

            $client->status = ! $client->status;
            $client->save();

            return redirect()->back()->with("toast_success", "Se ha actualizado el estado del cliente $client->first_name $client->first_lastname!");

        } catch (\Exception $e) {
            \Log::error('General\ClientController::status - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with("toast_error", "Ha ocurrido un error al actualizar al cliente");
        }
    }
}
