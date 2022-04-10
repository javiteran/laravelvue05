<?php

namespace App\Modules\Inventario\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Modules\Inventario\Requests\InventarioRequest;
use App\Modules\Inventario\Resources\InventarioResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InventarioController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        [$column, $order] = explode(',', $request->input('sortBy', 'id,asc'));
        $pageSize = (int) $request->input('pageSize', 10);

        $resource = Inventario::query()
            ->when($request->filled('search'), function (Builder $q) use ($request) {
                $q->where(Inventario::COLUMN_NAME, 'like', '%'.$request->search.'%');
            })
            ->orderBy($column, $order)->paginate($pageSize);

        return InventarioResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     * @param InventarioRequest $request
     * @return JsonResponse
     */
    public function store(InventarioRequest $request)
    {
        $data = $request->validated();       
        //$inventario = new Inventario($data);
        //
        $inventario = new Inventario;
        $inventario->name = $request->name;
        $inventario->marca = $request->marca;
        $inventario->TipoHardware = $request->TipoHardware;
        $inventario->Departamento = $request->Departamento;
        //
        $inventario->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Inventario $inventario
     * @return InventarioResource
     */
    public function show(Inventario $inventario)
    {  
        return new InventarioResource($inventario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InventarioRequest $request
     * @param Inventario $inventario
     * @return JsonResponse
     */
    public function update(InventarioRequest $request, Inventario $inventario)
    {
        $data = $request->validated();
        //Así funciona por defecto con un sólo campo?
        //$inventario->fill($data)->save();
        
        //NUEVO TO-DO
        $inventario->update([
            'name' => $request->get('name'),
            'marca' => $request->get('marca'),
            'TipoHardware' => $request->get('TipoHardware'),
            'Departamento' => $request->get('Departamento'),
        ]);
        // FIN

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * @param Inventario $inventario
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully deleted',
        ]);
    }
}
