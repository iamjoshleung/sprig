<template>
  <div>
    <div class="file-info">
      <h1 class="file-info__name">{{ file.name }}</h1>
      <div class="file-info__size">{{ prettySize }}</div>
    </div>
    <div class="download-steps">
      <!-- klouderr 728-2 -->
      <!-- <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4679085340013866" data-ad-slot="7988482236"></ins> -->

      <h2 class="mt-4">下載步驟</h2>

      <div class="step step1" v-if="currentStep === 1">
        <h3 class="step__heading mb-5">1. 驗證你人類的身份</h3>
        <form action="">
          <div class="g-recaptcha d-inline-block" data-callback="getResponseCode" data-sitekey="6LeJVWAUAAAAAKaPN3fOja9vS54P27n1Ygp-mdHc"></div>
          <!-- <div class="mt-3">
                        <button type="submit" class="button button-primary">驗證</button>
                    </div> -->
        </form>
      </div>

      <div class="step step2" v-else-if="currentStep === 2">
        <h3 class="step__heading">2. 等待 {{ countDownNum }} 秒</h3>
        <div class="progress--circle" :class="`progress--${progress}`">
            <div class="progress__number">{{ progress }}%</div>
        </div>
        <!-- <div class="circle">
          <div class="count">{{ countDownNum }}</div>
          <div class="l-half"></div>
          <div class="r-half"></div>
        </div> -->
      </div>

      <div class="step step3" v-else>
        <h3 class="step__heading">3. 可以下載了</h3>
        <div class="mt-3">
          <a target="_blank" :href="`/files/${this.data.hashId}/download/${this.downloadToken}`" class="button button-secondary" :class="{ 'disabled': isDownloaded }" @click.once="downloadFile()">立即下載</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { eventBus } from "../app";
import Visibility from "visibilityjs";

export default {
  props: ["file"],
  data() {
    return {
      countDownNum: 20,
      currentStep: 1,
      downloadToken: "",
      data: this.file,
      isDownloaded: false,
      progress: 0,
      msg: {
        status: "",
        body: ""
      }
    };
  },
  computed: {
    // https://gist.github.com/lanqy/5193417
    prettySize() {
      return this.bytesToSize(Number(this.file.size));
    }
  },
  mounted() {
    // const adsbygoogle = (window.adsbygoogle || []).push({});
  },
  created() {
    eventBus.$on("receivedResCode", token => {
      this.verifyRecaptcha(token);
    });
  },
  methods: {
    bytesToSize(bytes) {
      const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
      if (bytes === 0) return "n/a";
      const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
      if (i === 0) return `${bytes} ${sizes[i]})`;
      return `${(bytes / 1024 ** i).toFixed(1)} ${sizes[i]}`;
    },
    verifyRecaptcha(token) {
      axios
        .post("/verify-recaptcha", {
          "g-recaptcha-response": token
        })
        .then(res => {
          this.currentStep = 2;
          this.startCountDown();
          this.getDownloadToken();
        })
        .catch(err => {
          console.error("Error with the recaptcha.");
        });
    },
    startCountDown() {
      // setInterval(() => {
      //   if (this.countDownNum >= 0) {
      //     this.countDownNum -= 1;
      //   }
      // }, 1000);

      const visibleId = Visibility.every(1000, () => {
        if (this.countDownNum >= 0) {
          this.countDownNum -= 1;
          this.progress += 5;
        } else {
          Visibility.stop(visibleId);
        }
      });
    },
    getDownloadToken() {
      axios
        .get(`/files/${this.data.hashId}/token`)
        .then(({ data }) => {
          this.downloadToken = data.token;
        })
        .catch(err => {
          console.log(err);
        });
    },
    downloadFile() {
      // if(this.downloadToken) {
      //   axios.get(`/files/${this.data.hashId}/download/${this.downloadToken}`);
      // } else {
      //   this.msg.status = 'error';
      //   this.msg.body = 'Invalid download, missing token';
      // }
      // window.location = `/files/${this.data.hashId}/download/${this.downloadToken}`;
      setTimeout(() => {
        this.isDownloaded = true;
      }, 0);
    }
  },
  watch: {
    countDownNum() {
      if (this.countDownNum <= 0) {
        this.currentStep = 3;
      }
    }
  }
};
</script>

<style lang="scss">
.download-steps {
  margin-top: 4rem;
}

.step {
  margin-top: 2rem;

  &__heading {
    margin-bottom: 0.9rem;
  }
}

@keyframes l-rotate {
  0% {
    -webkit-transform: rotate(0deg);
  }
  50% {
    -webkit-transform: rotate(-180deg);
  }
  100% {
    -webkit-transform: rotate(-180deg);
  }
}

@keyframes r-rotate {
  0% {
    -webkit-transform: rotate(0deg);
  }
  50% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(-180deg);
  }
}

@keyframes fadeout {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0.5;
  }
}

$d: 100;
$w: 20;
$t: 20;

/* -- CIRCLE -- */

.circle {
  width: $d + px;
  height: $d + px;
  display: inline-block;
  position: relative;
  border-radius: 999px;
  box-shadow: inset 0 0 0 $w + px rgba(#9dd668, 0.5);
}

.l-half,
.r-half {
  float: left;
  width: 50%;
  height: 100%;
  overflow: hidden;

  &:before {
    content: "";
    display: block;
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    border: $w + px solid #fff;
    animation-duration: $t + s;
    animation-iteration-count: 1;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
  }
}

.l-half:before {
  border-right: none;
  border-top-left-radius: 999px;
  border-bottom-left-radius: 999px;
  transform-origin: center right;
  animation-name: l-rotate;
}

.r-half:before {
  border-left: none;
  border-top-right-radius: 999px;
  border-bottom-right-radius: 999px;
  transform-origin: center left;
  animation-name: r-rotate;
}

/* -- TIMER -- */

.count {
  position: absolute;
  width: 100%;
  line-height: $d + px;
  text-align: center;
  font-weight: 800;
  font-size: (($d - ($w * 2)) / 2) + px;
  font-family: Helvetica;
  color: #fff;
  z-index: 2;
  animation: fadeout 0.5s ($t + 1) + s 1 linear;
  animation-fill-mode: forwards;
}
</style>
