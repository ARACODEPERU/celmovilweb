<template>
  <div>
    <div v-if="isLoading">Cargando imagen...</div>
    <div v-else>
      <input type="file" ref="input" @change="onChange">
      <img ref="image" :src="imageSrc" alt="Image" style="max-width: 100%; height: auto;">
    </div>
  </div>
</template>
<script>
import 'cropperjs/dist/cropper.css';
import Cropper from 'cropperjs';

export default {
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
          aspectRatio: 10 / 10,
          viewMode: 2,
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
