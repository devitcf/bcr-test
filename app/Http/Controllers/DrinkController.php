<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DrinkController extends Controller
{
    const CAFFEINE_LIMIT = 500;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('drink.index', []);
    }

    public function list()
    {
        $records = Drink::query()->get(['id', 'name', 'caffeine', 'desc']);

        return ['status' => 'ok', 'records' => $records];
    }

    public function getLimit()
    {
        return ['status' => 'ok', 'limit' => self::CAFFEINE_LIMIT];
    }

    public function calculate(Request $request)
    {
        $limit = 500;

        $res = ['status' => 'fail'];

        $id = Arr::get($request, 'id', null);
        $qty = Arr::get($request, 'qty', null);

        if (empty($id) || ((int)$qty < 1)) {
            return array_merge($res, ['error' => 'invalid param']);
        }

        $record = Drink::query()->find($id);
        if (!$record) {
            return array_merge($res, ['error' => 'invalid coffee']);
        }

        $consumed_caffeine = $record->caffeine * $qty;
        $remaining_caffeine = $limit - $consumed_caffeine;
        $remaining_amount = floor($remaining_caffeine / $record->caffeine);

        return [
            'status' => 'ok',
            'limit' => $limit,
            'consumed_caffeine' => $consumed_caffeine,
            'quota' => ($remaining_amount <= 0) ? "You cannot consume any more $record->name." : "You can still consume $remaining_amount $record->name.",
        ];
    }
}
