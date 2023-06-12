<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    /**
     * Поиск контактов
     *
     * @param Request $request
     * @param $str
     * @return LengthAwarePaginator|Response
     */
    public function __invoke(Request $request, $str)
    {
        if (isset($request['sortBy']))
            if (Schema::hasColumn('subscribers', $request['sortBy']))
                return Subscriber::with('organization', 'phones.typePhone')
                    ->orderBy($request['sortBy'])
                    ->whereHas('phones', function ($query) use ($str) {
                        $query->where('number', 'like', "%$str%");
                    })
                    ->orWhereHas('organization', function ($query) use ($str) {
                        $query->where('title', 'like', "%$str%");
                    })
                    ->orWhere('name', 'like', "%$str%")
                    ->paginate(10);;
        return Subscriber::with('organization', 'phones.typePhone')
            ->whereHas('phones', function ($query) use ($str) {
                $query->where('number', 'like', "%$str%");
            })
            ->orWhereHas('organization', function ($query) use ($str) {
                $query->where('title', 'like', "%$str%");
            })
            ->orWhere('name', 'like', "%$str%")
            ->paginate(10);
    }
}
