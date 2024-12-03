@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    {{ $info['title'] }}
                </x-section-head>
            </div>

            <!-- <div class="col-md-12">
                <ul class="nav dashboard-product-tab mb-3" id="myTab" role="tablist">
                    <li>
                        <a class="nav-link active" id = "dashboard.products.pending" href="{{ route('dashboard.products.pending') }}">Pending Products</a>
                    </li>
                    <li>
                        <a class="nav-link" id = "dashboard.products.live" href="{{ route('dashboard.products.live') }}">Live Auction</a>
                    </li>
                    <li>
                        <a class="nav-link" id = "dashboard.products.upcoming" href="{{ route('dashboard.products.upcoming') }}">Upcoming Auction</a>
                    </li>
                    <li>
                        <a class="nav-link" id = "dashboard.products.history" href="{{ route('dashboard.products.history') }}">Auction History</a>
                    </li>
                </ul>
            </div> -->

            <div class = "col-md-12">
                <table id="example" class="display table table-bordered" style = "width: 100%; padding:20px">
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
                                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.products.show', $product->id) }}">
                                    <i class="fa-solid fa-circle-info"></i>&nbsp;Detail
                                </a>
                                @if ($product->approved == 0)
                                &nbsp;<a type="submit" href="{{route('dashboard.products.pending.approve', $product->id)}}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to approve this product?')">Approve</a>
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
@endsection
@section('js')
<script>
       var route = @json($info['route']);
       var activeTab = document.getElementById(route);
       activeTab.classList.add("active-tab");
</script>
@endsection