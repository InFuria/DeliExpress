<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Municipality;
use App\Department;
use App\Zone;

class LocationController extends Controller
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
            if (! $this->user->hasPermissionTo('locations.index')){
                return redirect()->back()->with('toast_error', 'No posee permisos suficientes para acceder a esta seccion.');
            }

            $departments = Department::select('id', 'name')->orderBy('departments.updated_at', 'desc')->withCount('municipalities')->get();

            return view('general.locations.index', compact('departments'));

        } catch (\Exception $e) {
            \Log::error('General\LocationController::index - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return redirect()->back()->with('toast_error', 'Ha ocurrido un error al cargar la pagina');
        }
    }

    public function store(LocationRequest $request)
    {
        try {
            if (! $this->user->hasPermissionTo('locations.store')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $type = $request->type;
            switch ($type){
                case "department":
                    $department = Department::create([
                        'name'  => $request->name
                    ]);

                    return response()->json(['message' => "Se registrado el departamento `$department->name`"]);
                    break;

                case "municipality":

                    if (!isset($request->department_id))
                        return response()->json(['message' => 'No se ha seleccionado un departamento.'], 403);

                    $municipality = Municipality::create([
                        'name'  => $request->name,
                        'department_id'  => $request->department_id
                    ]);

                    return response()
                        ->json(['message' => "Se registrado la municipalidad `$municipality->name` para el departamento `{$municipality->department->name}`"]);
                    break;

                case "zone":

                    if (!isset($request->municipality_id))
                        return response()->json(['message' => 'No se ha seleccionado un municipio.'], 403);

                    $zone = Zone::create([
                        'name'  => $request->name,
                        'municipality_id'  => $request->municipality_id
                    ]);

                    return response()->json(['message' => "Se registrado la zona `$zone->name` para la municipalidad `{$zone->municipality->name}`"]);
                    break;

                default:
                    return response()->json(['message' => 'No se ha seleccionado que tipo de ubicacion se intenta registrar.'], 403);
                    break;
            }

        } catch (\Exception $e) {
            \Log::error('General\LocationController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al registrar los datos"], 404);
        }
    }

    public function update(LocationRequest $request, $id)
    {
        try {
            if (! $this->user->hasPermissionTo('locations.update')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $type = $request->type;
            switch ($type){
                case "department":

                    $department = Department::where('id', $id)->first();
                    $old = $department->name;

                    $department->update(['name' => $request->name]);

                    return response()->json(['message' => "Se ha actualizado el departamento `$old` a $department->name`"]);
                    break;

                case "municipality":

                    $municipality = Municipality::where('id', $id)->first();
                    $old = $municipality->name;

                    $municipality->update(['name' => $request->name]);

                    return response()->json(['message' => "Se ha actualizado el municipio `$old` a $municipality->name`"]);
                    break;

                case "zone":

                    $zone = Zone::where('id', $id)->first();
                    $old = $zone->name;

                    $zone->update(['name' => $request->name]);

                    return response()->json(['message' => "Se ha actualizado la zona `$old` a $zone->name`"]);
                    break;

                default:
                    return response()->json(['message' => 'No se ha seleccionado que tipo de ubicacion se intenta registrar.'], 403);
                    break;
            }

        } catch (\Exception $e) {
            \Log::error('General\LocationController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al actualizar los datos"], 404);
        }
    }

    public function destroy($id){
        try {
            if (! $this->user->hasPermissionTo('locations.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            $type = request()->type;
            switch ($type){
                case "department":

                    $department = Department::find($id);
                    $name = $department->name;

                    $department->municipalities()->delete();
                    $department->delete();

                    return response()->json(['message' => "Se ha eliminado el departamento `$name` y sus dependencias!"]);
                    break;

                case "municipality":

                    $municipality = Municipality::find($id);
                    $name = $municipality->name;

                    $municipality->zones()->delete();
                    $municipality->delete();

                    return response()->json(['message' => "Se ha eliminado el municipio `$name` y sus dependencias!"]);
                    break;

                case "zone":

                    $zone = Zone::find($id);
                    $name = $zone->name;

                    $zone->delete();

                    return response()->json(['message' => "Se eliminado la zona `$name`!"]);
                    break;

                default:
                    return response()->json(['message' => 'No se ha seleccionado que tipo de ubicacion se intenta eliminar.'], 403);
                    break;
            }

        } catch (\Exception $e) {
            \Log::error('General\LocationController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar la ubicacion!"], 404);
        }
    }

    public function getDepartments($department = null){
        try {
            if (! $this->user->hasPermissionTo('locations.list')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            /**  Ver un departamento especifico **/
            if (isset($department)){
                $department = Department::where('id', $department)->with('municipalities')->withCount('municipalities')
                    ->orderBy('departments.name', 'desc')->first();

                return response()->json(["location" => $department]);
            }

            /** Listado de departamentos con detalles de municipios **/
            if (request()->withDetails == true){
                $departments = Department::select('id', 'name')->orderBy('departments.updated_at', 'desc')->with('municipalities')->get();

                return response()->json(['departments' => $departments]);
            }

            /** Busqueda de departamentos **/
            if ($search = request()->search){

                $departments = Department::where('name', 'LIKE', $search . '%')->orderBy('departments.updated_at', 'desc')
                    ->withCount('municipalities')->get();

                return response()->json(['departments' => $departments]);

            } else {

                $departments = Department::select('id', 'name')->orderBy('departments.updated_at', 'desc')->withCount('municipalities')->get();

                return response()->json(['departments' => $departments]);
            }

        } catch (\Exception $e) {
            \Log::error('General\LocationController::getDepartments - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }

    public function getMunicipalities($municipality = null){
        try {
            if (! $this->user->hasPermissionTo('locations.list')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            /**  Ver un municipio especifico **/
            if (isset($municipality)){
                $municipality = Municipality::where('id', $municipality)->with('zones')->withCount('zones')
                    ->orderBy('municipalities.name', 'desc')->first();

                return response()->json(["location" => $municipality]);
            }

            /** Listado de municipios con detalles de zonas **/
            if (request()->withDetails == true){
                $municipalities = Municipality::select('id', 'name')->orderBy('municipalities.updated_at', 'desc')->with('zones')->get();

                return response()->json(['municipalities' => $municipalities]);
            }

            /** Busqueda de municipios **/
            if (request()->search && request()->department){

                $municipalities = Municipality::where('department_id', request()->department)->where('name', 'LIKE', '%' . request()->search . '%')
                    ->withCount('zones')->orderBy('municipalities.updated_at', 'desc')->get();

                return response()->json(['municipalities' => $municipalities]);

            } else if (request()->department) {

                $municipalities = Municipality::select('id', 'name')->where('department_id', request()->department)
                    ->orderBy('municipalities.updated_at', 'desc')->withCount('zones')->get();

                return response()->json(['municipalities' => $municipalities]);
            }

        } catch (\Exception $e) {
            \Log::error('General\LocationController::getMunicipalities - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }

    public function getZones($zone = null){
        try {
            if (! $this->user->hasPermissionTo('locations.list')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }

            /**  Ver una zona especifica **/
            if (isset($zone)){
                $zone = Zone::where('id', $zone)->orderBy('zones.name', 'desc')->first();

                return response()->json(["location" => $zone]);
            }

            /** Busqueda de zonas **/
            if (request()->search && request()->municipality){

                $zones = Zone::where('municipality_id', request()->municipality)->where('name', 'LIKE', '%' . request()->search . '%')
                    ->orderBy('zones.updated_at', 'desc')->get();

                return response()->json(['zones' => $zones]);

            } else if (request()->municipality) {

                $zones = Zone::select('id', 'name')->where('municipality_id', request()->municipality)
                    ->orderBy('zones.updated_at', 'desc')->get();

                return response()->json(['zones' => $zones]);
            }

        } catch (\Exception $e) {
            \Log::error('General\LocationController::getZones - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }
}
