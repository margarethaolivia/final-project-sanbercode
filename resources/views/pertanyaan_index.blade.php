@extends('index2')

@section('content')
<div class="container col-md-11 py-4">

    <div class="row">
        <div class="col">
            <h3 class="font-weight-bold pb-2 d-inline float-left text-center">Daftar Pertanyaan</h3>
            <a href="/pertanyaan/create" class="btn btn-info mb-3 float-right">Tambah Pertanyaan</a>
        </div>
    </div>

    @if($questions->count() > 0)
    <div class="row">
    <table class="table">
        <thead class="bg-dark text-white">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Judul</th>
                <th scope="col">Isi</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody class="bg-white">
        @foreach( $questions as $question )
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td id="judul"><div class="font-weight-bold">{{ $question->judul }}</div></td>
                <td> <div>{!! $question->isi !!}</div>
                <td><a href="/pertanyaan/{{ $question->id }}" class="btn btn-info text-white mb-2 float-right">Detail</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @else
        <p class="text-muted font-italic">Belum terdapat pertanyaan</p>
    @endif
    
</div>
@endsection