<template>
    <div class="l-sites">
        <section>
            <h1>Add new Tumblr site</h1>
            <div class="alert alert-danger" v-if="message.status === 422">{{ message.body }}</div>
            <form @submit.prevent="onSubmit">
                <div class="form-group">
                    <label for="exampleInputEmail1">Site URL</label>
                    <input type="text" class="form-control" v-model="formData.url">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </section>

        <section>
            <h1>Current Tumblr sites</h1>
            <table class="table" v-if="tumblrSites.length > 0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">URL</th>
                        <th scope="col">Identifier</th>
                        <th scope="col">Last Scrapped Images @</th>
                        <th scope="col">Last Scrapped Videos @</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(site, index) in tumblrSites" :key="index">
                        <th scope="row">{{ site.id }}</th>
                        <td>{{ site.url }}</td>
                        <td>{{ site.identifier }}</td>
                        <td>{{ site.last_scrapped_images_at }}</td>
                        <td>{{ site.last_scrapped_videos_at }}</td>
                        <td><a href="#" @click.prevent="destroy(site.id)">Remove</a></td>
                    </tr>
                </tbody>
            </table>
            <div v-else>Currently no site added</div>
        </section>
    </div>
</template>

<script>
export default {
  props: ["sites"],
  data() {
    return {
      formData: {
        url: ""
      },
      tumblrSites: this.sites,
      message: {
        status: "",
        body: ""
      }
    };
  },
  mounted() {
    // console.log(this.tumblrSites)
  },
  methods: {
    onSubmit() {
      axios
        .post("/cm/sites", this.formData)
        .then(({ data }) => {
          this.formData.url = "";
          this.tumblrSites.push(data);
        })
        .catch(err => {
          if (err.response.status === 422) {
            this.setMessage(422, "Site already exists.");
          }
        })
        .finally(_ => this.formData.url = '');
    },
    setMessage(status, msg) {
      this.message.status = status;
      this.message.body = msg;

      setTimeout(_ => this.setMessage('', ''), 3000);
    },
    destroy(id) {
      axios
        .delete(`/cm/sites/${id}`)
        .then(res => {
          this.tumblrSites = this.tumblrSites.filter(site => site.id !== id);

          //   this.$emit("deleted", id);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>