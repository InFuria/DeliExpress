<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index(){
        //
    }

    public function store(ProductRequest $request)
    {
        try {
            /*if (! $this->user->hasPermissionTo('products.store')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $product = Product::create([
                'name'          => $request->name,
                'description'   => $request->description,
                'img'           => '',
                'price'         => $request->price,
                'cost'          => $request->cost,
                'store_id'      => $request->store_id,
                'category_id'   => $request->category_id
            ]);

            if ($request->hasFile('img')) {
                $file = $request->img;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs("/stores/$request->store_id/products/", $file, $name);

                    $product->img = $name;
                    $product->save();
                }
            }

            return response()->json(['message' => 'Se ha agregado un nuevo producto!', 'product' => $product]);

        } catch (\Exception $e) {
            \Log::error('General\ProductController::store - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }

    public function show(Product $product)
    {
        try {
            /*if (! $this->user->hasPermissionTo('products.show')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            return response()->json(['product' => $product]);

        } catch (\Exception $e) {
            \Log::error('General\ProductController::show - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al buscar el negocio"], 404);
        }
    }


    public function update(ProductRequest $request, Product $product)
    {
        try {
            /*if (! $this->user->hasPermissionTo('products.update')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->cost = $request->cost;

            if ($request->hasFile('img')) {
                $old = $product->img;
                $file = $request->img;

                if ($file->isValid()) {
                    $name = time() . str_random(5) . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs("/stores/$request->store_id/products/", $file, $name);

                    Storage::disk('public')->delete("/stores/$request->store_id/products/" . $old);

                    $product->img = $name;
                }
            }

            $product->save();

            return response()->json(['message' => 'Se ha actualizado el producto!','product' => $product]);

        } catch (\Exception $e) {
            \Log::error('General\ProductController::update - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al actualizar el negocio"], 404);
        }
    }


    public function destroy(Product $product)
    {
        try {
            /*if (! $this->user->hasPermissionTo('products.destroy')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $id = $product->category_id;
            $product->delete();

            $category = SubCategory::where('id', $id)->withCount('products')->first();

            return response()->json(['message' => "Se ha eliminado el producto!", 'category' => $category]);

        } catch (\Exception $e) {
            \Log::error('General\ProductController::destroy - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al eliminar el negocio"], 404);
        }
    }

    public function bySubCategory($subCategory)
    {
        try {
            /*if (! $this->user->hasPermissionTo('products.list')){
                return response()->json(['message' => 'No posee permisos suficientes para usar esta funcionalidad.'], 403);
            }*/

            $products = Product::where('category_id', $subCategory)->get();
            return response()->json(['products' => $products]);

        } catch (\Exception $e) {
            \Log::error('General\ProductController::bySubCategory - ' . $e->getMessage(), ['error_line' => $e->getLine()]);
            return response()->json(["message" => "Ha ocurrido un error al procesar los datos"], 404);
        }
    }
}
