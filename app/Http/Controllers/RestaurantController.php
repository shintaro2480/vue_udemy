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
        // imagesリレーションをロードし、正しいカラムを選択
        $restaurant->load(['images' => function ($query) {
            $query->select(['id', 'restaurant_id', 'image_path', 'created_at', 'updated_at']);
        }]);

        // フルURLに変換する処理を追加
        $restaurant->images->each(function ($image) {
            // 修正: 正しいストレージのパスを取得
            $image->image_path = asset('storage/' . $image->image_path);
        });

        return Inertia::render('Restaurants/Edit', [
            'restaurant' => $restaurant
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        // バリデーション済みのリクエストデータを使用
        $validated = $request->validated();

        // データの更新処理（画像の保存など）
        $restaurant->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'go' => $validated['go'],
        ]);

        // 削除された画像の処理
        if ($request->has('deleted_images')) {
            $deletedImages = $request->input('deleted_images');
            $images = Image::whereIn('id', $deletedImages)->get();

            foreach ($images as $image) {
                // ストレージから画像ファイルを削除
                Storage::delete($image->image_path);

                // データベースから画像を削除
                $image->delete();
            }
        }

        return redirect()->route('restaurants.index')->with('success', 'レストランが更新されました');
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
