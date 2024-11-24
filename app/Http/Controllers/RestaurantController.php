<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\RestaurantRequest;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        //dd($restaurants);
        return Inertia::render('Restaurants/Index', ['restaurants' => $restaurants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Restaurants/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request)
    {
        // バリデーション済みデータを取得
        $validatedData = $request->validated();

        // データを保存
        Restaurant::create($validatedData);

        // リダイレクトまたはレスポンスを返す
        return redirect()->route('restaurants.index')->with('success', 'レストランが登録されました！');
        //dd($request);
        //$request = new Request($request->input());
        //$request->save();
        return redirect('restaurants');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        //
        return Inertia::render('Restaurants/Edit', ['restaurant' => $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        //
        $restaurant->update($request->input());
        return redirect('restaurants');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        //
        $restaurant->delete();
        return redirect('restaurants');
    }
}
