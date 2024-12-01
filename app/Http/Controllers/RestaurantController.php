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
        $restaurants = Restaurant::with('user', 'images')->get();
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

        // user_idを設定 (ログインしているユーザーのIDを使用)
        $validatedData['user_id'] = auth()->id();

        // Restaurantデータを保存
        $restaurant = Restaurant::create($validatedData);

        // 画像がアップロードされている場合
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // 画像をストレージに保存
                $path = $image->store('restaurant_images', 'public');

                // 画像データを restaurant_images テーブルに保存
                $restaurant->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // リダイレクトまたはレスポンスを返す
        return redirect()->route('restaurants.index')->with('success', 'レストランが登録されました！');
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
        // 画像を関連付けて取得
        $images = $restaurant->images; // imagesリレーションを利用

        return Inertia::render('Restaurants/Edit', ['restaurant' => $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'go' => 'required|boolean',
        ]);

        $restaurant->update($data);

        // 削除する画像の処理
        if ($request->has('imagesToRemove')) {
            $imagesToRemove = json_decode($request->imagesToRemove, true);
            foreach ($imagesToRemove as $imageId) {
                $image = $restaurant->images()->find($imageId);
                if ($image) {
                    // ストレージから削除
                    Storage::delete('public/' . $image->image_path);
                    $image->delete();
                }
            }
        }

        // 新しい画像の保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('restaurants', 'public');
                $restaurant->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('restaurants.index')->with('success', 'レストラン情報を更新しました。');
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
