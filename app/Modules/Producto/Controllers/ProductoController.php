<?php

namespace App\Modules\Producto\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Modules\Producto\Requests\ProductoRequest;
use App\Modules\Producto\Resources\ProductoResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductoController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        [$column, $order] = explode(',', $request->input('sortBy', 'id,asc'));
        $pageSize = (int) $request->input('pageSize', 10);

        $resource = Producto::query()
            ->when($request->filled('search'), function (Builder $q) use ($request) {
                $q->where(Producto::COLUMN_NAME, 'like', '%'.$request->search.'%');
            })
            ->orderBy($column, $order)->paginate($pageSize);

        return ProductoResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     * @param ProductoRequest $request
     * @return JsonResponse
     */
    public function store(ProductoRequest $request)
    {
        $data = $request->validated();
        $producto = new Producto($data);
        $producto->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Producto $producto
     * @return ProductoResource
     */
    public function show(Producto $producto)
    {
        return new ProductoResource($producto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductoRequest $request
     * @param Producto $producto
     * @return JsonResponse
     */
    public function update(ProductoRequest $request, Producto $producto)
    {
        $data = $request->validated();
        $producto->fill($data)->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * @param Producto $producto
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully deleted',
        ]);
    }
}
