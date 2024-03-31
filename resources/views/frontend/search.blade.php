@extends('frontend.layout')
@section('content')
<div class="row tm-row">
    <h2 class="tm-mb-40 tm-post-title tm-color-primary">{{$search}}'s Posts</h2>
    <hr class="tm-hr-primary tm-mb-55">
</div>
<div class="row tm-row">
        @foreach ($posts as $post)
            <article class="col-12 col-md-6 tm-post">
                <hr class="tm-hr-primary">
                <a href="{{route('post.single',$post['slug'])}}" class="effect-lily tm-post-link tm-pt-60">
                    <div class="tm-post-link-inner">
                        <img @if ($post['media']) src="{{asset($post['media']->path)}}" @else src="" @endif alt="Image" class="img-fluid">                            
                    </div>
                    <span class="position-absolute tm-new-badge">Featured</span>
                    <h2 class="tm-pt-30 tm-color-primary tm-post-title">{{$post['title']}}</h2>
                </a> 
                <p class="tm-pt-30">
                    {!! $post['context'] !!}
                </p>
                <div class="d-flex justify-content-between tm-pt-45">
                    @foreach ($post['categories'] as $category)
                        <a href="{{route('category.single',$category->slug)}}" class="tm-color-primary">{{$category['title']}}</a>
                    @endforeach
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>36 comments</span>
                    <span>by {{$post['user']->name}}</span>
                </div>
            </article>
        @endforeach
        
    </div>
@endsection