@extends('index2')

@push('script')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@push('bootstrap')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush

@section('content')
<div class="container col-md-11 pt-4">
    <h1 class="font-weight-bold pb-4">Edit Pertanyaan</h1>

    <form action="/pertanyaan/{{ $question->id }}" method="post">
    @method('put')
    @csrf
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $question->judul }}" required>
        </div>
        <div class="form-group">
            <label for="isi">Isi</label>
            <textarea name="isi" class="form-control my-editor">{!! $question->isi !!}</textarea>
        </div>
        <div class="form-group">
            <label for="tags">Tag - pisahkan dengan koma (,)</label>
            <input type="text" class="form-control" id="tags" name="tags" value="{{ $question->tags }}" required>
        </div>
        <input type="hidden" name="updated_at" value="{{\Carbon\Carbon::now()}}">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection

@push('script-body')
<script>
  var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
@endpush