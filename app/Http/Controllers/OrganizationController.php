<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|Response
     */
    public function index(Request $request)
    {
        if (isset($request['sortBy']))
            if (Schema::hasColumn('organizations', $request['sortBy']))
                return Organization::orderBy($request['sortBy'])->get();
        return Organization::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {
        $validated = $request->validated();
        return Organization::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse|Response
     */
    public function show($id)
    {
        return Organization::find($id) ?? response()
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
     * @return JsonResponse|Response
     */
    public function update(OrganizationRequest $request, $id)
    {
        $organization = Organization::find($id);
        if(!$organization)
            return response()
            ->json(
                ['errors' => 'no such entry exists'],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        $validated = $request->validated();
        $organization->title = $validated['title'];
        $organization->address = $validated['address'];
        if($organization->push()){
            return response()->json(['info' => 'update!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        if(!$organization)
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );

        if($organization->delete()){
            return response()->json(['info' => 'delete!']);
        }
    }
}
