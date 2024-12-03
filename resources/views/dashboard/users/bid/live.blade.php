@extends('layouts.master')

@section('content')
<x-shadow-box shadowClass="shadow">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <p style = "font-size: 13px">
                
            </p>
            <x-user-bid-visualizer
                :liveBidsCount="$_live_bids"
                :oldBidsCount="$_old_bids"
            >
            </x-user-bid-visualizer>
            <x-section-head>
                <div class = "d-flex flex-column">
                    <span class = "badge badge-secondary" style = "font-size: 12px">{{ $info['user']->name}} - {{ $info['user']->email}}</span>
                </div>
            </x-section-head>
        </div>
        <div class="col-md-12">
            @include('dashboard.users.bid.partial.bid-head-tabs')
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Bid Amount</th>
                                <th>Bid Date</th>
                                <th>Bid Status</th>
                                <th>Payment Status</th>
                                <th>Result</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $bid)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $bid->product->name }}</td>
                                <td>{{ $bid->product->category?->name }}</td>
                                <td><?php
                                    $product = $bid->product;
                                    $startPrice = $product->start_price;
                                    $endPrice = $product->end_price;
                                ?>
                                {{ $product->formatted($startPrice) }} - {{  $endPrice ? $product->formatted($endPrice) : "NULL" }}</td>
                                <td>{{ $bid->bid_amount }}</td>
                                <td>{{ $bid->formatted_bid_date }}</td>
                                <td>
                                    @if($bid->product->is_live)
                                    <span class="badge badge-success">Live</span>
                                    @else
                                    <span class="badge badge-danger">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bid->paid)
                                    <span class="badge badge-success">Paid</span>
                                    @elseif ($bid->product->is_live)
                                    -
                                    @else
                                    <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                @if($bid->granted == 1)
                                    <span class="badge badge-success">Granted</span>
                                @else
                                    <span class="badge badge-warning">Not granted.</span>
                                @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('products.show', $bid->product->id) }}">
                                        <i class="fa-solid fa-circle-info"></i>&nbsp;Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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