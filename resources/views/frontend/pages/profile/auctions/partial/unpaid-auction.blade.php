<h4>Unpaid Auction</h4>
<table class="display table table-bordered" id = "example">
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
        @foreach($expiredProducts['total_success_unpaid_ads'] as $key => $product)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->product->name }}</td>
            <td>{{ $product->product->category?->name }}</td>
            <td>{{ $product->user?->name }}</td>
            <td>{{ $product->product->start_price }}</td>
            <td>{{ $product->product->end_price }}</td>
            <td>
                @if ($product->product->status == 0)
                <span class="badge badge-danger">Disactive</span>
                @else
                <span class="badge badge-success">Active</span>
                @endif
            </td>
            <td>
                <a class="btn btn-primary btn-sm" href="{{ route('products.show', $product->product->id) }}">
                    <i class="fa-solid fa-circle-info"></i>&nbsp;Detail
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>