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
            <div id="videos-list">
                @foreach($videos as $video)
                    <div class="video-item col-md-10 float-left panel panel-default">
                        <div class="panel-body">
                        
                            <!-- Imagen del video-->
                            @if(Storage::disk('images')->has($video->image))
                            <div class="video-image-thumb col-md-3 float-left">
                                <div class="video-image-mask">
                                    <img class="thumbnail" src="{{ url('miniatura/'.$video->image) }}" class="video-image"/>
                                </div>
                            </div>
                            @endif

                            <div class="data">
                                <h4 class="video-title"><a href="http://">{{ $video->title }}</a></h4>
                                <p>{{ $video->user->name }}</p>
                            </div>

                            <!-- botones de accion -->
                            <a href="" class="btn btn-success">Ver</a>
                            @if(Auth::check() && Auth::user()->id == $video->user->id)
                                <a href="" class="btn btn-warning">Editar</a>
                                <a href="" class="btn btn-danger">Eliminar</a>
                            @endif

                        </div>
                    </div>
                @endforeach
                
            </div>
        </div>

        <div class="my-5">
            <!-- botones de navegacion -->
            {{ $videos->links() }}
        </div>

        
        
    
    </div>
</div>
@endsection
