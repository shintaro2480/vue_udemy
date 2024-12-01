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

const props = defineProps({
  restaurant: {
    type: Object,
  },
});

const form = useForm({
  name: props.restaurant.name,
  address: props.restaurant.address,
  go: props.restaurant.go,
  imagesToAdd: [], // 新規追加画像
  imagesToRemove: [], // 削除予定の画像ID
});

const previewImages = ref([]);

// 初期化処理（既存画像のプレビューを生成）
const initializePreviewImages = () => {
  previewImages.value = props.restaurant.images.map((image) => ({
    id: image.id,
    url: image.image_path,
    isNew: false, // 既存画像のフラグ
  }));
};
initializePreviewImages();

const handleFileChange = (event) => {
  const files = Array.from(event.target.files);
  addNewImages(files);
};

const addNewImages = (files) => {
  files.forEach((file) => {
    const newImage = {
      id: null,
      file,
      url: URL.createObjectURL(file),
      isNew: true, // 新規画像のフラグ
    };
    previewImages.value.push(newImage);
    form.imagesToAdd.push(file);
  });
};

const removeImage = (index) => {
  const image = previewImages.value[index];
  if (!image.isNew) {
    // 既存画像の場合は削除リストに追加
    form.imagesToRemove.push(image.id);
  }
  previewImages.value.splice(index, 1);
};

const submit = () => {
  const formData = new FormData();
  formData.append('name', form.name);
  formData.append('address', form.address);
  formData.append('go', form.go);

  // 新規画像をFormDataに追加
  form.imagesToAdd.forEach((file, index) => {
    formData.append(`images[${index}]`, file);
  });

  // 削除する画像のIDリストを追加
  formData.append('imagesToRemove', JSON.stringify(form.imagesToRemove));

  form.patch(route('restaurants.update', props.restaurant), {
    data: formData,
    headers: { 'Content-Type': 'multipart/form-data' },
    onSuccess: () => {
      form.reset('name', 'address', 'go', 'imagesToAdd', 'imagesToRemove');
      previewImages.value = [];
      initializePreviewImages(); // プレビューを再初期化
    },
  });
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
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <!-- 名前 -->
          <div class="mt-4">
            <InputLabel for="name" value="名前" />
            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- 住所 -->
          <div class="mt-4">
            <InputLabel for="address" value="住所" />
            <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required />
            <InputError class="mt-2" :message="form.errors.address" />
          </div>

          <!-- 行ったことあるか -->
          <div class="mt-4">
            <InputLabel for="go" value="行ったことあるか" />
            <SelectInput :options="goes" id="go" class="mt-1 block w-full" v-model="form.go" required />
            <InputError class="mt-2" :message="form.errors.go" />
          </div>

          <!-- 画像アップロード -->
          <div class="mt-4">
            <InputLabel for="images" value="画像アップロード" />
            <input type="file" id="images" multiple @change="handleFileChange" />

            <div class="flex mt-2">
              <div v-for="(image, index) in previewImages" :key="index" class="relative w-24 h-24 mr-2">
                <img :src="image.url" class="object-cover w-full h-full" />
                <button type="button" @click="removeImage(index)"
                  class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full">×</button>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">更新</PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
