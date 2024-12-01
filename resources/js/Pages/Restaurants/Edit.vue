<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const goes = [{ id: true, name: '行った' }, { id: false, name: 'まだ行ってない' }];
import { defineProps, onMounted } from 'vue';

const props =
  defineProps({
    restaurant: {
      type: Object,
      required: true,
    },
  });

// コンポーネントがマウントされた後にデータを確認
onMounted(() => {
  console.log(props.restaurant);

});



const form = useForm({
  name: props.restaurant.name,
  address: props.restaurant.address,
  go: props.restaurant.go,
  images: props.restaurant.images || [],
});

const deletedImages = ref([]); // 削除した画像のIDを格納する配列

const submit = () => {
  form.patch(route('restaurants.update', props.restaurant), {
    // 送信するデータに削除された画像IDを追加
    deleted_images: deletedImages.value,
    onSuccess: () => form.reset('name', 'address', 'go'),
  });
};

// 画像削除処理
const deleteImage = (index) => {

  console.log(form.images);

  // imagesが空でない場合のみ処理を行う
  if (form.images && form.images.length > 0) {
    const image = form.images[index];
    if (image) {
      deletedImages.value.push(image.id); // 削除した画像IDを追加
      form.images.splice(index, 1); // 配列から画像を削除
    }
  }


};
</script>

<template>

  <Head title="レストラン編集" />


  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">レストラン編集</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">レストラン編集</div>
        </div>

        <div class="mt-3 mb-3 ml-3 flex">
          <Link :href="route('restaurants.index')"
            :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'">
          <i class="fa-solid fa-backward"></i> 戻る
          </Link>
        </div>

        <form @submit.prevent="submit">

          <div>
            <h3>画像一覧</h3>
            <div v-if="restaurant.images && restaurant.images.length > 0">
              <div v-for="(image, index) in restaurant.images" :key="image.id">
                <img :src="image.image_path" :alt="'Image ' + index" class="restaurant-image" />
                <p>画像 ID: {{ image.id }}</p>
                <button @click="deleteImage(index)">画像を削除</button>
              </div>
            </div>
            <div v-else>
              <p>画像はありません。</p>
            </div>
          </div>

          <div class="mt-4">
            <InputLabel for="name" value="名前" />
            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
              autocomplete="name" />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <div class="mt-4">
            <InputLabel for="address" value="住所" />
            <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required
              autocomplete="address" />
            <InputError class="mt-2" :message="form.errors.address" />
          </div>

          <div class="mt-4">
            <InputLabel for="go" value="行ったことあるか" />
            <SelectInput :options="goes" id="go" class="mt-1 block w-full" v-model="form.go" required
              autocomplete="go" />
            <InputError class="mt-2" :message="form.errors.go" />
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              更新
            </PrimaryButton>
          </div>
        </form>


      </div>
    </div>
  </AuthenticatedLayout>
</template>
