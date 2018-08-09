<template>
    <div class="paginator" v-if="paginable">
        <div class="paginator__prev" :class="{ disabled: !prevable }" @click="goPrev()"></div>
        <div class="paginator__next" :class="{ disabled: !nextable }" @click="goNext()"></div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    computed: {
        paginable() {
            return this.data.next_page_url || this.data.prev_page_url;
        },
        prevable() {
            return !!this.data.prev_page_url;
        },
        nextable() {
            return !!this.data.next_page_url;
        }
    },
    methods: {
        goPrev() {
            return window.location = this.data.prev_page_url;
        },

        goNext() {
            return window.location = this.data.next_page_url;
        }
    }
}
</script>
