@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <div class="col-md-10 d-flex pr-3">
                <h2><b>Canal de: </b> {{ $user->name. ' '. $user->surname }}</h2>
                
            </div>
            
            
            @include('video/videosList')
        </div>
    </div>
    @include('video/pagination')
</div>
@endsection