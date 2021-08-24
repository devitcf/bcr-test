<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
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
        $records = Drink::query()->get(['name', 'caffeine', 'desc']);

        return ['status' => 'ok', 'records' => $records];
    }
}
