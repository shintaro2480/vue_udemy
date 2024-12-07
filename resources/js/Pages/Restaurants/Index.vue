<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue'; //DangerButtonコンポーネントの読み込み

import RestaurantImagesSlider from '@/Components/RestaurantImagesSlider.vue';


import { Head } from '@inertiajs/vue3'; //<Head />でメタ情報を登録するためのタグ
import { Link } from '@inertiajs/vue3'; //ページを再読み込みさせずリンクさせるためのタグ
import { useForm } from '@inertiajs/vue3'; //削除ボタン用にformを使いたいのでインポート

const form = useForm({
  id: '', //レストラン1件削除用に追加するuseForm。レストランidをLaravelに送りたい
});
const deleteRestaurant = (id, name) => {
  if (confirm(name + " を本当に削除しますか?")) {
    form.delete(route('restaurants.destroy', id));
  }
}

//以下で、Inertiaから渡されたデータを扱える
const props = defineProps({
  restaurants: { type: Object }
});

</script>

<template>

  <Head title="行きたいレストラン" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        行きたいレストラン
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        <div class="mt-3 mb-3 ml-3 flex">
          <Link :href="route('restaurants.create')"
            :class="'px-4 py-2 bg-orange-500 text-white border rounded-md font-semibold text-xs'">
          <i class="fa-solid fa-plus-circle"></i>　商品登録
          </Link>
        </div>

        <!--
        <table class="table-auto border border-gray-400 w-full m-3">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-2 w-12 text-left">ID</th>
              <th class="px-4 py-2 w-48 text-left">レストラン</th>
              <th class="px-4 py-2 w-38 text-left">住所</th>
              <th class="px-4 py-2 w-28 text-left">行ったか</th>
              <th class="px-4 py-2 text-left">投稿者</th>
              <th class="px-4 py-2">画像</th>
              <th class="px-4 py-2"></th>
              <th class="px-4 py-2"></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="restaurant in restaurants" :key="restaurant.id">
              <td class="border border-gray-400 px-4 py-2 text-left">{{ restaurant.id }}</td>
              <td class="border border-gray-400 px-4 py-2 text-left">{{ restaurant.name }}</td>
              <td class="border border-gray-400 px-4 py-2 text-left">{{ restaurant.address }}</td>
              <td class="border border-gray-400 px-4 py-2 text-left">

                {{ restaurant.go ? '行った' : '行ったことない' }}
              </td>
              <td class="border border-gray-400 px-4 py-2 text-left">
                {{ restaurant.user.name }}
              </td>

              <td class="border border-gray-400 px-4 py-2 text-center">
                <Link :href="route('restaurants.edit', restaurant.id)"
                  :class="'px-4 py-2 bg-orange-500 text-white border rounded-md text-xs'">
                <i class="fa-solid fa-edit mr-1"></i>変更
                </Link>
              </td>
              <td class="border border-gray-400 px-4 py-2 text-center">
                <DangerButton @click="deleteRestaurant(restaurant.id, restaurant.name)">
                  <i class="fa-solid fa-trash"></i>
                </DangerButton>
              </td>
              <td class="border border-gray-400 px-4 py-2 text-center">

                <RestaurantImagesSlider v-if="restaurant.images && restaurant.images.length > 0"
                  :id="'slider-' + restaurant.id" :images="restaurant.images" />


              </td>
            </tr>
          </tbody>
        </table>
      -->




        <section class="text-gray-600 body-font">
          <div class="container px-5 py-1 mx-auto">
            <div class="flex flex-wrap -m-4">


              <div class="p-4 md:w-1/3" v-for="restaurant in restaurants" :key="restaurant.id">
                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">



                  <div class="p-6">

                    <div class="min-h-44" style="background-color:#c1b4ac;">
                      <RestaurantImagesSlider v-if="restaurant.images && restaurant.images.length > 0"
                        :id="'sliderimage-' + restaurant.id" :images="restaurant.images" />
                    </div>

                    <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ restaurant.address
                      }}
                    </h2>
                    <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ restaurant.name }}</h1>
                    <p class="leading-relaxed mb-3">{{ restaurant.go ? '行った' : '行ったことない' }}</p>
                    <div class="flex items-center flex-wrap">

                      <Link :href="route('restaurants.edit', restaurant.id)"
                        :class="'px-4 py-2 mr-2 bg-orange-500 active:bg-orange-700 text-white border rounded-md text-xs'">
                      <i class="fa-solid fa-edit mr-1"></i>変更
                      </Link>

                      <DangerButton @click="deleteRestaurant(restaurant.id, restaurant.name)">
                        <font-awesome-icon :icon="['fas', 'trash-can']" />
                      </DangerButton>

                    </div>
                  </div>
                </div>
              </div>



            </div>
          </div>
        </section>






      </div>
    </div>

  </AuthenticatedLayout>
</template>
