<template>
    <div class="l-videos" ref="pageVideo">
        <div class="l-videos__video-wrap">
            <component :is="'VideoPlayer'" :video="currentVideo" :key="currentVideo.video_url"></component>
        </div>

        <div class="l-videos__toolbar">
            <div class="action" @click="loadMore" :class="{ disabled: !hasMoreLoad }">
                <i class="fas fa-sync-alt"></i>
                <span>加載更多</span>
            </div>
        </div>

        <div class="l-videos__recommandations" ref="recommandations">
            <div class="swiper-container">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide" v-for="(video, i) in videos" :key="video.video_url + i" @click="switchVideo(video)">
                        <div class="card l-videos__selection-item">
                            <div class="card-img-top" :style="{ backgroundImage: `url(${video.thumbnail_url})` }"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VideoPlayer from "../components/VideoPlayer.vue";
import axios from "axios";
import Swiper from "swiper";
import SmoothScroll from "smooth-scroll";

export default {
  props: ["data"],
  components: { VideoPlayer },
  data() {
    return {
      paginator: this.data,
      videos: this.data.data,
      currentVideo: this.data.data[0],
      hasMoreLoad: this.data.next_page_url,
      swiper: '',
      scroll: ''
    };
  },
  mounted() {
    if (!this.isMobile()) {
      window.addEventListener("load", _ => {
        this.swiper = new Swiper(".swiper-container", {
          freeMode: true,
          grabCursor: true,
          slidesPerView: "auto",
          spaceBetween: 30
        });
      });
    } else {
        this.scroll = new SmoothScroll();
    }
  },
  watch: {
    paginator() {
      this.hasMoreLoad = Boolean(this.paginator.next_page_url);
      this.videos = this.paginator.data;
      this.$nextTick(_ => this.swiper.update());
    }
  },
  methods: {
    switchVideo(video) {
      this.currentVideo = video;

      if( this.isMobile ) {
          this.scroll.animateScroll(this.$refs.pageVideo);
      }
    },
    loadMore() {
      axios
        .get(`/videos?page=${this.paginator.current_page + 1}`)
        .then(({ data }) => {
          this.paginator = data;
          this.scrollToBeginning();
        })
        .catch(err => console.log(err));
    },
    scrollToBeginning() {
      this.$refs.recommandations.scrollLeft = 0;
    }
  }
};
</script>

