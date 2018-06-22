<template>
    <div class="modal modal--upload fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLongTitle">上傳資源</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body js-file-upload-zone">
                    <div class="js-file-upload-preview-template">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-details-wrap">
                                <div class="dz-details">
                                    <div class="dz-filename">
                                        <span data-dz-name></span>
                                        <span class="dz-size" data-dz-size></span>
                                    </div>
                                    <div>
                                        <span data-dz-download-url></span>
                                    </div>
                                </div>
                                <div class="dz-error-message">
                                    <span data-dz-errormessage></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" v-show="hasFile">
                    <button class="button button-primary" @click="handleUpload">開始上傳</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Dropzone from "dropzone";

export default {
  data() {
    return {
      filezone: null,
    };
  },
  computed: {
    hasFile() {
      return this.filezone && this.filezone.files.length > 0;
    }
  },
  mounted() {
    const filezone = new Dropzone(".js-file-upload-zone", {
      url: "/files",
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
          .content
      },
      previewTemplate: document.querySelector(
        ".js-file-upload-preview-template"
      ).innerHTML,
      addRemoveLinks: true,
      autoProcessQueue: false,
      parallelUploads: 10,
      dictRemoveFile: '移除檔案',
      dictCancelUpload: '取消上傳',
      success: (file, res) => {
        // create a <a> tag with file link to download
        const downloadEl = document.createElement("a");
        downloadEl.setAttribute("href", res.link);
        downloadEl.setAttribute("target", "_blank");
        const downloadText = document.createTextNode("下載地址");
        downloadEl.appendChild(downloadText);
        // end

        file.link = res.link;
        file.id = res.id;

        file.previewElement
          .querySelector("[data-dz-download-url]")
          .appendChild(downloadEl);
      },
      removedfile: file => {
        if (file.status === "queued") {
          // do something when file in queued state
          console.log("file in queued state");
        } else if (file.status === "success") {
          // delete file from server
          axios.delete(`/files/${file.id}`)
            .then(res => {
              console.log(res);
            })
            .catch(err => {
              console.log(err);
            });
          console.log("file in success state");
        } else {
        }

        // common actions
        file.previewElement.remove();
      }
    });

    this.filezone = filezone;

    // filezone.on('addedfile', () => {
    //     console.log('addedfile');

    //     this.hasFile = true;
    // });
  },
  methods: {
    handleUpload() {
      this.filezone.processQueue();
    }
  }
};
</script>

<style lang="scss">
.dz-preview {
  font-size: 1.5rem;
  position: relative;
  z-index: 100;
  margin-bottom: 1.5rem;
}

.dz-started {
  &:before {
    opacity: 0.2;
  }
}

.dz-size {
  font-size: 1.3rem;
}

.dz-filename {
  text-overflow: ellipsis;
  overflow: hidden;
}

.dz-error {
  color: red;
}

.dz-success {
  color: green;
}

.dz-remove {
  color: #727272;
}
</style>
