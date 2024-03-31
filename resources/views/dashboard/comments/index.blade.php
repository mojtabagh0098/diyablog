@extends("layouts.dashboard")
@section("breadcrumb","Comments")
@section("css")
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
@endsection
@section("js")
    <!-- SweetAlert2 -->
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        function create(pid) {
            Swal.fire({
                title: "Reply",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Submit",
                html: `
                    <div class="form-group">
                        <lable for="content">Description</lable>
                        <textarea id="replyContent" class="form-control" rows="3"></textarea>
                    </div>
                `,
                focusConfirm: true,
                preConfirm: async(login)=> {
                    await $.ajax({
                        url: `{{route('comments.index')}}`,
                        data: {content: $('#replyContent').val(), post_id: pid},
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: (res) =>{
                            Swal.fire({
                                title: 'Good!',
                                text: "Reply has been submited successfully.",
                                icon: "success",
                            }).then((result) => {if (result.isConfirmed) {location.reload()}});
                        },
                        error: (err) => {
                            errors = err.responseJSON.message;
                            Swal.hideLoading();
                            return Swal.showValidationMessage(errors);
                        }
                    });
                }
            });
        }
    </script>
@endsection
@section("content")
<section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Post
                      </th>
                      <th style="width: 30%">
                          Comment
                      </th>
                      <th>
                          User
                      </th>
                      <th style="width: 8%" class="text-center">
                          Status
                      </th>
                      <th style="width: 30%">
                          Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($comments as $comment )
                    <tr>
                      <td>
                          {{ $comment['id'] }}
                      </td>
                      <td>
                          <a href="{{route('post.single',$comment['post']->slug)}}" target="_blank">
                              {{ $comment['post']->title }}
                          </a>
                          <br>
                          <small>
                              Created {{ date_format($comment['created_at'],'d M Y - H:m') }}
                          </small>
                      </td>
                      <td>
                            {{ $comment['content'] }}
                      </td>
                      <td>
                          <small>
                              {{ $comment['user']->name }}
                          </small>
                      </td>
                      <td class="project-state">
                        @switch($comment['status'])
                            @case('approved')
                                <span class="badge badge-success">{{ ucfirst($comment['status']) }}</span>
                            @break
                            @case('pending')
                                <span class="badge badge-primary">{{ ucfirst($comment['status']) }}</span>
                            @break
                            @case('rejected')
                                <span class="badge badge-danger">{{ ucfirst($comment['status']) }}</span>
                            @break
                        
                            @default
                                
                        @endswitch
                          
                      </td>
                      <td class="project-actions">
                          <form action="{{route('comments.update',$comment['id'])}}" method="post" class="d-inline-block">
                                @csrf
                                @method("put")
                                @if ($comment['status'] !== "approved")
                                    <button class="btn btn-success btn-sm" type="submit" name="status" value="approved">
                                        <i class="fas fa-trash"></i>
                                            Approve
                                    </button>
                                @endif
                                @if ($comment['status'] !== "rejected")
                                    <button class="btn btn-warning btn-sm" type="submit" name="status" value="rejected">
                                    <i class="fas fa-trash"></i>
                                        Reject
                                </button>
                                @endif
                          </form>
                          @if ($comment['status'] === "approved")
                              <button class="btn btn-primary btn-sm" onclick="create({{$comment['post_id']}})">
                                    <i class="fas fa-plus"></i>
                                    Reply
                                </button>
                          @endif
                          <form action="{{route('comments.destroy',$comment['id'])}}" method="post" class="d-inline-block">
                                @csrf
                                @method("delete")
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                          </form>
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
@endsection