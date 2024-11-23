<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const goes = [{ id: true, name: '行った' }, { id: false, name: 'まだ行ってない' }];

const form = useForm({
  name: '',
  address: '',
  go: '',
});

const submit = () => {
  form.post(route('restaurants.store'), {
    onSuccess: () => form.reset('name', 'address', 'go'),
  });
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

        <div class="mt-3 mb-3 ml-3 flex">
          <Link :href="route('restaurants.index')"
            :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'">
          <i class="fa-solid fa-backward"></i> 戻る
          </Link>
        </div>

        <form @submit.prevent="submit">
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
