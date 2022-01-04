@extends('blogs.layouts.master')


@section('content')
<section id="blog">
    <div class="container">
        <div class="row">

            <div class="col-md-offset-1 col-md-10 col-sm-12">
                @foreach($blogs as $b)
                <div class="blog-post-thumb">
                    <div class="blog-post-image">
                        <a href="single-post.html">
                            <img src="storage/images/{{ $b->image }}" class="img-responsive" alt="Blog Image">
                        </a>
                    </div>
                    <div class="blog-post-title">
                        <a href = "{{route('blog-detail',$b->id)}}"><h3>{{$b->name}}</h3>
                    </div>
                    <div class="blog-post-format">
                        
                        <span><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> {{$b -> likes_count}}Likes</a></span>
                        <span><a href="#"><i class="fa fa-comment-o"></i> {{$b -> comments_count}} Comments</a></span>
                    </div>
                    <div class="blog-post-des">
                        <p>{{$b->description}}</p>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@iclude('user.update_user')n
@endsection