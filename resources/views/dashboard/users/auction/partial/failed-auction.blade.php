<h4 style = "color: red; font-weight:bold">Failed Auction</h4>
<table class="table table-bordered display" id = "example-auction-failed">
    <thead>
        <tr>
            <th>S.N</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expiredProducts['total_unsuccess_ads'] as $key => $product)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category?->name }}</td>
            <td><?php $startPrice = $product->start_price; $endPrice = $product->start_price;?>{{ $product->formatted($startPrice) }} - {{ $product->formatted($endPrice) ?? "NULL" }}</td>
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
            </td>
        </tr>
        @endforeach
    </tbody>
</table>