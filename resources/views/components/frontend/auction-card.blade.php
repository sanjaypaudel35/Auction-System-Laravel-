<div class="auction-card shadow">
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
                <div>
                    <i class="fa-solid fa-hammer auction-hammer-icon"></i>
                </div>
                @php
                    $topBid = $product->topBids->first()?->bid_amount;
                    $bidIncrement = $product->bid_increment_amount;
                @endphp
                <div class="amount-content">
                    <div class="current">Current Bid</div>
                    <div class="amount"> {{ $topBid ?? 0 }} </div>
                </div>
            </div>
            <div class = "bid-section-verticle-separator"></div>
            <div class = "px-2 d-flex w-100 justify-content-around align-items-center">
                <div>
                    <i class="fa-solid fa-sack-dollar  auction-dollor-sack-icon"></i>
                </div>
                <div class="amount-content">
                    <div class="total-bid-text">Next Bid</div>
                    <div class="amount"> {{ $topBid ? ($topBid + $bidIncrement) : $product->start_price }} </div>
                </div>
            </div>
        </div>
        <div class="bid-info-wrapper py-2 d-flex justify-content-between">
            <div class = "bid-counter">
                <?php
                    $isExpired = $product->expired || $product->expired_early;
                    $productIsUpcoming = $product->is_upcoming;
                ?>
                <span style = "color: black; opacity: 0.6">
                    @if($productIsUpcoming)
                        Starts In
                    @elseif($product->expired || $product->expired_early)
                    @else
                        Ends In
                    @endif
                </span>
                &nbsp;&nbsp;
                <span
                    class="countdown"
                    data-isupcoming="{{$productIsUpcoming}}"
                    data-isexpired="{{$isExpired}}"
                    data-countdownstartdate="{{$product->start_date}}"
                    data-countdown="{{$product->end_date}}"
                >
                    0d  : 2h  : 18m  : 16s
                </span>
            </div>
        </div>
        <div class="bid-btn-wrapper text-center py-3 mt-2">
            <a class = "bid-button" href="{{asset('products/'.$product->id)}}">View Detail</a>
        </div>
    </div>
</div>
@section("js")
<script>
  // Function to update the countdown for a specific element
function updateCountdown(element) {
    var isExpired = element.dataset.isexpired;
    var isUpcoming = element.dataset.isupcoming;

    if (isUpcoming) {
        var countDownDate = new Date(element.dataset.countdownstartdate).getTime();
    } else {
        var countDownDate = new Date(element.dataset.countdown).getTime();
    }

    var x = setInterval(function () {
     var now = new Date().getTime();
     var distance = countDownDate - now;
     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
     var seconds = Math.floor((distance % (1000 * 60)) / 1000);
     element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
     if (distance < 0 || isExpired) {
       clearInterval(x);
       element.innerHTML = "EXPIRED";
     }
   }, 1000);
}

// Get all elements with class "countdown"
var countdownElements = document.querySelectorAll(".countdown");

// Loop through each element and start the countdown
countdownElements.forEach(function (element) {
  updateCountdown(element);
});
    </script>
@endsection