
<div class="auction-card upcoming-card shadow-lg">
    <div class="auction-card-top ma-2">
        <img src="{{ asset('storage/'.$product->image)}}" />
    </div>
    <div class="auction-card-bottom py-3 px-2">
        <div class="product-title-wrapper pt-2">
            {{ $product->name }}
        </div>
        <div class="bid-info-wrapper pb-2 d-flex justify-content-between" style = "font-size: 13px">
                <div><span class = "start_price_text">Start price:</span>&nbsp;<span class = "price_range_value">{{ $product->formatted($product->start_price) }}</span></div>
                <div><span class = "end_price_text">End price:</span>&nbsp;<span class = "price_range_value">{{ $product->price_limit ? "-" : $product->formatted($product->end_price)}}</span></div>
        </div>
        <div class="bid-section-wrapper d-flex justify-content-between py-2 align-items-center">
            <div class = "px-2 d-flex w-100 justify-content-around align-items-center">
                <div class = "mr-2">
                    <i class="fa-solid fa-calendar auction-calendar-icon-green"></i>
                </div>
                <div class="amount-content">
                    <div class="current">Start Date</div>
                    <div class="amount" style = "line-height: 1.3"> {{ $product->formatted_start_date }} </div>
                </div>
            </div>
            <div class = "bid-section-verticle-separator"></div>
            <div class = "px-2 d-flex w-100 justify-content-around align-items-center">
                <div class = "mr-2">
                    <i class="fa-solid fa-calendar  auction-calendar-icon-red"></i>
                </div>
                <div class="amount-content">
                    <div class="total-bid-text">End date</div>
                    <div class="amount" style = "line-height: 1.3"> {{ $product->formatted_end_date }} </div>
                </div>
            </div>
        </div>
        <div class="bid-btn-wrapper text-center py-3 mt-2">
            <a class = "bid-button" href="{{asset('products/'.$product->id)}}">View Detail</a>
        </div>
    </div>
</div>
