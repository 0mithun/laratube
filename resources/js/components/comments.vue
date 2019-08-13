<template>
  <div class="card mt-5 p-5">
    <div class="form-inline my-4 w-full" v-if="auth">
      <input v-model="newComment" type="text" name id class="form-control w-80" />
      <button class="btn btn-primary btn-sm" @click="addComment">Add Comment</button>
    </div>
    <comment v-for="comment in comments.data" :key="comment.id" :comment="comment"></comment>
    <div class="text-center">
      <button class="btn btn-success" @click="fetchComment" v-if="comments.next_page_url">Load More</button>
      <h3 v-else class="text-info">No More Comments</h3>
    </div>
  </div>
</template>

<script>
import Comment from "./comment";

export default {
  props: {
    video: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  components: {
    Comment
  },
  data() {
    return {
      comments: {
        data: []
      },
      newComment: ""
    };
  },
  mounted() {
    this.fetchComment();
  },
  computed: {
    auth() {
      return __auth();
    }
  },
  methods: {
    fetchComment() {
      const url = this.comments.next_page_url
        ? this.comments.next_page_url
        : `/videos/${this.video.id}/comments`;
      axios
        .get(url)
        .then(({ data }) => {
          this.comments = {
            ...data,
            data: [...this.comments.data, ...data.data]
          };
        })
        .catch(err => {
          console.log(err);
        });
    },
    addComment() {
      if (!this.newComment) return;
      axios
        .post(`/comments/${this.video.id}`, {
          video_id: this.video.id,
          body: this.newComment
        })
        .then(({ data }) => {
          this.newComment = "";
          this.comments = {
            ...this.comments,
            data: [data, ...this.comments.data]
          };
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

<style>
</style>
