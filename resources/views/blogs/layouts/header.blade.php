<div class="container">

     <div class="navbar-header">
          <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="icon icon-bar"></span>
               <span class="icon icon-bar"></span>
               <span class="icon icon-bar"></span>
          </button>
          <a href="index.html" class="navbar-brand"></a>
     </div>
     <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
               <li class="active"><a href="{{ route('blogview')}}">Home</a></li>
               <li><a href="about.html">About</a></li>
               <li><a href="gallery.html">Gallery</a></li>
               @if(Auth::user())
               <li>
                    <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         {{Auth::user()->firstname}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         <a class="dropdown-item" href="{{route('user-logout')}}">
                              {{ __('Logout') }}
                         </a>
                         <form id="logout-form" action="#" method="POST" class="d-none">
                              @csrf
                         </form>
                    </div>
               </li>


               @else
               <li><a href="{{route('user.login')}}">Login</a></li>

               @endif
          </ul>
     </div>

</div>