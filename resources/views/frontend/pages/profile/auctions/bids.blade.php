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
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                    <select class="form-select mb-3" id = "bid-selector">
                        <option value = "live">Live Bids</option>
                        <option value = "old" selected>Old Bids</option>
                    </select>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered class" id = "example">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Start Price</th>
                                    <th>End Price</th>
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
                                    <td>{{ $bid->product->start_price }}</td>
                                    <td>{{ $bid->product->end_price }}</td>
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
</div>
@endsection

@section("js")
<script>
    $(document).ready(function() {

        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Get the value of the "bid_type" query parameter
        var bidTypeParam = getUrlParameter('bid_type');

        // Set the selected option in the select box based on the query parameter
        if (bidTypeParam === 'live') {
            $('#bid-selector').val('live');
        } else if (bidTypeParam === 'old') {
            $('#bid-selector').val('old');
        }

        // Attach a change event listener to the select input
        $("#bid-selector").change(function() {
            // Reload the page when the select input changes
            var selectedValue = $(this).val();

            // Update the URL with the selected value as a query parameter
            var newUrl = window.location.href.split('?')[0] + '?bid_type=' + selectedValue;
            history.pushState({}, '', newUrl);

            // Reload the page with the updated URL
            location.reload();
        });
    });
</script>

@endsection
