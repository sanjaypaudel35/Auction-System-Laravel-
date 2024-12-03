<h4 style = "color: green; font-weight:bold">Paid Auction</h4>
<table class="table table-bordered display" id = "example-auction-history-paid">
    <thead>
        <tr>
            <th>S.N</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Granted to</th>
            <th>Start Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expiredProducts['total_success_paid_ads'] as $key => $product)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->product->name }}</td>
            <td>{{ $product->product->category?->name }}</td>
            <td>{{ $product->user?->name }}</td>
            <td>{{ $product->product->start_price }} - {{ $product->product->end_price ?? "NULL"}}</td>
            <td>
                @if ($product->product->status == 0)
                <span class="badge badge-danger">Disactive</span>
                @else
                <span class="badge badge-success">Active</span>
                @endif
            </td>
            <td>
                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.products.show', $product->product->id) }}">
                    <i class="fa-solid fa-circle-info"></i>&nbsp;Detail
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>