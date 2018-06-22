<template>
    <form class="form-inline mb-4">
        <div class="form-group">
            <label for="id">ID</label>
            <input type="text" id="id" class="form-control mx-sm-3" v-model="value">
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            value: ''
        }
    },
    watch: {
        value() {
            this.$emit('filter-changed', this.value);
        }
    }
}
</script>

<style lang="scss" scoped>
</style>
