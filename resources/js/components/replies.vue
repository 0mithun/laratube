<template>
  <div>
    <div class="media mt-3" v-for="(reply,index) in replies.data" :key="index">
      <a href class="mr-3">
        <!-- <img
        src="https://picsum.photos/id/42/200/200"
        alt
        class="rounde-circle mr-3"
        width="30"
        height="30"
        />-->
        <Avatar :username="reply.user.name" :size="30" class="mr-3"></Avatar>
      </a>
      <div class="media-body">
        <h6 class="mt-2">{{ reply.user.name }}</h6>
        <small>{{ reply.body }}</small>
        <votes :default_votes="reply.votes" :entity_id="reply.id" :entity_owner="reply.user.id"></votes>
      </div>
    </div>
    <div class="text-center" v-if="comment.replies_count > 0 && replies.next_page_url">
      <button class="btn btn-info btn-sm" @click="fetchReplies">Load Reply</button>
    </div>
  </div>
</template>

<script>
import Avatar from "vue-avatar";

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
      replies: {
        data: [],
        next_page_url: `/comments/${this.comment.id}/replies`
      }
    };
  },
  components: {
    Avatar
  },
  methods: {
    fetchReplies() {
      const url = this.replies.next_page_url
        ? this.replies.next_page_url
        : `/comments/${this.comment.id}/replies`;
      axios
        .get(this.replies.next_page_url)
        .then(({ data }) => {
          this.replies = {
            ...data,
            data: [...this.replies.data, ...data.data]
          };
        })
        .catch(err => {
          console.log(err);
        });
    },
    newReply(reply) {
      this.replies = {
        ...this.replies,
        data: [reply, ...this.replies.data]
      };
    }
  }
};
</script>

<style>
</style>
