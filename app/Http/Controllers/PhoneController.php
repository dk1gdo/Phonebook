<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Models\Phone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        if (isset($request['sortBy']))
            if (Schema::hasColumn('phones', $request['sortBy']))
                return Phone::with('typePhone', 'subscriber')->orderBy($request['sortBy'])->get();
        return Phone::with('typePhone', 'subscriber')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhoneRequest $request)
    {
        $validated = $request->validated();
        return Phone::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Phone::with('typePhone', 'subscriber')->find($id) ?? response()
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
     * @return \Illuminate\Http\Response
     */
    public function update(PhoneRequest $request, $id)
    {
        $phone = Phone::find($id);
        if(!$phone) {
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        }
        $vaidated = $request->validated();
        $phone->number = $vaidated['number'];
        $phone->subscriber_id = $vaidated['subscriber_id'];
        $phone->type_phone_id = $vaidated['type_phone_id'];
        if ($phone->push()) return response()->json(['info' => 'update!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone = Phone::find($id);
        if(!$phone) {
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        }
        if ($phone->delete()) return response()->json(['info' => 'deleted!']);
    }
}
