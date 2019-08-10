@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $channel->name }}</div>

                <div class="card-body">
                <div class="justify-content-center">
                <p class="text-center"><img src="{{ $channel->image() }}" alt=""></p>
                    <br>
                    <h3 class="text-center">{{ $channel->name }}</h3>
                    <p class="">{{ $channel->description }}</p>
                </div>
                    @if($channel->editable())
                        <hr>
                        <form id="update-channel-form" action="{{ route('channels.update', $channel->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row justify-content-center">
                                <div class="channel-avater">
                                    <div  onclick="document.getElementById('image').click()" class="channel-avatar-overlay">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"width="48" height="48" viewBox="0 0 24 24" style=" fill:#000000;"><g id="surface1"><path style=" " d="M 8 2 L 8 4 L 7 4 L 0 6.28125 L 0 21 L 24 21 L 24 4 L 16 4 L 16 2 Z M 1 3 L 1 5 L 5 3.65625 L 5 3 Z M 12 6 C 15.3125 6 18 8.6875 18 12 C 18 15.3125 15.3125 18 12 18 C 8.6875 18 6 15.3125 6 12 C 6 8.6875 8.6875 6 12 6 Z M 12 8 C 9.789063 8 8 9.789063 8 12 C 8 14.210938 9.789063 16 12 16 C 14.210938 16 16 14.210938 16 12 C 16 9.789063 14.210938 8 12 8 Z "></path></g></svg>
                                    </div>
                                </div>
                                    
                            </div>
                            <input type="file" name="image" id="image" style="display:none" onchange="document.getElementById('update-channel-form').submit()">

                            @error('image')
                            <div class="form-group row justify-content-center">
                                <span class="text-center" style="color:red">{{ $message }}</span>
                            </div>
                            @enderror
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" id="name" value="{{ $channel->name }}">   

                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control @error('description') is-invalid   @enderror">{{ $channel->description }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info btn-block">Update Channel</button>
                            </div>
                        </form>
                    @endif

                </div>
        </div>
        </div>
    </div>
</div>
@endsection
