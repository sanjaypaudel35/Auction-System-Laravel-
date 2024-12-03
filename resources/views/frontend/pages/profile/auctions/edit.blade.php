@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    Edit Product Detail
                </x-section-head>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-12">
                <div style = "background-color: #d6d6d6;" class = "mb-5 p-3">
                    <b style = "color:green">Previous image:</b>
                    <div class="auction-card-top my-3" style="width: 200px; height: 200px">
                        <img src="{{ asset('storage/'.$product->image)}}" style = "object-fit: contain"/>
                    </div>
                </div>
                <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-product-submit-form :product="$product" />
                </form>
            </div>
    </x-shadow-box>
</div>
@endsection
@section('js')
<script>
     var categorySelect = document.getElementById("category");
     categorySelect.disabled = true
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