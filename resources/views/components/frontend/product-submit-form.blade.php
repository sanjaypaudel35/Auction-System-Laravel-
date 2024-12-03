<div class="row">
@props(
        [
            'product',
            'submitButtonLabel'
        ]
    )
    <div class="col-md-8">
        <div class="form-group">
            <label for="product">Select a category:</label>
            <select class="form-control" name="category_id" id = "category">
                <option value="0" disabled selected="selected">Choose a category</option>
                @foreach ($categories as $key => $category)
                <option value="{{$category->id}}" {{ ( old('category_id') == $category->id || $category->id == $product->category_id ) ? 'selected' : '' }}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="product">Product Name:</label><span class="required">*</span>
            <input type="text" class="form-control" placeholder="Enter Name" id="product_name" , value="{{old('name') ?? $product->name}}" name="name">
        </div>
        <div class="form-group">
            <label for="description">Description:</label><span class="required">*</span>
            <textarea class="form-control" placeholder="Enter description" id="product_description" name="description">
                {{old('description') ?? $product->description}}
            </textarea>
        </div>
        <!-- <div class="form-group">
            <label for="product">Commission offer: (In percentage)</label>
            <input type="number" class="form-control" value="{{old('commission_offer')}}" placeholder="Enter percentage value" name="commission_offer">
        </div> -->

        <div class="form-group form-check pt-3" style="border-top: 2px solid navy">
            <label class="form-check-label">
                <input class="form-check-input" @if($product->price_limit) checked @endif {{ (old('price_limit') ) ? 'checked' : '' }} value="1" type="checkbox" name="price_limit" id="price_limit" onclick="toggleInput()" /><b>No Upper Price Limit</b>
            </label>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product">Start price</label><span class="required">*</span>
                    <input type="number" class="form-control" value="{{old('start_price') ?? $product->start_price}}" placeholder="Enter start price" name="start_price">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product">End price</label>
                    <input type="number" class="form-control" value="{{old('end_price') ?? $product->end_price}}" placeholder="Enter price limit" name="end_price" id="end_price">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="product">Min bid increment amount.</label><span class="required">*</span>
                    <input type="number" class="form-control" value="{{old('bid_increment_amount') ?? $product->bid_increment_amount}}" placeholder="Enter minimum bid increment amount" name="bid_increment_amount">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product">Start Date</label><span></span><span class="required">*</span>
                    <input type="datetime-local" id="datetime" class="form-control" value="{{old('start_date') ?? $product->start_date}}" placeholder="Enter start price" name="start_date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product">End Date</label><span class="required">*</span>
                    <input type="datetime-local" id="datetimeend" class="form-control" value="{{old('end_date') ?? $product->end_date}}" placeholder="Enter price limit" name="end_date">
                </div>
            </div>
        </div>

        <div class="form-group form-check">
            <label class="form-check-label">
                <input
                    class="form-check-input"
                    type="checkbox"
                    @if($product->show_product_owner)
                        checked
                    @else
                        unchecked
                    @endif
                    name="show_product_owner"
                />Show my identity
            </label>
        </div>
    </div>
    <div class="col-md-4">
        <!-- signature -->
        <div class="form-group form-inline" id="signature_section">
            <label class="form-label-text label-text-file">Product image<span class="required">*</span></label>
            <label for="product_image" class="form-label-text auction-image-label">Select Product to upload.</label>
            <input type="file" name="image" id="product_image" class="form-control auction-image-input" accept="image/*,application/jpg,application/pdf" />
            <span id="image_size" style="opacity:0.7;margin-left:20px"></span>
            <div class="doc-img-wrapper" id="preview-image-size-wrapper" style="display: none"><img id="preview_image" style="display:none;width:100%;" /></div>
        </div>
        <!-- end -->
    </div>
</div>
<div class="d-flex justify-content-end">
    @if (auth()->check())
    <button type="submit" class="btn btn-primary bid-button">{{$submitButtonLabel ?? "Submit"}}</button>
    @else
    <p style="color:red">You are not login please <a style="color: blue" href="{{ route('login') }}">Login</a></p>
    @endif
</div>