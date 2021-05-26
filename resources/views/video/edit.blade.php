@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        <h2>Editar Video - <i>{{ $video->title }}</i></h2>
        <hr/>

            <form action="{{ route('updateVideo', ['video_id' => $video->id]) }}" method="post" enctype="multipart/form-data" class="col-lg-8">
                
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif 
                
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input value="{{ $video->title }}" type="text" name="title" id="title" class="form-control">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea type="text" name="description" id="description" class="form-control">{{ $video->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Miniatura</label>
                    <!-- Imagen del video-->
                    @if(Storage::disk('images')->has($video->image))
                    <div class="video-image-thumb mb-2">
                        <div class="video-image-mask">
                            <img class="thumbnail " src="{{ url('miniatura/'.$video->image) }}"/>
                        </div>
                    </div>
                    @endif

                    <i>No suba otro archivo si quiere conservar el mismo.</i>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="video">Archivo de Video</label> <br>

                    <!-- Video -->
                    <div class="col-12">
                        <video controls width="300px" height="200px" id="video-player">
                            <source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}" />
                            Your browser is not compatible with HTML 5.
                        </video>
                    </div>
                    

                    <i>No suba otro archivo si quiere conservar el mismo.</i>
                    <input type="file" name="video" id="video" class="form-control">
                </div>

                <div class="form group mt-3">
                    <button type="submit" class="btn btn-success">Confirmar Cambios</button>
                </div>
            </form>
        </div>
    </div>

@endsection