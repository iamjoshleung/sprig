<template>
    <nav aria-label="..." v-if="isPaginable">
        <ul class="pagination">
            <li class="page-item" :class="{ disabled: !preUrl }">
                <a class="page-link" href="#" tabindex="-1" @click.prevent="page--">Previous</a>
            </li>
            <li class="page-item" :class="{ disabled: !nextUrl }">
                <a class="page-link" href="#" @click.prevent="page++">Next</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            page: 1,
            preUrl: false,
            nextUrl: false
        }
    },
    watch: {
        data() {
            this.page = this.data.current_page;
            this.preUrl = this.data.prev_page_url;
            this.nextUrl = this.data.next_page_url;
        },
        page() {
            this.broadcast().pushState();
        }
    },
    computed: {
        isPaginable() {
            return this.data.prev_page_url || this.data.last_page_url;
        }
    },
    methods: {
        broadcast() {
            return this.$emit('changed', this.page);
        },
        pushState() {
            history.pushState(null, null, `?page=${this.page}`);
        }
    }
}
</script>

<style lang="scss" scoped>
</style>
