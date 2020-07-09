@extends('index2')

@section('content')

<?php 
    $tags = explode(',', $question->tags);
?>

<div class="container col-md-11 pt-4">
    <div class="card p-2">
        <div class="row">
            <div class="card-body col-md-9 float-left">
                <p class="card-text"><small>Asked by {{ $question->user->name }} </small><span class="badge badge-light">{{ $question->user->reputasi($question->user->id) }}</span></p>
                <h3 class="font-weight-bold d-inline">{{ $question->judul }}</h3>
                <h1 class="card-text mt-4">{!! $question->isi !!}</h1>
                
                <div class="d-block mb-2">
                @foreach($tags as $tag)
                    <a href="" class="btn btn-success">{{$tag}}</a>
                @endforeach
                </div>
                
                <p class="card-text d-inline mr-2"><small class="text-muted">Created at {{ $question->created_at }}</small></p>
                @if( $question->created_at != $question->updated_at )
                    <p class="d-inline card-text"><small class="text-muted">|</small></p>
                    <p class="card-text d-inline ml-2"><small class="text-muted">Edited at {{ $question->updated_at }}</small></p>
                @endif
                
                <div class="pt-2">
                    @if( $question->is_upvoted_by_auth_user() )
                        <a href="/pertanyaan/unupvote/{{ $question->id }}" class="btn-xs btn btn-success">Upvote</a>
                    @else
                        <a href="/pertanyaan/upvote/{{ $question->id }}" class="btn-xs btn btn-light">Upvote</a>
                    @endif

                    @if( $question->is_downvoted_by_auth_user() )
                        <a href="/pertanyaan/undownvote/{{ $question->id }}"  class="btn-xs btn btn-danger ml-1">Downvote</a><small class="font-weight-bold ml-1">{{ $question->upvotes->count() - $question->downvotes->count() }}</small>
                    @else
                        <a href="/pertanyaan/downvote/{{ $question->id }}" class="btn-xs btn btn-light ml-1">Downvote</a><small class="font-weight-bold ml-1">{{ $question->upvotes->count() - $question->downvotes->count() }}</small>
                    @endif
                </div>
                

            </div>
            <div class="card-body col-md-3">
                <form action="/pertanyaan/{{ $question->id }}" method="post">
                @method('delete')
                @csrf
                    <button type="submit" class="btn btn-danger float-right mr-2" onclick="return confirm('Apakah kamu yakin?')">Delete</button>
                </form>

                <a href="/pertanyaan/{{ $question->id }}/edit" class="btn btn-info float-right mr-2">Edit</a>
            </div>
        </div>

        <div class="row">
            <div class="col">
            @foreach($commentsQuestion as $commentQuestion)
                <div class="card mt-3">
                    <p class="p-2">{{ $commentQuestion->isi }}</p>
                </div>
                @endforeach

                <p class="pt-2"><a class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Komentar</a></p>

                <div class="collapse" id="collapseExample">
                    <form action="/komentarpertanyaan/{{ $question->id }}" method="post">
                    @csrf
                        <div class="form-group">
                        <input type="text" class="form-control" id="isi" name="isi" required>
                        </div>
                        <input type="hidden" name="pertanyaan_id" value="{{ $question->id }}">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>

</div>

<div class="container col-md-11 py-4">

    <h5 class="font-weight-bold putih">Semua Jawaban</h5>
    @if($answers->count() > 0)
    @foreach($answers as $answer)
        <div class="card">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-block">
                    <p class="card-text"><small>Answered by {{ $answer->user->name }}</small><span class="badge badge-light">{{ $answer->user->reputasi($answer->user->id) }}</span></p>
                    <p class="card-text">{{ $answer->isi }}</p>
                    <p class="card-text"><small class="text-muted">Created at {{ $answer->created_at }}</small></p>
                    
                    @if( $answer->is_selected_by_user_question() )
                        <a href="/jawaban/unselected/{{ $answer->id }}/{{ $question->user_id }}/{{ $answer->user_id }}" class="btn-xs btn btn-success mr-2">Jawaban terpilih</a>
                    @else
                        <a href="/jawaban/selected/{{ $answer->id }}/{{ $question->user_id }}/{{ $answer->user_id }}" class="btn-xs btn btn-light mr-2">Jawaban terpilih</a>
                    @endif
                    
                    <div class="pt-2 d-inline">
                        @if( $answer->is_upvoted_by_auth_user() )
                            <a href="/jawaban/unupvote/{{ $answer->id }}" class="btn-xs btn btn-success">Upvote</a>
                        @else
                            <a href="/jawaban/upvote/{{ $answer->id }}" class="btn-xs btn btn-light">Upvote</a>
                        @endif

                        @if( $answer->is_downvoted_by_auth_user() )
                            <a href="/jawaban/undownvote/{{ $answer->id }}"  class="btn-xs btn btn-danger ml-1">Downvote</a><small class="font-weight-bold ml-1">{{ $answer->upvotes->count() - $answer->downvotes->count() }}</small>
                        @else
                            <a href="/jawaban/downvote/{{ $answer->id }}" class="btn-xs btn btn-light ml-1">Downvote</a><small class="font-weight-bold ml-1">{{ $answer->upvotes->count() - $answer->downvotes->count() }}</small>
                        @endif
                    </div>

                    @foreach($commentsAnswer as $commentAnswer)
                        @if($commentAnswer->jawaban_id == $answer->id)
                        <div class="card mt-2">
                            <p class="p-2">{{ $commentAnswer->isi }}</p>
                        </div>
                        @endif
                    @endforeach

                    <p class="pt-2"><a class="btn btn-info" data-toggle="collapse" href="#collapseExample{{ $answer->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">Komentar</a></p>
                    <div class="collapse" id="collapseExample{{ $answer->id }}">
                        <form action="/komentarjawaban/{{ $answer->id }}/{{ $question->id }}" method="post">
                        @csrf
                            <div class="form-group">
                            <input type="text" class="form-control" id="isi" name="isi" required>
                            </div>
                            <input type="hidden" name="jawaban_id" value="{{ $answer->id }}">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </li>
            </ul>
            
        </div>
    @endforeach
    @else
        <p class="text-muted font-italic">Belum terdapat jawaban</p>
    @endif
</div>

<div class="container col-md-11 py-4">
    <h5 class="font-weight-bold putih">Tambah Jawaban</h5>
        <form action="/pertanyaan/{{ $question->id }}" method="post">
        @csrf
            <div class="form-group">
                <textarea class="form-control" id="isi" name="isi" required></textarea>
            </div>
            <input type="hidden" name="pertanyaan_id" value="{{ $question->id }}">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</div>
@endsection