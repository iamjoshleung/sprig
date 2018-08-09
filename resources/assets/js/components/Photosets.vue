<template>
    <div class="col-12 l-photosets--items js-grid" ref="grid">
        <div class="card js-grid-item" v-for="(post, i) in collection" :key="i">
            <img @click="selectPost(post)" class="card-img-top" :srcset="srcset(post)" sizes="(max-width: 767px) 100vw, (max-width: 991px) 50vw, 20vw" :src="post['images'][0]['alts'][0]['url']" alt="Cute guys">
        </div>
        <gallery-modal :post="currentPost" v-if="showModal"></gallery-modal>
    </div>
</template>

<script>
import Masonry from "isotope-layout";
import GalleryModal from './GalleryModal.vue';
import { eventBus } from '../app';

export default {
  props: ["data"],
  components: { GalleryModal },
  data() {
    return {
      collection: "",
      showModal: false,
      currentPost: ''
    };
  },
  mounted() {

    eventBus.$on('closeModal', () => {
      this.showModal = false;
    })

    this.collection = this.data.data;

    window.addEventListener('load', () => {
      let msnry = new Masonry(this.$refs.grid, {
        itemSelector: ".js-grid-item",
        percentPosition: true,
        masonry: {
            gutter: 8,
        }
      });
    });
  },
  updated() {},
  methods: {
    srcset(post) {
      let query = "";

      let lastAlt = post.images[0]["alts"].length - 1;
      post.images[0]["alts"].forEach((item, i) => {
        query += `${item.url} ${item.width}w`;
        if (i !== lastAlt) {
          query += ", ";
        }
      });

      return query;
    },
    selectPost(post) {
      this.showModal = true;
      this.currentPost = post;
    }
  }
};
</script>

