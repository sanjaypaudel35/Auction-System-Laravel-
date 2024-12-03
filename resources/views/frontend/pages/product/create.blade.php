@extends('frontend.layouts.master')

@section('content')
<div class="container">
  <div class="row justify-content-center p-3">
    <div class="col-md-12">
      <x-shadow-box shadowClass="shadow">
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <x-product-submit-form />
        </form>
      </x-shadow-box>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
        const now = new Date().toISOString().slice(0, 16);
        document.getElementById("datetime").min = now;
        document.getElementById("datetimeend").min = now;
        var checkbox = document.getElementById("price_limit");
      var inputBox = document.getElementById("end_price");

    inputBox.disabled = checkbox.checked;
    </script>
<script>
  function toggleInput() {
    var checkbox = document.getElementById("price_limit");
    var inputBox = document.getElementById("end_price");

    inputBox.disabled = checkbox.checked;
  }
  //image
  $('#product_image').bind('change', function() {
    size_image = 0;
    //preview
    var output = document.getElementById('preview_image');
    $('#preview_image').show();
    $("#preview-image-size-wrapper").show();
    output.src = URL.createObjectURL(this.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
    //end of preveiw

    var type = '';
    var size_image_to_show = 0;
    var size_image_bytes = this.files[0].size;
    var size_image_kb = size_image_bytes / 1024;
    if (size_image_kb < 1024) {
      size_image_to_show = size_image_kb;
      type = "KB";
    } else {
      size_image_to_show = size_image_kb / 1024;
      type = "MB"
    }
    size_image = size_image_kb;
    $("#image_size").html('(size: ' + size_image_to_show.toFixed(2) + ' ' + type + ')');
    check_required_docs();
  });
  //end
</script>
@endsection