<?php

namespace App\Modules\Alumno\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Modules\Alumno\Requests\AlumnoRequest;
use App\Modules\Alumno\Resources\AlumnoResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlumnoController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        [$column, $order] = explode(',', $request->input('sortBy', 'id,asc'));
        $pageSize = (int) $request->input('pageSize', 10);

        $resource = Alumno::query()
            ->when($request->filled('search'), function (Builder $q) use ($request) {
                $q->where(Alumno::COLUMN_NAME, 'like', '%'.$request->search.'%');
            })
            ->orderBy($column, $order)->paginate($pageSize);

        return AlumnoResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     * @param AlumnoRequest $request
     * @return JsonResponse
     */
    public function store(AlumnoRequest $request)
    {
        $data = $request->validated();
        //TO-DO
        //$alumno = new Alumno($data);

        $alumno  = new Alumno;
        $alumno->name = $request->name;
        $alumno->curso = $request->curso;
        //
        $alumno->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Alumno $alumno
     * @return AlumnoResource
     */
    public function show(Alumno $alumno)
    {
        return new AlumnoResource($alumno);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AlumnoRequest $request
     * @param Alumno $alumno
     * @return JsonResponse
     */
    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $data = $request->validated();
        //Nuevo TO-DO
        //$alumno->fill($data)->save();

        $alumno->update([
            'name'  => $request->get('name'),
            'curso' => $request->get('curso'),
        ]);
        // FIN

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * @param Alumno $alumno
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully deleted',
        ]);
    }
}
