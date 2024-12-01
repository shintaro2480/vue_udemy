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

const form = useForm({
  name: '',
  address: '',
  go: '',
  images: [],
});

const dropActive = ref(false); // ドラッグ中の状態を管理
const previewImages = ref([]); // プレビュー表示用の画像リスト

const submit = () => {
  const formData = new FormData();
  formData.append('name', form.name);
  formData.append('address', form.address);
  formData.append('go', form.go);

  // 画像を1つずつ追加
  form.images.forEach((file, index) => {
    formData.append(`images[${index}]`, file);
  });

  form.post(route('restaurants.store'), {
    data: formData,
    onSuccess: () => {
      form.reset('name', 'address', 'go', 'images');
      previewImages.value = []; // フォーム送信後にプレビュー画像をリセット
    },
    // FormDataの使用を明示
    headers: { 'Content-Type': 'multipart/form-data' },
  });
};

// ファイル選択時の処理
const handleFileChange = (event) => {
  const files = Array.from(event.target.files);
  form.images = [...form.images, ...files]; // 既存の画像に追加
  updatePreviewImages(form.images); // プレビュー画像を更新
};

// ドラッグ＆ドロップ時の処理
const handleDrop = (event) => {
  event.preventDefault();
  dropActive.value = false; // ドラッグ状態を解除
  if (event.dataTransfer.files) {
    const files = Array.from(event.dataTransfer.files);
    form.images = [...form.images, ...files]; // 既存の画像に追加
    updatePreviewImages(form.images); // プレビュー画像を更新
  }
};

// ドラッグオーバー時の処理
const handleDragOver = (event) => {
  event.preventDefault();
  dropActive.value = true; // ドラッグ状態を有効化
};

// ドラッグリーブ時の処理
const handleDragLeave = () => {
  dropActive.value = false; // ドラッグ状態を解除
};

// プレビュー画像の更新
const updatePreviewImages = (files) => {
  previewImages.value = files.map((file) => ({
    file,
    url: URL.createObjectURL(file), // 一時的なURLを作成してサムネイル表示
  }));
};

// 画像削除の処理
const removeImage = (index) => {
  // プレビューURLを解放
  URL.revokeObjectURL(previewImages.value[index].url);
  // form.images から削除
  form.images.splice(index, 1);
  // previewImages から削除
  previewImages.value.splice(index, 1);
};
</script>

<template>

  <Head title="商品登録" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品登録</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">商品登録</div>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data">
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

          <!-- ファイル選択部分 -->
          <div class="mt-4">
            <InputLabel for="images" value="画像アップロード" />
            <input type="file" id="images" multiple @change="handleFileChange" />

            <!-- ドラッグ＆ドロップエリア -->
            <div class="border-dashed border-2 border-gray-300 p-4 mt-4 text-center cursor-pointer"
              :class="{ 'border-blue-500 bg-blue-100': dropActive, 'border-gray-300 bg-white': !dropActive }"
              @drop="handleDrop" @dragover="handleDragOver" @dragleave="handleDragLeave">
              <p v-if="previewImages.length === 0">ここに画像をドラッグ＆ドロップしてください</p>
              <div class="flex" v-else>
                <div v-for="(image, index) in previewImages" :key="index"
                  class="relative w-24 h-24 overflow-hidden mr-2">
                  <img :src="image.url" class="object-cover w-full h-full" />
                  <!-- 削除ボタン -->
                  <button type="button" @click="removeImage(index)"
                    class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 deleteImage">
                    ×
                  </button>
                </div>
              </div>
            </div>

            <InputError class="mt-2" :message="form.errors.images" />
          </div>

          <div class="mt-4">
            <InputLabel for="go" value="行ったことあるか" />
            <SelectInput :options="goes" id="go" class="mt-1 block w-full" v-model="form.go" required
              autocomplete="tax" />
            <InputError class="mt-2" :message="form.errors.go" />
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              登録
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* ドラッグ＆ドロップエリアのスタイル */
.border-dashed {
  border-style: dashed;
}

button.deleteImage {
  width: 24px;
  height: 24px;
  padding: 0px;
}
</style>
