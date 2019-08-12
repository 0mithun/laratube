<template>
    <div class="col-md-8">
        <input id="video-file" type="file" ref="videos" style="display: none;" @change="upload" multiple>
        <div class="card p-3 d-flex justify-content-center align-items-center" v-if="!selected">
            <svg onclick="document.getElementById('video-file').click()"
            width="70px" height="70px" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 461 461"><path d="M365.26 67.4H95.74A95.74 95.74 0 0 0 0 163.13v134.73a95.74 95.74 0 0 0 95.74 95.74h269.52A95.74 95.74 0 0 0 461 297.87V163.14a95.74 95.74 0 0 0-95.74-95.75zM300.5 237.05l-126.06 60.12a5.06 5.06 0 0 1-7.24-4.57v-124a5.06 5.06 0 0 1 7.34-4.52l126.06 63.88a5.06 5.06 0 0 1-.1 9.09z" fill="#f61c0d"/></svg>
            <p class="text-center">
                Upload Videos
            </p>
        </div>
        <div class="card p-3" v-else>
            <div class="my-4" v-for="(video, index) in videos" :key="index">
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:49%"
                    role="progress-bar" aria-valuemin="0" area-valuemax="100" aria-valuenow="49" ></div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-center align-items-center" style="height:180px; color:white; font-size:18px">
                            Loading thumbnail...
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            {{ video.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            channel:{
                type: Object,
                required: true,
                default: ()=> ({})
            }
        },
        data(){
            return{
                selected:false,
                videos:[]
            }
        },
        methods: {
            upload() {
                this.selected = true
                let videos = this.$refs.videos.files;
                this.videos = Array.from(videos)

                const uploaders = this.videos.map(video =>{
                    const form = new FormData()
                    form.append('video', video)
                    form.append('title', video.name)
                    return axios.post(`/channels/${this.channel.id}/videos`, form)
                        .then((result) => {
                            console.log(result)
                        }).catch((err) => {
                            console.log(err)
                        });
                })
            }
        },
    }
</script>
