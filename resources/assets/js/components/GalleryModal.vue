<template>
  <modal>
    <div class="gallery__controller">

      <!-- <div class="gallery__thumbs">
        <img :srcset="img.thumbQuery" sizes="(max-width: 767px) 50px, 100px" :src="img.mainImage" alt="Gallery image" v-for="(img, index) in gallery" :key="img.thumbQuery" @click="changeSlide(index)">
      </div> -->

      <div class="gallery__main">
        <!-- Slider main container -->
        <div class="swiper-container">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide" v-for="img in gallery" :key="img.mainImageQuery">
              <img :srcset="img.mainImageQuery" sizes="(max-width: 767px) 100w, 800px" :src="img.mainImage" alt="Gallery image">
            </div>
          </div>

          <div class="swiper-pagination"></div>

          <div class="swiper-button-prev" v-if="this.gallery.length > 1"></div>
          <div class="swiper-button-next" v-if="this.gallery.length > 1"></div>

        </div>

      </div>
    </div>

    <template slot="footer">
      <button class="button button-primary gallery__remove-btn" v-if="authorize('isAdmin')" @click="deleteModal">刪除</button>
      <div class="gallery__identifier" v-if="authorize('isAdmin')">{{ post.site.identifier }}</div>
    </template>
  </modal>
</template>

<script>
const THUMB_MAX_SM = 50; // thumbnail width in mobile
const THUMB_MAZ_LG = 100; // ... in desktop

import Modal from "./Modal.vue";
import Swiper from "swiper";
import axios from 'axios';
import { eventBus } from '../app';

export default {
  props: ["post"],
  components: { Modal },
  data() {
    return {
      gallery: "",
      swiper: ""
    };
  },
  mounted() {
    this.gallery = this.buildGallery(this.post);
  },
  updated() {
    if (this.gallery.length > 1) {
      let swiperConfig = {
        pagination: {
          el: ".swiper-pagination",
          type: "custom",
          clickable: true,
          renderCustom: function(swiper, current, total) {
            return current + " of " + total;
          }
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        }
      };

      if (!this.isMobile()) {
        swiperConfig = Object.assign(
          {
            slidesPerView: 3,
            spaceBetween: 30,
            freeMode: true,
            centeredSlides: true,
            grabCursor: true,
          },
          swiperConfig
        );
      }

      this.swiper = new Swiper(".swiper-container", swiperConfig);
    } else {
    }
  },
  methods: {
    buildGallery(post) {
      let images = [];

      post.images.forEach(image => {
        let queries = {};
        queries.thumbQuery = this.buildThumbQuery(image);
        queries.mainImageQuery = this.buildMainImageQuery(image);
        queries.mainImage = image.original.url;
        images.push(queries);
      });

      return images;
    },
    buildThumbQuery(img) {
      let query = "";

      img.alts
        .filter(alt => alt.width < 3 * this.getThumbWidth())
        .forEach((alt, i, arr) => {
          query += `${alt.url} ${alt.width}w`;
          if (i < arr.length - 1) {
            query += ",";
          }
        });

      return query;
    },
    buildMainImageQuery(img) {
      let query = "";

      img.alts.forEach((alt, i, arr) => {
        query += `${alt.url} ${alt.width}w,`;
      });

      query += `${img.original.url} ${img.original.width}w`;

      return query;
    },
    getThumbWidth() {
      return this.isMobile() ? THUMB_MAX_SM : THUMB_MAZ_LG;
    },
    changeSlide(index) {
      if (this.swiper) {
        this.swiper.slideTo(index + 1);
      }
    },
    deleteModal() {
      axios.delete(`/photosets/${this.post.id}`)
        .then(res => {
          eventBus.$emit('closeModal');
          flash('Photoset deleted');
        })
        .catch(err => console.log(err))
    }
  }
};
</script>

