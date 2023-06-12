<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypePhonesRequest;
use App\Models\TypePhone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TypePhonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        if (isset($request['sortBy']))
            if (Schema::hasColumn('type_phones', $request['sortBy']))
                return TypePhone::orderBy($request['sortBy'])->get();
        return TypePhone::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypePhonesRequest $request)
    {
        $validated = $request->validated();
        return TypePhone::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return TypePhone::find($id) ?? response()
            ->json(
                ['errors' => 'no such entry exists'],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(TypePhonesRequest $request, $id)
    {
        $type = TypePhone::find($id);
        if ($type == null)
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        $validated = $request->validated();
        $type->title = $validated['title'];
        $type->push();
        if ($type->push()) return response()->json(['info' => 'update!']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $type = TypePhone::find($id);
        if ($type == null)
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        $type->delete();
        return response()->json(['info' => 'deleted!']);
    }
}
