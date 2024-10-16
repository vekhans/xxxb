@extends('layouts.admin.thome')
@section('content')
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
					 
				    <div class="col-xl-8 col-md-8">
				        <div class="card bg-success text-white mb-4">
				            <div class="card-body">
				                <h6 style="color: yellow">
				                	Tamu
				                </h6> 
				                <br>
				                <strong> 
				                     {{$pesantamu}}
				                </strong>
				                <p>
				                	
				                </p>
				                 
				            </div>
				             
				        </div>
				    </div>
				         
				</div>
		 	</div>
		</div>    
	</div>
</div>
@endsection