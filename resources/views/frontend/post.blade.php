@extends('frontend.layout')
@section('content')
    <div class="row tm-row">
        <div class="col-12">
            <hr class="tm-hr-primary tm-mb-55">
            <img @if (isset($post['media'])) src="{{asset($post['media']->path)}}" @else src="" @endif class="tm-mb-40">
        </div>
    </div>
    <div class="row tm-row">
        <div class="col-lg-8 tm-post-col">
            <div class="tm-post-full">                    
                <div class="mb-4">
                    <h2 class="pt-2 tm-color-primary tm-post-title">{{$post['title']}}</h2>
                    <p class="tm-mb-40">{{date_format($post['created_at'],'d M Y')}} posted by {{$post['user']->name}}</p>
                    {!! $post['context'] !!}
                    <span class="d-block text-right tm-color-primary">
                        @foreach ($post['categories'] as $category)
                            <a href="{{route('category.single',$category->slug)}}" class="tm-color-primary"> {{ucfirst($category['title'])}} @if (next($post['categories'])==true) . @endif </a>
                        @endforeach
                    </span>
                </div>
                
                <!-- Comments -->
                <div>
                    <h2 class="tm-color-primary tm-post-title">Comments</h2>
                    <hr class="tm-hr-primary tm-mb-45">
                    @foreach ($post['comment'] as $comment)
                        <div class="tm-comment tm-mb-45">
                            <figure class="tm-comment-figure">
                                <img src="img/comment-1.jpg" alt="Image" class="mb-2 rounded-circle img-thumbnail">
                                <figcaption class="tm-color-primary text-center">{{$comment->user->name}}</figcaption>
                            </figure>
                            <div>
                                <p>
                                    {{$comment->content}}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <span class="tm-color-primary">{{date_format($comment->created_at,'d M Y')}}</span>
                                </div>                                                 
                            </div>                                
                        </div>
                    @endforeach
                    @auth
                        <form action="" class="mb-5 tm-comment-form">
                            <h2 class="tm-color-primary tm-post-title mb-4">Your comment</h2>
                            <div class="mb-4">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message"></textarea>
                            </div>
                            <div class="text-right">
                                <button class="tm-btn tm-btn-primary tm-btn-small">Submit</button>                        
                            </div>                                
                        </form> 
                    @endauth
                    @guest
                        <h2 class="tm-color-primary tm-post-title mb-4">You have to login to submit your comment.</h2>
                    @endguest                        
                </div>
            </div>
        </div>
        <aside class="col-lg-4 tm-aside-col">
            <div class="tm-post-sidebar">
                <hr class="mb-3 tm-hr-primary">
                <h2 class="mb-4 tm-post-title tm-color-primary">Categories</h2>
                <ul class="tm-mb-75 pl-5 tm-category-list">
                    @foreach ($categories as $category)
                        <li><a href="{{route('category.single',$category['slug'])}}" class="tm-color-primary">{{$category['title']}}</a></li>
                    @endforeach
                </ul>
                <hr class="mb-3 tm-hr-primary">
                <h2 class="tm-mb-40 tm-post-title tm-color-primary">Related Posts</h2>
                @foreach ( $related as $posts)
                    <a href="#" class="d-block tm-mb-40">
                        <figure>
                            <img src="img/img-02.jpg" alt="Image" class="mb-3 img-fluid">
                            <figcaption class="tm-color-primary">Duis mollis diam nec ex viverra scelerisque a sit</figcaption>
                        </figure>
                    </a>
                @endforeach
            </div>                    
        </aside>
    </div>
@endsection