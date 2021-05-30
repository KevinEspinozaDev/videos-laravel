@extends('layouts.app')

@section('content')

<div class="col-md-10">
    <h2>{{ $video->title }}</h2>
    <hr/>

    <div class="col-md-8">
        <!-- Video -->
        <video controls  height="386px" class="w-100" id="video-player">
            <source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}">
            Your browser is not compatible with HTML 5.
        </video>

        <!-- Description -->
        <div class="card video-data">
            <div class="card-body">
                <div class="card-title">
                    <!-- Uso de un helper -->
                    Uploaded by: <a href="{{ route('channel', ['user_id' => $video->user_id]) }}">{{ $video->user->name.' '.$video->user->surname }}</a> {{ \FormatTime::LongTimeFilter($video->created_at) }}
                </div>
                <div class="card-text">
                    <p>{{ $video->description }}</p>
                </div>
            </div>
        </div>

        <!-- Comments -->
        @include('video/comments')
    </div>

</div>

@endsection