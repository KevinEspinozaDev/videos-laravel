@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>Crear Nuevo Video</h2>
        <hr>

        <form action="{{ url('/guardar-video') }}" method="post" enctype="multipart/form-data" class="col-lg-8">
            
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
                <input value="{{ old('title') }}" required type="text" name="title" id="title" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea type="text" name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Miniatura</label>
                <input type="file" required name="image" id="image" class="form-control">
            </div>

            <div class="form-group">
                <label for="video">Archivo de Video</label>
                <input type="file" required name="video" id="video" class="form-control">
            </div>

            <div class="form group mt-3">
                <button class="btn btn-success">Subir Video</button>
            </div>
        </form>
    </div>
</div>
@endsection