@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <div class="col-md-10 d-flex pr-3">
                <h2><b>Búsqueda: </b> <i>"{{ $search }}"</i></h2>
                
                    <form action="{{ url('/buscar/'.$search) }}" class="col-auto ml-auto mr-0 pr-0">
                        <div class="form-group mr-0 d-flex">
                            <select class="custom-select" name="filter" id="filter">
                                <option value="">Ordenar ...</option>
                                <option value="new">Más nuevos primero</option>
                                <option value="old">Más antiguos primero</option>
                                <option value="alfa">Orden alfabético</option>
                            </select>
                            <input class="btn btn-sm btn-primary ml-2" type="submit" value="Ordenar">
                        </div>
                    </form>
            </div>
            
            
            @include('video/videosList')
        </div>
    </div>
    @include('video/pagination')
</div>



@endsection