@extends("layouts.dashboard")
@section("css")
    <!-- summernote -->
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- dropzonejs -->
  <link rel="stylesheet" href="/assets/plugins/dropzone/min/dropzone.min.css">
@endsection
@section("js")
<!-- Summernote -->
<script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Select2 -->
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- dropzonejs -->
<script src="/assets/plugins/dropzone/min/dropzone.min.js"></script>
<script>
    $(function () {
        // Summernote
        $('#summernote').summernote({height: 250})
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            allowClear: true
        })
    });
    
  var uploadedDocumentMap = {}
  Dropzone.options.documentDropzone = {
    url: "{{ route('media.index') }}",
    uploadMultiple: false,
    maxFiles: 1,
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function (file, response) {
    //   $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
    //   uploadedDocumentMap[file.name] = response.name
        if (response.status === "success") {
            console.log(response);
            $('input[name=media_id]').val(response.file_id)
        }
        
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedDocumentMap[file.name]
      }
      $('input[name=media_id]').val("")
    },
    init: function () {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
                this.processQueue()
            }
        });
      @if(isset($post['media']) && $post['media']->name)
          var file = {name: "{{$post['media']->name}}", size: {{$post['media']->size}}}
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, "{{asset($post['media']->path)}}");
          file.previewElement.classList.add('dz-complete')
          $('.dz-image').last().find('img').css("width", "100%");
          $('.dz-image').last().css({"width": "250px","height": "auto"});
          this.files.push(file);
          $('form#post-edit').append('<input type="hidden" name="media_id" value="{{$post['media']->id}}">')
      @else
            $('form#post-edit').append('<input type="hidden" name="media_id" value="">')
      @endif
    }

  }

</script>
@endsection
@section("breadcrumb","Post Edit")
@section("content")
    <!-- Main content -->
    <section class="content">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <form action="{{route('posts.update',$post['id'])}}" method="post" id="post-edit">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Title</label>
                    <input type="text" name="title" id="inputName" class="form-control" value="{{ $post["title"]}}">
                </div>
                <div class="form-group">
                    <label for="inputDescription">Context</label>
                    <textarea id="summernote" name="context">{{ $post['context']}}</textarea>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-body">
                <div class="form-group">
                    <label for="Status">Status</label>
                    <select name="status" id="Status" class="form-control custom-select" data-placeholder="Select a status" required>
                        <option value="published" @if($post['status'] === "published") selected @endif>Published</option>
                        <option value="draft" @if($post['status'] === "draft") selected @endif>Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <button name="publish" type="submit" class="btn btn-primary">Publish</button>
                    <button name="draft" type="submit" class="btn btn-secondary">Draft</button>
                </div>
                </div>
            </div>
            <div class="card card-secondary">
            <div class="card-body">
                <div class="form-group">
                    <label for="inputEstimatedBudget">Categories</label>
                    <select name="categories[]" class="select2bs4" multiple="multiple" data-placeholder="Select Category" style="width: 100%;">
                        @foreach ($categories as $category)
                            @foreach ($post['categories'] as $cat)
                                <option value="{{$category['id']}}" @if($cat->id === $category['id']) selected @endif>{{$category['title']}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputSpentBudget">Tags</label>
                    <select name="tags[]" class="select2bs4" multiple="multiple" data-placeholder="Select Tag" style="width: 100%;">
                        
                        @foreach ($tags as $tag)
                            <option value="{{$tag['id']}}" {{ in_array($tag->id , $post->tags()->pluck('id')->toArray()) ? 'selected' : '' }}>{{$tag['title']}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('categories'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('categories') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="inputEstimatedDuration">Thumbnail</label>
                    <div class="needsclick dropzone" id="document-dropzone">
                </div>
                </div>
                <!-- /.card-body -->
            </div>
            </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
@endsection