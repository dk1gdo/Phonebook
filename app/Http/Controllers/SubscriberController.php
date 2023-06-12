<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SubscriberController extends Controller
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
            if (Schema::hasColumn('subscribers', $request['sortBy']))
                return Subscriber::with('organization', 'phones.typePhone')->orderBy($request['sortBy'])->get();
        return Subscriber::with('organization', 'phones.typePhone')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriberRequest $request)
    {
        $validated = $request->validated();
        return Subscriber::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return Subscriber::with('organization', 'phones.typePhone')->find($id) ?? response()
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubscriberRequest $request, $id)
    {
        $subscriber = Subscriber::find($id);
        if ($subscriber == null)
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        $validated = $request->validated();
        $subscriber->name = $validated['name'];
        $subscriber->address = $validated['address'];
        $subscriber->organization_id = $validated['organization_id'];
        $subscriber->note = $validated['note'] ?? null;
        if ($subscriber->push()) return response()->json(['info' => 'update!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);
        if ($subscriber == null)
            return response()
                ->json(
                    ['errors' => 'no such entry exists'],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
        $subscriber->delete();
        return response()->json(['info' => 'deleted!']);
    }
}
