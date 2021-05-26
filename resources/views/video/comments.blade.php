<hr>
    <h4>Comentarios</h4>
<hr>

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if(Auth::check())
<form action="{{ url('/comment') }}" method="post">
    {!! csrf_field() !!}

    <input type="hidden" name="video_id" value="{{$video->id}}" required />

    <p>
        <textarea class="form-control" name="body" required></textarea>
    </p>

    <input type="submit" class="btn btn-success" value="Comentar" />
</form>
<hr/>
@endif



@if(isset($video->comments))
    <div id="comments-list " class="mt-5">
    @foreach($video->comments as $comment)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><strong>{{ $comment->user->name. ' '. $comment->user->username }} </strong> {{ \FormatTime::LongTimeFilter($comment->created_at) }}</h4>
                <p class="card-text">
                    {{ $comment->body }}

                    @if(Auth::check() && (Auth::user()->id == $comment->user_id || 
        Auth::user()->id == $video->user->id))
                    
                        <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                        <a href="#victorModal{{ $comment->id }}" role="button" class="btn float-right btn-sm btn-danger" data-toggle="modal">Eliminar</a>
                    
                        <!-- modal de confirmacion -->
            
                        <!-- Modal / Ventana / Overlay en HTML -->
                        <div id="victorModal{{ $comment->id }}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">¿Estás segur@?</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Segur@ que quieres borrar este comentario?</p>
                                        <p class="text-primary"><small><i>" {{ $comment->body }} "</i></small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <a href="{{ url('delete-comment/'.$comment->id) }}" type="buttn" class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </p>

            </div>

        </div>

    @endforeach
    </div>
@endif



