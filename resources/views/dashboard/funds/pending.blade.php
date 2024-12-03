@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p style = "font-size: 13px">
                    
                </p>
                <x-section-head>
                    Funds to be transferred:
                </x-section-head>
            </div>

            <div class = "col-md-12">
                <table class="display table table-bordered" id = "example" style = "width: 100%; padding:20px">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Product Owner</th>
                            <th>Price</th>
                            <th>Bid Amount</th>
                            <th>Granted to</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userBids as $key => $userBid)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $userBid->product->name }}</td>
                            <td>{{ $userBid->product->category->name }}</td>
                            <td>{{ $userBid->product->user->name}}<span style = "color: green">&nbsp;({{$userBid->product->user->email}})</span></td>
                            <td>{{ $userBid->product->start_price }} - {{ $userBid->product->end_price ?? "NULL" }}</td>
                            <td>{{ $userBid->bid_amount }}</td>
                            <td>{{ $userBid->user->name}}<span style = "color: green">&nbsp;({{$userBid->user->email}})</span></td>
                            <td>
                                <a href = "{{ route('dashboard.fund.transfer.paid', $userBid->id) }}" onclick="return confirm('Are you sure you have successfully transfer this bid amount to product owner ?')" class = "btn btn-success btn-sm">Mark as transferred</a>
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
