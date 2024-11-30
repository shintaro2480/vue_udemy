<template>
  <div :id="id" class="slider-pro">
    <div class="sp-slides">
      <div class="sp-slide" v-for="(image, index) in images" :key="index">
        <img :src="`/storage/${image.image_path}`" class="sp-image" alt="Restaurant Image">
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';

const props = defineProps({
  images: {
    type: Array,
    required: true
  },
  id: { type: String, required: true }, // 親コンポーネントから受け取るユニークなID
});

onMounted(() => {
  // 動的なIDをセレクタに反映
  $(`#${props.id}`).sliderPro({
    width: '500px',
    height: '500px',
    arrows: true,
    buttons: true,
    fade: true,
    autoplay: true
  });
});
</script>

<style scoped>
/* スライダーのスタイル調整 */
#slider {
  margin: 0 auto;
}
</style>
