<template>
    <div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Filename</th>
                    <th scope="col">Size</th>
                    <th scope="col">Downloads</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr :key="file.hashId" v-for="file in items">
                    <td>{{ file.hashId }}</td>
                    <td>{{ file.name }}</td>
                    <td>{{ prettySize(file.size) }}</td>
                    <td class="text-center">{{ file.downloads }}</td>
                    <td>{{ file.created_at }}</td>
                    <td>
                        <a :href="file.link" target="_blank">Link</a>
                        <a href="#" @click.prevent="destroy(file.hashId)">Remove</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import prettyBytes from "pretty-bytes";

export default {
  props: ["items"],
  methods: {
    prettySize(size) {
      return prettyBytes(Number(size));
    },
    destroy(id) {
        axios.delete(`/cm/files/${id}`)
            .then(res => {
                this.$emit('deleted', id);
            })
            .catch(err => console.log(err));
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
