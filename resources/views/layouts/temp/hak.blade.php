<!DOCTYPE html>
<html lang="id">
<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $title}} | AHP TOPSIS - Dolphin</title> 
  <meta name="keywords" content="Dolphin" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Dolphin Dolphin">
  <meta name="author" content="Dolphin.co.id">
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5/2/3/css/bootstrap.min.css"> -->
  <link rel="shortcut icon" href="{{asset('/media/vekyss.png')}}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{asset('/media/vekyss.png')}}">
  <link rel="icon" href="{{asset('/media/vekyss.png')}}" type="image/png" sizes="206x16">

  <link href="{{asset('startboot/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css"> 
  <link href="{{asset('startboot/css/sb-admin.css')}}" rel="stylesheet">
</head>
<body id="page-top">
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="">SPK - Dolphin</a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="">
      <i class="fas fa-bars"></i>
    </button>
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      @csrf  
      <!-- <div class="input-group">
        <input type="text" class="form-control" placeholder="Cari..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div> --> 
    </form>
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img id="img-preview" src="{{asset(Auth::user()->file)}}"  class="user-image img-responsive" style="width: 40px; height: 40px; top: 10px; left: 10px; border-radius: 40%;  color: rgb(255,0,0);" alt="foto admin">
          <span class="hidden-xs">{{ ucwords (Auth::user()->name) }}</span>
          <!-- <i class="fas fa-user-circle fa-fw"></i> -->
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item text-center" href="{{ route('admin.show',Auth::user()->id)}}">{{ ucwords (Auth::user()->name) }}</a>
          <div class="dropdown-divider"></div>
          <!--  -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item  btn btn-danger" href="#" data-toggle="modal" data-target="#logoutModal">Keluar</a>
        </div>
      </li>
    </ul>
  </nav>
  <div id="wrapper">
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('rasatamu')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>DASHBOARD</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fa fa-fw fa-circle"></i> <span>KELUAR</span>
        </a>
      </li>
      
    </ul>
    <div id="content-wrapper">
       <div class="container-fluid">       
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            @if(session('status'))
          <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>{{session('status')}}</strong>
          </div>
        @endif
            <br>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <h6 style="color: yellow">
                          Anda Tidak Punya Hak Akses
                        </h6>
                        <br> 
                        <strong> 
                              
                        </strong>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="
                        <?php if (Auth::user()->kategori === 'Admin'): ?>
                          {{ route('admin.show',Auth::user()->id)}}
                              <?php endif ?>
                              <?php if (Auth::user()->kategori === 'Pimpinan'): ?>
                                {{ route('admins.show',Auth::user()->id)}}
                              <?php endif ?>">View Details</a>
                      <div class="small text-white">
                        <i class="fas fa-angle-right"></i>
                      </div>
                    </div>
                </div>
            </div>
                  
        </div>
      </div>
    </div>    
  </div>
    </div>
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright©rani 2024</span>
        </div>
      </div>
    </footer>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin ingin Keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Keluar" Jika Anda Yakin Untuk akhiri session ini.. Terimakasi!!.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          {{ __('Keluar') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('startboot/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('startboot/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('startboot/vendor/jquery-easing/jquery.easing.min.js')}}"></script> 
  <script src="{{asset('startboot/js/sb-admin.min.js')}}"></script> 
</body>
@yield('script')
</html>