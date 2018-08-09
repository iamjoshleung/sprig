<template>
    <div class="modal-backdrop" @click.self="close">
        <div class="sprig-modal">
            <div class="sprig-modal-header">
                <slot name="header"></slot>
                <div class="sprig-modal-cancel" @click="close()"></div>
                <div class="sprig-modal-tips">可按鍵盤上的ESC按鍵關閉</div>
            </div>

            <div class="sprig-modal-body">
                <slot></slot>
            </div>

            <div class="sprig-modal-footer">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>

<script>
import { eventBus } from "../app";

export default {
  mounted() {
    window.addEventListener("keydown", evt => {
      evt = evt || window.event;
      let isEscape = false;
      if ("key" in evt) {
        isEscape = evt.key == "Escape" || evt.key == "Esc";
      } else {
        isEscape = evt.keyCode == 27;
      }
      if (isEscape) {
        this.close();
      }
    });
  },
  methods: {
    close() {
      eventBus.$emit("closeModal");
    },
  }
};
</script>
