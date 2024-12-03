@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p style = "font-size: 13px">
                    
                </p>
                <x-user-auction-visualizer
                    :pendingAuctionsCount="$_pending_auctions"
                    :liveAuctionsCount="$_live_auctions"
                    :upcomingAuctionsCount="$_upcoming_auctions"
                    :oldAuctionsCount="$_old_auctions"
                >
                </x-user-auction-visualizer>
                <x-section-head>
                    <div class = "d-flex flex-column">
                        <!-- <span>{{ $info['title'] }}</span> -->
                        <span class = "badge badge-secondary" style = "font-size: 12px">{{ $info['user']->name}} - {{ $info['user']->email}}</span>
                    </div>
                </x-section-head>
            </div>
            <div class="col-md-12">
            @include('dashboard.users.auction.partial.auction-head-tabs')
            </div>
            <div class = "col-md-12">
            <table class="table table-bordered display" id = "example">
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
                            @if (!$product->expired)
                                <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')" href="{{ route('profile.products.delete', $product->id) }}"><i class="fa-regular fa-trash-can"></i>&nbsp;Delete</a>
                            @endif
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