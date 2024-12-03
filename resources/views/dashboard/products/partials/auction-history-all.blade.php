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
        @foreach($products["products"] as $key => $product)
        <tr>
            <td>{{ $key + 1 }}</td>
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
            </td>
        </tr>
        @endforeach
    </tbody>
</table>