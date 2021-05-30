<!-- comprobacion de videos -->
@if($videos && count($videos) >= 1)

<!-- representacion de los videos -->
<div class="container">
    @foreach($videos as $video)
        <div class="video-item col-md-10 float-left card">
            <div class="card-body">
            
                <!-- Imagen del video-->
                @if(Storage::disk('images')->has($video->image))
                <div class="video-image-thumb col-md-3 float-left">
                    <div class="video-image-mask">
                        <img class="thumbnail" src="{{ url('miniatura/'.$video->image) }}"/>
                    </div>
                </div>
                @endif

                <div class="datos-video">

                    <div class="data">
                        <h4 class="video-title"><a href="{{ route('detailVideo', ['video_id' => $video->id]) }}">{{ $video->title }}</a></h4>
                        <p> <a href="{{ route('channel', ['user_id' => $video->user_id]) }}">{{ $video->user->name }}</a> 
                        | {{ \FormatTime::LongTimeFilter($video->created_at) }}
                        </p>
                        
                    </div>

                    <!-- botones de accion -->
                    <a href="{{ route('detailVideo', ['video_id' => $video->id]) }}" class="btn btn-success">Ver</a>
                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                        <a href="{{ route('videoEdit', ['video_id' => $video->id]) }}" class="btn btn-warning">Editar</a>
                        <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                        <a href="#victorModal{{ $video->id }}" role="button" class="btn btn-danger" data-toggle="modal">Eliminar</a>
                        
                        <!-- modal de confirmacion -->
            
                        <!-- Modal / Ventana / Overlay en HTML -->
                        <div id="victorModal{{ $video->id }}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">¿Estás segur@?</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Segur@ que quieres borrar este video?</p>
                                        <p class="text-primary"><i>" {{ $video->title }} "</i></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <a href="{{ url('/delete-video/'.$video->id) }}" type="buttn" class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    @endforeach
    
</div>
@else
<div class="alert alert-info">
    <h4>No se encontraron videos...</h4>
</div>
@endif
<!-- fin comprobacion videos -->
