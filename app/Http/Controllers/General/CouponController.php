<?php

namespace App\Http\Controllers\General;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Order;
use App\OrderStatus;
use App\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
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
            if (! $this->user->hasPermissionTo('coupons.index')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            if (request()->ajax())
            {
                if ($search = request()->search){

                    $coupons = Coupon::where('code', 'LIKE', $search . '%')->orderBy('coupons.updated_at', 'desc')->get()->toArray();

                    return response()->json(['coupons' => $coupons]);

                } else {

                    $coupons = Coupon::orderBy('coupons.updated_at', 'desc')->get();

                    return response()->json(['coupons' => $coupons]);
                }
            }

            $coupons = Coupon::orderBy('coupons.updated_at', 'desc')->get();
            $stores = Store::select('id', 'short_name')->get();

            return view('general.coupons.index', compact('coupons', 'stores'));

        } catch (\Exception $e) {
            \Log::error('General\CouponController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function store(CouponRequest $request)
    {
        try {
            if (! $this->user->hasPermissionTo('coupons.store')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $check = Coupon::where('code', $request->code)->get();
            if ($check->count() > 0)
                return redirect()->back()->with('toast_error', 'Ya existe un cupón con el codigo ingresado!');

            if ($request->discount < 0 || $request->discount > 100 || gmp_sign($request->discount) <= 0)
                return redirect()->back()->with('toast_error', 'El porcentaje de descuento ingresado no es valido!');

            $expired = Carbon::createFromFormat('d/m/Y', $request->expired_date)->format('Y-m-d');
            $coupon = Coupon::create([
                'code'          => strtoupper($request->code),
                'discount'      => $request->discount,
                'expired_date'  => $expired,
                'status'        => 1
            ]);

            if (isset($request->stores))
                $coupon->stores()->sync($request->stores);

            return redirect()->route('coupons.index')->with('toast_success', 'Se ha registrado un nuevo cupón!');

        } catch (\Exception $e) {
            \Log::error('General\CouponController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al procesar los datos');
        }
    }

    public function show($coupon)
    {
        try {
            if (! $this->user->hasPermissionTo('coupons.show')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $coupon = Coupon::where('id', $coupon)->with(['stores'])->first();

            $status = OrderStatus::where('name', 'Entregado')->first()->id;
            $aplications = Coupon::join('coupon_order', 'coupons.id', '=', 'coupon_id')->join('orders', 'orders.id', '=', 'coupon_order.order_id')
                ->selectRaw("COUNT(coupon_order.id) as count")->where('orders.status', $status)->where('coupon_order.coupon_id', $coupon->id)->first()->count;

            $start_time = Carbon::parse($coupon->created_at);
            $finish_time = Carbon::parse($coupon->expired_date);
            $now = Carbon::now();

            $days_past = round($start_time->floatDiffInDays($now, false));
            $remaining = ceil($now->floatDiffInDays($finish_time, false));
            $remaining = $remaining <= 0 ? 0 : $remaining;


            return response()->json(['coupon' => $coupon, 'aplications' => $aplications, 'days_past' => $days_past, 'remaining' => $remaining]);

        } catch (\Exception $e) {
            \Log::error('General\CouponController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al buscar el cupón"], 404);
        }
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        try {
            if (! $this->user->hasPermissionTo('coupons.update')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            if ($request->expired_date != $coupon->expired_date){
                $expired = Carbon::createFromFormat('d/m/Y', $request->expired_date)->format('Y-m-d');
                $request->expired_date = $expired;
            }

            $check = Coupon::where('code', $request->code)->get();
            if ($check->count() > 0 && $request->code != $coupon->code)
                return redirect()->back()->with('toast_error', 'Ya existe un cupón con el codigo ingresado!');

            if ($request->discount < 0 || $request->discount > 100 || gmp_sign($request->discount) <= 0)
                return redirect()->back()->with('toast_error', 'El porcentaje de descuento ingresado no es valido!');

            $expired = Carbon::parse($request->expired_date);
            if ($expired->diffInDays(Carbon::now()) <= 0)
                return redirect()->back()->with('toast_error', 'La fecha de expiracion debe ser mayor al dia de hoy!');


            $coupon->update([
                'code'          => strtoupper($request->code),
                'discount'      => $request->discount,
                'expired_date'  => $request->expired_date
            ]);

            if (isset($request->stores))
                $coupon->stores()->sync($request->stores);

            return redirect()->route('coupons.index')->with('toast_success', "Se ha actualizado el cupón!");

        } catch (\Exception $e) {
            \Log::error('General\CouponController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al actualizar los datos');
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            if (! $this->user->hasPermissionTo('coupons.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $coupon->stores()->sync([]);
            $coupon->delete();

            return response()->json(['message' => "Se ha eliminado el cupón!"]);

        } catch (\Exception $e) {
            \Log::error('General\CouponController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar el cupón"], 404);
        }
    }

    public function status(Coupon $coupon)
    {
        try {
            if (! $this->user->hasPermissionTo('coupons.status')){
                return redirect()->back()->with('message', 'No posee permisos suficientes para usar esta funcionalidad.');
            }

            $coupon->status = ! $coupon->status;
            $coupon->save();

            return redirect()->back()->with("toast_success", "Se ha actualizado el estado del cupón {$coupon->code}!");

        } catch (\Exception $e) {
            \Log::error('General\CouponController::status - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al actualizar el cupón"], 404);
        }
    }
}
