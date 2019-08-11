@extends('layouts.app')

@section('content')
<div class="container-flouid">
    <div class="row justify-content-center">
        <channel-uploads :channel="{{ $channel }}">
            
        </channel-uploads>
    </div>
</div>
@endsection
