@extends("layouts.dashboard")
@section("breadcrumb","Users")
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
                title: "Create New User",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Submit",
                html: `
                    <div class="form-group">
                        <lable for="name">Name</lable>
                        <input id="name" class="form-control" type="text" required>
                    </div>
                    <div class="form-group">
                        <lable for="email">Email</lable>
                        <input id="email" class="form-control" type="text" required>
                    </div>
                    <div class="form-group">
                        <lable for="password">Password</lable>
                        <input id="password" class="form-control" type="password" required>
                    </div>
                    <div class="form-group">
                        <lable for="confirmpassword">Confirm Password</lable>
                        <input id="confirmpassword" class="form-control" type="password" required>
                    </div>
                `,
                focusConfirm: true,
                preConfirm: async(login)=> {
                    await $.ajax({
                        url: `{{route('users.index')}}`,
                        data: {name: $('#name').val(), email: $('#email').val(), password: $('#password').val(), password: $('#password').val()},
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: (res) =>{
                            Swal.fire({
                                title: 'Good!',
                                text: "Category has created successfully.",
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
                title: "Edit User",
                showCancelButton: true,
                showLoaderOnConfirm: false,
                confirmButtonText: "Submit",
                html: '',
                focusConfirm: false,
                willOpen: async() => {
                    Swal.showLoading();
                    $.ajax({
                        url: `{{route('users.index')}}/${id}`,
                        type: 'get',
                        success: function(res) {
                            Swal.update({
                                html: `
                                    <div class="form-group">
                                        <lable for="name">Name</lable>
                                        <input id="name" class="form-control" type="text" value="${res.name}" required>
                                    </div>
                                    <div class="form-group">
                                        <lable for="email">Email</lable>
                                        <input id="email" class="form-control" type="text" value="${res.email}" required>
                                    </div>
                                    <div class="form-group">
                                        <lable for="password">Password</lable>
                                        <input id="password" class="form-control" type="password" required>
                                    </div>
                                    <div class="form-group">
                                        <lable for="confirmpassword">Confirm Password</lable>
                                        <input id="confirmpassword" class="form-control" type="password" required>
                                    </div>
                                `
                            });
                            Swal.hideLoading();
                        }
                    })
                },
                preConfirm: async(login)=> {
                    await $.ajax({
                        url: `{{route('users.index')}}/${id}`,
                        data: {name: $('#name').val(), email: $('#email').val(), password: $('#password').val(), password: $('#password').val()},
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: (res) =>{
                            Swal.fire({
                                title: 'Good!',
                                text: "User has modified successfully.",
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
                        url: `{{route('categories.index')}}/${id}`,
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
    <div class="container-fluid">
        <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Users</h3>
          <div class="card-tools">
            <button class="btn btn-primary btn-sm" onclick="create()">
            <i class="fas fa-plus"></i>
            Add
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
                          Name
                      </th>
                      <th style="width: 30%">
                          Role
                      </th>
                      <th>
                          Verified
                      </th>
                      <th style="width: 20%">
                          Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($users as $user )
                    <tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a href="/posts/{{$user['id']}}/edit">
                              {{ $user['name'] }}
                          </a>
                          <br>
                          <small>
                              Signed up {{ $user['created_at'] }}
                          </small>
                      </td>
                      <td>
                            <span class="badge badge-success">{{ $user->role['name'] }}</span>
                      </td>
                      <td>
                          <small>
                            @if (!$user->hasVerifiedEmail())
                                {{-- <span class="badge badge-success">True</span> --}}
                                <span title="Verified Email" class="badge bg-success">
                                    <i class="fa fa-check"></i>
                                </span>
                            @else
                                <span title="Verified Email" class="badge bg-danger">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                          </small>
                      </td>
                      <td class="project-actions text-right">
                          <button class="btn btn-info btn-sm" onclick="edit({{$user['id']}})">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </button>
                          <button class="btn btn-danger btn-sm" onclick="remove({{$user['id']}})">
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
    </div>

    </section>
@endsection
