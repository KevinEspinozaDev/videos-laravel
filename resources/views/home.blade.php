@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            @if(session('message'))
                <div class="alert alert-success">
                {{ session('message') }}
                </div>
            @endif

            <!-- representacion de los videos -->
            <ul id="videos-list">
                @foreach($videos as $video)
                    <li class="video-item col-md-4 float-left">
                        
                        <!-- Imagen del video-->
                        @if(Storage::disk('images')->has($video->image))
                        <img src="{{ Storage::url("app/images/{$video->image}") }}" class="video-image"/>
                        @endif

                        <div class="data">
                            <h4>{{ $video->title }}</h4>
                        </div>
                    </li>
                @endforeach
                
            </ul>
        </div>

        <div class="my-5">
            <!-- botones de navegacion -->
            {{ $videos->links() }}
        </div>
        
    
    </div>
</div>
@endsection
