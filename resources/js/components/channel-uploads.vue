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
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{ width: `${video.percentage || progress[video.name]}%` }"
                    aria-valuemin="0" area-valuemax="100" aria-valuenow="49" >
                        {{ video.percentage ? video.percentage === 100 ? 'Video Processing Complete' : 'Processing' : 'Uploading' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div v-if="!video.thumbnail" class="d-flex justify-content-center align-items-center" style="height:180px; color:white; font-size:18px; background: #808080">
                            Loading thumbnail...
                        </div>
                        <img  v-else :src="video.thumbnail" style="width:100%" alt="">
                    </div>
                    <div class="col-md-4">
                        <a :href="`/videos/${video.id}`" v-if="video.percentage && video.percentage === 100" target="_blank"> {{ video.title }} </a>
                        <div class="text-center" v-else>
                            {{ video.title || video.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { setInterval, clearInterval } from 'timers';
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
                videos:[],
                progress:{},
                uploads:[],
                intervals:{}
            }
        },
        methods: {
            upload() {
                this.selected = true
                let videos = this.$refs.videos.files;
                this.videos = Array.from(videos)

                const uploaders = this.videos.map(video =>{
                    this.progress[video.name] = 0
                    const form = new FormData()
                    form.append('video', video)
                    form.append('title', video.name)
                    return axios.post(`/channels/${this.channel.id}/videos`, form, {
                        onUploadProgress: (event)=>{
                            console.log(event)
                            this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100)
                            this.$forceUpdate()
                        }
                    })
                        .then(({data}) => {
                            this.uploads = [
                                ...this.uploads,
                                data
                            ]
                        }).catch((err) => {
                            console.log(err)
                        });
                })

                axios.all(uploaders).then(()=>{
                    this.videos = this.uploads
                    this.videos.forEach(video=>{
                        this.intervals[video.id] = setInterval(()=>{
                            axios.get(`/videos/${video.id}`)
                                .then(({data})=>{
                                    if(data.percentage ==100){
                                        clearInterval(this.intervals[video.id])
                                    }
                                    this.videos = this.videos.map(v=>{
                                        if(v.id==data.id){
                                            return data
                                        }
                                        return v
                                    })
                                })
                        },3000)
                    })
                })
            }
        },
    }
</script>
