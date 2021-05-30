@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            @if(session('message'))
                @if(session('result') && session('result') == 0)
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @elseif(session('result') && session('result') == 1)
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            @endif
            
            @include('video/videosList')

        </div>
        
    </div>
    @include('video/pagination')
</div>

@endsection
