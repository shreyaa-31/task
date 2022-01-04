@extends('blogs.layouts.master')



@section('content')

<style>
     .error {
          color: red;
     }
</style>
<section id="blog-single-post">
     <div class="container">
          <div class="row">

               <div class="col-md-offset-1 col-md-10 col-sm-12">
                    <div class="blog-single-post-thumb">

                         <div class="blog-post-title">
                              <h2>{{ $blog->name }}</a></h2>
                         </div>

                         <div class="blog-post-des">

                              <div class="blog-post-image">
                                   <img src="/storage/images/{{$blog->image }}" class="img-responsive" alt="Blog Image 3">
                              </div>

                              <p>{{$blog->description}}</p>

                         </div>
                         <div class="blog-post-format">
                              @if(Auth::check())
                    
                              <a onclick='addLike()' ;><i id="asd" class="fa {{ $like ? 'fa-heart' : 'fa-heart-o' }}" aria-hidden="true"></i><span id="blog_like">{{$likecount[0]['likes_count']}}</span>Likes</a>
                              <a ><i class="fa fa-comment-o"></i> <span id="comment_count" >{{$likecount[0]['comments_count']}}</span> Comments</a>
                              @else
                              <span><a href="{{route('user.login')}}"><i class="fa fa-heart-o" aria-hidden="true"></i> Likes</a></span>
                              <span><a href="#"><i class="fa fa-comment-o"></i><span id="comment_count" >{{$likecount[0]['comments_count']}}</span> Comments</a>
                              @endif
                         </div>


                         <div class="blog-comment">
                              <h3>Comments</h3>
                              @foreach($comments as $c)
                              <div class="media">
                                  
                                   <div class="media-body">
                                        <h3 class="media-heading">{{$c->getName->firstname}}</h3>
                                        <span>{{$c->created_at->diffforHumans()}}</span>
                                        <p>{{$c->comments}}</p>
                                   </div>

                              </div>
                              @endforeach
                         </div>


                         <div class="blog-comment-form">
                              <h3>Leave a Comment</h3>
                              <form id="comment_form" method="post">
                                   @csrf
                                   <textarea name="comments" rows="5" class="form-control" id="comments" placeholder="Message" message="message" required="required"></textarea>
                                   <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                   <div class="col-md-3 col-sm-4">
                                        <input name="submit" type="submit" value="submit" class="form-control" id="submit" value="Post Your Comment">
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
</section>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


<script>
     function addLike() {
          id = "{{$blog->id}}";

          $.ajax({
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },

               url: "{{ route('add-like')}}",
               method: "POST",
               data: {
                    id: id
               },

               dataType: 'JSON',
               success: function(data) {
                   
                    $('#blog_like').html(data.like_count);
                    if (data.status == true) {
                         $('#asd').removeClass('fa fa-heart-o');
                         $('#asd').addClass('fa fa-heart');       
                         
                    } else {
           
                         $('#asd').removeClass('fa fa-heart');
                         $('#asd').addClass('fa fa-heart-o');
                    }

               }

          })
     }

     $('#comment_form').validate({
          rules: {
               comments: {
                    required: true,
               }
          },
          messages: {
               comments: {
                    required: "Type Something",
               }
          },
          submitHandler: function(form) {

               $.ajax({
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    url: "{{ route('add-comment')}}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                         console.log(data.data.comments)
                         $('#comment_count').html(data.comment_count);
                         html = `<div class="media">
                                  
                                  <div class="media-body">
                                       <h3 class="media-heading">{{Auth::user()->firstname}}</h3>
                                       <span>Just Now</span>
                                       <p>`+data.data.comments+`</p>
                                  </div>

                             </div>`;
                             $('.blog-comment').append(html);
                         if (data.status == true) {    
                              $("#comment_form").get(0).reset();
                             
                         }
                    }

               })
          }
     })
</script>
@endsection