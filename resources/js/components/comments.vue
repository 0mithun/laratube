<template>
  <div class="card mt-5 p-5">
    <div class="form-inline my-4 w-full">
      <!-- <textarea name="comment" id rows="10" class="form-control w-80"></textarea> -->
      <input type="text" name id class="form-control w-80" />
      <button class="btn btn-primary btn-sm">Add Comment</button>
    </div>
    <div class="media my-3" v-for="(comment, index) in comments.data" :key="index">
      <!-- <img src="https://picsum.photos/id/42/200/200" class="rounded-circle mr-3" width="30" height="30" /> -->
      <Avatar :username="comment.user.name" :size="30" class="mr-3"></Avatar>
      <div class="media-body">
        <h6 class="mt-2">{{ comment.user.name }}</h6>
        <small>{{ comment.body }}</small>

        <replies :comment="comment" v-if="comment.replies_count > 0"></replies>

        <votes
          :default_votes="comment.votes"
          :entity_id="comment.id"
          :entity_owner="comment.user.id"
        ></votes>
      </div>
    </div>
    <div class="text-center">
      <button class="btn btn-success" @click="fetchComment" v-if="comments.next_page_url">Load More</button>
      <h3 v-else class="text-info">No More Comments</h3>
    </div>
  </div>
</template>

<script>
import Avatar from "vue-avatar";

import Replies from "./replies";

export default {
  props: {
    video: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  components: {
    Avatar,
    Replies
  },
  data() {
    return {
      comments: {
        data: []
      }
    };
  },
  mounted() {
    this.fetchComment();
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
    }
  }
};
</script>

<style>
</style>
