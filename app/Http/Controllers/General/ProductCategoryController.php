<?php

namespace App\Http\Controllers\General;

use App\Category;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });

    }

    public function store(Request $request)
    {
        try {
            /*if (! $this->user->hasPermissionTo('product.categories.store')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $category = ProductCategory::create([
                'name'          => $request->name,
                'store_id'      => $request->store_id
            ]);

            return response()->json(['category' => $category]);

        } catch (\Exception $e) {
            \Log::error('General\ProductCategoryController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }

    public function destroy(ProductCategory $product)
    {
        try {
            /*if (! $this->user->hasPermissionTo('product.categories.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $product->subCategories()->delete();
            $product->delete();

            return response()->json(['message' => 'Se ha eliminado la categoria!']);

        } catch (\Exception $e) {
            \Log::error('General\ProductCategoryController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar la categoria"], 404);
        }
    }
}
