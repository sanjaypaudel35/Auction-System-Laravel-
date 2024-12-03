@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    {{ $info['title'] }}
                </x-section-head>
            </div>
            <div class="col-md-12">
            @include('frontend.pages.profile.auctions.partial.auction-head-tabs')
            </div>
            <div class="col-md-12">
            <table class="display table table-bordered" id = "example" style = "width: 100%; padding:20px">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>User Name</th>
                        <th>Start Price</th>
                        <th>End Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category?->name }}</td>
                        <td>{{ $product->user?->name }}</td>
                        <td>{{ $product->start_price }}</td>
                        <td>{{ $product->end_price }}</td>
                        <td>
                            @if ($product->status == 0)
                            <span class="badge badge-danger">Disactive</span>
                            @else
                            <span class="badge badge-success">Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($product->is_live || $product->expired || $product->is_upcoming)
                                <a class="btn btn-primary btn-sm" href="{{ route('products.show', $product->id) }}">
                                    <i class="fa-solid fa-circle-info"></i>&nbsp;Detail
                                </a>
                            @else
                            <!-- pending -->
                                <a class="btn btn-primary btn-sm" href="{{ route('profile.products.edit', $product->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit
                                </a>
                                @if (!$product->expired)
                                    <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')" href="{{ route('profile.products.delete', $product->id) }}"><i class="fa-regular fa-trash-can"></i>&nbsp;Delete</a>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-shadow-box>
</div>
@endsection
@section('js')
<script>
    var route = @json($info['route']);
    var activeTab = document.getElementById(route);
    activeTab.classList.add("active-tab");
</script>
@endsection