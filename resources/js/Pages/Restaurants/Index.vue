<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue'; //DangerButtonコンポーネントの読み込み

import { Head } from '@inertiajs/vue3'; //<Head />でメタ情報を登録するためのタグ
import { Link } from '@inertiajs/vue3'; //ページを再読み込みさせずリンクさせるためのタグ
import { useForm } from '@inertiajs/vue3'; //削除ボタン用にformを使いたいのでインポート

const form = useForm({
  id: '', //レストラン1件削除用に追加するuseForm。レストランidをLaravelに送りたい
});
const deleteRestaurant = (id, name) => {
  if (confirm("Are you sure to delete " + name + "?")) {
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
            :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'">
          <i class="fa-solid fa-plus-circle"></i>　商品登録
          </Link>
        </div>

        <table class="table-auto border border-gray-400 w-full m-3">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-2 w-12 text-left">ID</th>
              <th class="px-4 py-2 w-48 text-left">レストラン</th>
              <th class="px-4 py-2 w-38 text-left">住所</th>
              <th class="px-4 py-2 w-28 text-left">行ったか</th>
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
              <td class="border border-gray-400 px-4 py-2 text-center">
                <Link :href="route('restaurants.edit', restaurant.id)"
                  :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md text-xs'">
                <i class="fa-solid fa-edit mr-1"></i>変更
                </Link>
              </td>
              <td class="border border-gray-400 px-4 py-2 text-center">
                <DangerButton @click="deleteRestaurant(restaurant.id, restaurant.name)">
                  <i class="fa-solid fa-trash"></i>
                </DangerButton>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
