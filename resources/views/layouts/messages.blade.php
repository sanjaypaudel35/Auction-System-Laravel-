@if(count($errors)>0)
 @foreach($errors->all() as $error)
    <div class ="alert alert-danger alert-dismissible">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
    	{{$error}}
    </div>
    @endforeach
 @endif

 @if(session('success'))
<div class="alert alert-success alert-dismissible" style="margin-top:20px;background-color:#57ad57;color:white">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>{{session('success')}}</strong>
</div>
 @endif
  @if(session('error'))
 <div class="alert alert-danger" style="margin-top:20px;">
 	  <button type="button" class="close" data-dismiss="alert">&times;</button>
 	{{session('error')}}
 </div>
 @endif