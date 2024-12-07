<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// パスワード表示フラグ
const showPassword = ref(false);
const showPasswordConfirmation = ref(false); // パスワード確認用の表示フラグ

// フォームデータ
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="名前" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Eメール" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="パスワード" />
                <div class="relative">
                    <TextInput id="password" :type="showPassword ? 'text' : 'password'" class="mt-1 block w-full"
                        v-model="form.password" required autocomplete="new-password" />
                    <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-gray-500"
                        @click="showPassword = !showPassword">
                        {{ showPassword ? '非表示' : '表示' }}
                    </button>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="パスワード確認用" />
                <div class="relative">
                    <TextInput id="password_confirmation" :type="showPasswordConfirmation ? 'text' : 'password'"
                        class="mt-1 block w-full" v-model="form.password_confirmation" required
                        autocomplete="new-password" />
                    <button type="button" class="absolute inset-y-0 right-0 px-3 text-sm text-gray-500"
                        @click="showPasswordConfirmation = !showPasswordConfirmation">
                        {{ showPasswordConfirmation ? '非表示' : '表示' }}
                    </button>
                </div>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                すでに登録している方はこちら
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    新規登録
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
