<template>
    <div class="l-files">
        <file-filter @filter-changed="filterFiles"></file-filter>
        <file-list :items="items"></file-list>
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
      items: []
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
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
