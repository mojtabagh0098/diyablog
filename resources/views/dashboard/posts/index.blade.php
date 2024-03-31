@extends("layouts.dashboard")
@section("breadcrumb","Posts")
@section("content")
<section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Posts</h3>

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
                      <th>
                          Author
                      </th>
                      <th style="width: 8%" class="text-center">
                          Status
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($posts as $post )
                    <tr>
                      <td>
                          #
                      </td>
                      <td>
                          <a href="/posts/{{$post['id']}}/edit">
                              {{ $post['title'] }}
                          </a>
                          <br>
                          <small>
                              Created {{ $post['created_at'] }}
                          </small>
                      </td>
                      <td>
                          <ul class="list-inline">
                            @foreach ($post['categories'] as $category )
                                <li class="list-inline-item">
                                    {{ $category->title }}
                                </li>
                            @endforeach
                          </ul>
                      </td>
                      <td>
                          <small>
                              {{ $post['user']->name }}
                          </small>
                      </td>
                      <td class="project-state">
                          <span class="badge badge-success">{{ $post['status'] }}</span>
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="{{route('post.single',$post['slug'])}}">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="{{route('posts.edit',$post['id'])}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <form action="{{route('posts.destroy',$post['id'])}}" method="post" style="width: fit-content;float: right;margin-left: 5px;">
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