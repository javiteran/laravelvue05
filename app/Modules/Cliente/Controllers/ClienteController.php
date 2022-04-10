<?php

namespace App\Modules\Cliente\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Modules\Cliente\Requests\ClienteRequest;
use App\Modules\Cliente\Resources\ClienteResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClienteController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        [$column, $order] = explode(',', $request->input('sortBy', 'id,asc'));
        $pageSize = (int) $request->input('pageSize', 10);

        $resource = Cliente::query()
            ->when($request->filled('search'), function (Builder $q) use ($request) {
                $q->where(Cliente::COLUMN_NAME, 'like', '%'.$request->search.'%');
            })
            ->orderBy($column, $order)->paginate($pageSize);

        return ClienteResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     * @param ClienteRequest $request
     * @return JsonResponse
     */
    public function store(ClienteRequest $request)
    {
        $data = $request->validated();
        $cliente = new Cliente($data);
        $cliente->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Cliente $cliente
     * @return ClienteResource
     */
    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClienteRequest $request
     * @param Cliente $cliente
     * @return JsonResponse
     */
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $data = $request->validated();
        $cliente->fill($data)->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * @param Cliente $cliente
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully deleted',
        ]);
    }
}
