<template>
  <div class="media my-3">
    <!-- <img src="https://picsum.photos/id/42/200/200" class="rounded-circle mr-3" width="30" height="30" /> -->
    <Avatar :username="comment.user.name" :size="30" class="mr-3"></Avatar>
    <div class="media-body">
      <h6 class="mt-2">{{ comment.user.name }}</h6>
      <small>{{ comment.body }}</small>

      <div class="d-flex">
        <votes
          :default_votes="comment.votes"
          :entity_id="comment.id"
          :entity_owner="comment.user.id"
        ></votes>
        <button
          class="btn btn-sm ml-2"
          :class="{'btn-default': !addingReply, 'btn-danger': addingReply}"
          @click="addingReply = !addingReply"
        >{{ addingReply ? "Cancel" : "Add Reply" }}</button>
      </div>
      <div class="form-inline my-4 w-full" v-if="addingReply">
        <input v-model="body" type="text" name id class="form-control w-80" />
        <button class="btn btn-primary btn-sm" @click="addReply">Add Reply</button>
      </div>
      <replies :comment="comment" v-if="comment.replies_count > 0" ref="replies"></replies>
    </div>
  </div>
</template>

<script>
import Avatar from "vue-avatar";
import Replies from "./replies";

export default {
  props: {
    comment: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  data() {
    return {
      addingReply: false,
      body: ""
    };
  },
  components: {
    Avatar,
    Replies
  },
  methods: {
    addReply() {
      if (!this.body) return;

      axios
        .post(`/comments/${this.comment.video_id}`, {
          video_id: this.comment.video_id,
          comment_id: this.comment.id,
          body: this.body
        })
        .then(({ data }) => {
          this.$refs.replies.newReply(data);

          this.body = "";
          this.addingReply = false;
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
