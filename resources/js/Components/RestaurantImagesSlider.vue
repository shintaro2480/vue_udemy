<template>
  <div :id="id" class="slider-pro">
    <!-- メインスライダー部分 -->
    <div class="sp-slides">
      <div class="sp-slide" v-for="(image, index) in safeImages" :key="index">
        <img :src="`/storage/${image.image_path}`" class="sp-image" alt="Restaurant Image" />
      </div>
    </div>
    <!-- サムネイル部分 -->
    <div class="sp-thumbnails">
      <img class="sp-thumbnail" v-for="(image, index) in safeImages" :key="'thumb-' + index"
        :src="`/storage/${image.image_path}`" alt="Thumbnail Image" />
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';

const props = defineProps({
  images: {
    type: Array,
    required: true
  },
  id: {
    type: String,
    required: true
  }
});

// 安全な画像リストを計算
const safeImages = computed(() => {
  if (!props.images || props.images.length === 0) {
    // デフォルトの「No Image」画像を挿入
    return [{ image_path: 'noimage.jpg' }];
  }
  return props.images;
});

onMounted(() => {
  $(`#${props.id}`).sliderPro({
    width: 600,
    buttons: false,
    shuffle: true,
    thumbnailWidth: 200,
    thumbnailHeight: 60,
    slideDistance: 0,
    breakpoints: {
      480: {
        thumbnailWidth: 110,
        thumbnailHeight: 40
      }
    }
  });
});
</script>

<style scoped>
/* スライダーのスタイル調整 */
#slider {
  margin: 0 auto;
}

.slider-pro {
  background-color: #dbd6cf;
}
</style>
