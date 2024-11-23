<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3'; //<Head />でメタ情報を登録するためのタグ
import { Link } from '@inertiajs/vue3'; //ページを再読み込みさせずリンクさせるためのタグ

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

        <table class="table-auto border border-gray-400 w-10/12 m-3">
          <thead>
            <tr class="bg-gray-100">
              <th class="px-4 py-2 w-12">ID</th>
              <th class="px-4 py-2 w-48">レストラン</th>
              <th class="px-4 py-2 w-28">住所</th>
              <th class="px-4 py-2 w-28 text-center">行ったか</th>
              <th class="px-4 py-2"></th>
              <th class="px-4 py-2"></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="restaurant in restaurants" :key="restaurant.id">
              <td class="border border-gray-400 px-4 py-2 text-center">{{ restaurant.id }}</td>
              <td class="border border-gray-400 px-4 py-2">{{ restaurant.name }}</td>
              <td class="border border-gray-400 px-4 py-2 text-center">{{ restaurant.address }}</td>
              <td class="border border-gray-400 px-4 py-2 text-right">{{ restaurant.go }}</td>
              <td class="border border-gray-400 px-4 py-2 text-center">
              </td>
              <td class="border border-gray-400 px-4 py-2 text-center">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
