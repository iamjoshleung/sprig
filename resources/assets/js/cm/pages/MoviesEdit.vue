<script>
export default {
  methods: {
    removePreviewImg($movieId, $previewId) {
      axios
        .delete(`/cm/movies/${$movieId}/previews/${$previewId}`)
        .then(_ => {
          flash("Preview image has been removed.", "success");
        })
        .catch(err => {
          flash("Something went wrong", "error");
          console.log(err);
        });
    },

    removeCoverImg($movieId, $coverId) {
      axios
        .delete(`/cm/movies/${$movieId}/cover/${$coverId}`)
        .then(_ => {
          flash("Cover image has been removed.", "success");
        })
        .catch(err => {
          flash("Something went wrong", "error");
          console.log(err);
        });
    }
  }
};
</script>
