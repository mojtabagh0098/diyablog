@extends("layouts.dashboard")
@section("breadcrumb","Categories")
@section("css")
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
@endsection
@section("js")
    <!-- SweetAlert2 -->
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        function create() {
            Swal.fire({
                title: "Create New Tag",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Submit",
                html: `
                    <div class="form-group">
                        <lable for="title">Title</lable>
                        <input id="newTagTitle" class="form-control" type="text" required>
                    </div>
                    <div class="form-group">
                        <lable for="description">Description</lable>
                        <textarea id="newTagDescription" class="form-control" rows="3"></textarea>
                    </div>
                `,
                focusConfirm: true,
                preConfirm: async(login)=> {
                    await $.ajax({
                        url: `{{route('tags.index')}}`,
                        data: {title: $('#newTagTitle').val(), description: $('#newTagDescription').val()},
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: (res) =>{
                            Swal.fire({
                                title: 'Good!',
                                text: "Tag has created successfully.",
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
        function edit(id) {
            Swal.fire({
                title: "Edit Tag",
                showCancelButton: true,
                showLoaderOnConfirm: false,
                confirmButtonText: "Submit",
                html: '',
                focusConfirm: false,
                willOpen: async() => {
                    Swal.showLoading();
                    $.ajax({
                        url: `{{route('tags.index')}}/${id}`,
                        type: 'get',
                        success: function(res) {
                            Swal.update({
                                html: `
                                    <div class="form-group">
                                        <lable for="title">Title</lable>
                                        <input id="newTagTitle" class="form-control" type="text" value="${res.title}" required>
                                    </div>
                                    <div class="form-group">
                                        <lable for="description">Description</lable>
                                        <textarea id="newTagDescription" class="form-control" rows="3">${!res.description ? '' : res.description}</textarea>
                                    </div>
                                `
                            });
                            Swal.hideLoading();
                        }
                    })
                },
                preConfirm: async(login)=> {
                    await $.ajax({
                        url: `{{route('tags.index')}}/${id}`,
                        data: {title: $('#newTagTitle').val(), description: $('#newTagDescription').val()},
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: (res) =>{
                            Swal.fire({
                                title: 'Good!',
                                text: "Tag has created successfully.",
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
        function remove(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{route('tags.index')}}/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            // console.log(res.status);
                            if (res.status === "success") {
                                location.reload();
                            }
                        }
                    })
                }
            });
        }
    </script>
@endsection
@section("content")
<section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tags</h3>
            <button class="btn btn-primary btn-sm" onclick="create()">
                <i class="fas fa-plus">
                </i>
                Add
            </button>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Title
                      </th>
                      <th style="width: 30%">
                          Category
                      </th>
                      <th style="width: 20%">
                          Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($tags as $tag )
                    <tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a href="/category/{{$tag['id']}}/edit">
                              {{ $tag['title'] }}
                          </a>
                          <br>
                          <small>
                              Created {{ $tag['created_at'] }}
                          </small>
                      </td>
                      <td>
                          
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <button class="btn btn-info btn-sm" onclick="edit({{$tag['id']}})">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </button>
                            <button class="btn btn-danger btn-sm" onclick="remove({{$tag['id']}})">
                                <i class="fas fa-trash"></i>
                                Delete
                            </button>
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