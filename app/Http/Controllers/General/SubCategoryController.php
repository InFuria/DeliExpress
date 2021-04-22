<?php

namespace App\Http\Controllers\General;

use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{


    public function store(Request $request)
    {
        try {
            /*if (! $this->user->hasPermissionTo('sub.categories.store')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $category = new SubCategory();
            $category->name = $request->name;
            $category->category_id = $request->category_id;
            $category->save();

            $category = SubCategory::where('id', $category->id)->withCount('products')->first();

            return response()->json(['category' => $category]);

        } catch (\Exception $e) {
            \Log::error('General\SubCategoryController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }


    public function show(SubCategory $subCategory)
    {
        //
    }


    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    public function destroy(SubCategory $subCategory)
    {
        try {
            /*if (! $this->user->hasPermissionTo('sub.categories.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $subCategory->products()->delete();
            $subCategory->delete();

            return response()->json(['message' => 'Se ha eliminado la sub-categoria!']);

        } catch (\Exception $e) {
            \Log::error('General\SubCategoryController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar la sub-categoria"], 404);
        }
    }


    /**
     * Busca todas las sub-categorias por categoria de producto y devuelve un listado
     * @param $productCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function listWithProducts($productCategory)
    {
        try {
            /*if (! $this->user->hasPermissionTo('sub.categories.list')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $category = SubCategory::where('category_id', $productCategory)->orderBy('sub_categories.name', 'desc')->with(['products'])->withCount('products')->get();

            return response()->json(['category' => $category]);

        } catch (\Exception $e) {
            \Log::error('General\SubCategoryController::listWithProducts - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }

}
