<template>
    <div class="l-files">
        <div class="alert alert-success" v-show="message">{{ message }}</div>
        <file-filter @filter-changed="filterFiles"></file-filter>
        <file-list :items="items" @deleted="handleDeletion"></file-list>
        <paginator :data="data" @changed="toPage"></paginator>
    </div>
</template>

<script>
import FileList from "../components/FileList.vue";
import Paginator from "../components/Paginator.vue";
import FileFilter from '../components/FileFilter.vue';

export default {
  data() {
    return {
      data: "",
      items: [],
      message: ''
    };
  },
  components: {
    FileList,
    Paginator,
    FileFilter
  },
  created() {
      const page = 1;
      this.fetch(page);
  },
  methods: {
    fetch(page = 1) {
      axios
        .get(`/cm/files?page=${page}`)
        .then(({ data }) => {
          this.data = data;
          this.items = data.data;
        })
        .catch(err => console.log(err));
    },
    toPage(page) {
      this.fetch(page);
    },
    filterFiles(val) {
        this.items = this.data.data.filter(item => {
            return item.hashId.includes(val);
        });
    },
    handleDeletion(id) {
      this.items = this.items.filter(item => item.hashId !== id);
      this.message = `File with id ${id} has been deleted`;

      setTimeout(() => {
        this.message = '';
      }, 2000);
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
