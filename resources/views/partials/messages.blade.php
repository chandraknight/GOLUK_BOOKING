<div class="container text-center"> 
@if(count($errors)>0)
	@php $error = $errors->first(); @endphp 
		<div class="alert">
			{{$error}}
		</div>
@endif

@if(session('success'))
	<div class="alert alert-success">
		{{session('success')}}
	</div>
@endif

@if(session('error'))
	<div class="alert alert-danger">
		{{session('error')}}
	</div>
@endif				
</div>