@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($video->editable())
                <form action="{{ route('video.update', $video->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                @endif
                    <div class="card-header">
                        {{ $video->title }}
                    </div>

                    <div class="card-body">

                        <video-js id="video" class="vjs-default-skin" controls preload="auto" width="640" height="268">
                                <source src='{{ asset(Storage::url("videos/{$video->id}/{$video->id}.m3u8")) }}' type="application/x-mpegURL">
                        </video-js>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mt-3">
                                    @if($video->editable())
                                        <input type="text" name="title" value="{{ $video->title }}" class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    @else

                                    {{  $video->title }}
                                    @endif
                                </h4>

                                {{ $video->views }} {{ str_plural('view', $video->views) }}
                            </div>
                            <votes :default_votes="{{ $video->votes }}" entity_id="{{ $video->id }}" entity_owner="{{ $video->channel->user_id }}"></votes>
                        </div>

                        <hr>

                        <div>
                            @if($video->editable())
                                <textarea name="description" id="" rows="3" class="form-control @error('description') is-invalid  @enderror">{{ $video->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <div class="text-right mt-4">
                                    <button class="btn btn-primary">Update Video Details</button>
                                </div>
                            @else
                                <p>{{ $video->description }}</p>
                            @endif
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="media">
                                <img src="" alt="" class="rounded-circle">
                                <div class="media-body ml-2">
                                    <h5 class="mt-0 mb-0">{{ $video->channel->name }}</h5>
                                    <span class="small">Published {{ $video->created_at->toFormattedDateString() }}</span>
                                </div>
                            </div>

                            <subscribe-button :channel="{{ $video->channel }}"  :initial-subscriptions="{{ $video->channel->subscriptions }}">

                            </subscribe-button>
                        </div>
                    </div>
                 @if($video->editable())
                </form>
                @endif
            </div>

            {{-- Comment Start --}}
                <comments :video="{{ $video }}"></comments>
            {{-- Comment End --}}

        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet">
    <style>
        .vjs-default-skin{
            width: 100%
        }
         <style>
        .vjs-default-skin {
            width: 100%;
        }
        .thumbs-up, .thumbs-down {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: currentColor;
        }
        .thumbs-down-active, .thumbs-up-active {
            color: #3EA6FF;
        }
        .thumbs-down {
            margin-left: 1rem;
        }
        .w-full {
            width: 100% !important;
        }
        .w-80 {
            width: 80% !important;
        }


    </style>
@endsection



@section('scripts')
    <script src='https://vjs.zencdn.net/7.5.4/video.js'></script>

    <script>
            window.CURRENT_VIDEO = "{{ $video->id }}"
    </script>

    <script src='{{ asset('js/player.js') }}'></script>
@endsection
