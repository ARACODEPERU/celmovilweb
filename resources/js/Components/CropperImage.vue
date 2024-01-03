<template>
    <div>
        <div v-if="isLoading">Cargando imagen...</div>
        <div v-else>
            <figure class="max-w-lg">
                <img v-if="imageSrc" :src="imageSrc" ref="image" alt="Image" class="h-auto max-w-full rounded-lg">
                <img v-else :src="imgDefault" class="h-auto max-w-full rounded-lg" >
                <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Captura de imagen</figcaption>
            </figure>
            <input type="file" ref="input" @change="onChange" class="block w-full mb-5 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
        </div>
    </div>
</template>
<script>
import 'cropperjs/dist/cropper.css';
import Cropper from 'cropperjs';

export default {
  props: {
    aspectRatio: {
      type: Number,
      default: 10 / 10
    },
    viewMode: {
      type: Number,
      default: 2
    },
    imgDefault:{
      type: String,
      default: '/img/image-3@2x.jpg'
    }
  },
  data() {
    return {
      imageSrc: '',
      isLoading: false
    };
  },
  methods: {
    onChange(event) {
      const files = event.target.files;
      if (files && files.length > 0) {
        this.isLoading = true;
        const reader = new FileReader();
        reader.onload = () => {
          this.imageSrc = reader.result;
          this.isLoading = false;
          this.initCropper();
        };
        reader.readAsDataURL(files[0]);
      }
    },
    initCropper() {
      const image = new Image();
      image.src = this.imageSrc;
      image.onload = () => {
        this.cropper = new Cropper(this.$refs.image, {
          aspectRatio: this.aspectRatio,
          viewMode: this.viewMode,
          crop : (event) => {
            this.cropImage()
          }
        });
      };
    },
    cropImage() {
      const croppedCanvas = this.cropper.getCroppedCanvas();
      if (croppedCanvas) {
        this.$emit('onCrop',croppedCanvas.toDataURL());
      }
    },
    resetCropper() {
      this.imageSrc = '';
      if (this.cropper) {
        this.cropper.destroy();
        this.cropper = null;
      }
    }
  }
};
</script>
