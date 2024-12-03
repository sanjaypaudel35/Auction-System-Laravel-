@extends('frontend.layouts.master')

@section('content')
<div class="d-flex justify-content-around curved-bg-design">
    <div class="container" style="position:absolute;top:120px">
        <div class="row justify-content-center p-3">
            <div class="col-md-12">
                <x-shadow-box shadowClass="shadow" :enableBorderRadius="true">
                    <div class="product-detail-img-wrapper">
                        <img src="{{ asset('storage/'.$product->image)}}" />
                    </div>
                </x-shadow-box>
            </div>
        </div>
    </div>
</div>
<div class="container" style="margin-top: 250px">
    <div class="row my-5">
        <div class="col-md-8">
            <h1 class="product-detail-title">{{ $product->name }}</h1>
            <div class="d-flex">
                <div class="mx-2 product-detail-sub-info"><b>Ads by: </b>&nbsp;<span>{{ $product->show_product_owner ? $product->user->name : "anonymous" }}</span></div>
                <div class="mx-2 product-detail-sub-info"><b>Category: </b>&nbsp;<span>{{ $product->category->name }}</span></div>
            </div>
            <p class="product-description p-2 my-3">{{ $product->description }}
            <div class="show-detail-box">
                <div class="d-flex justify-content-between">
                    <p class="show-detail-box-info-head">Current Bid:</p>
                    <p class="show-detail-box-info-value">{{ $product->formatted($product->topBids->first()?->bid_amount ?? 0) }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="show-detail-box-info-head">Next Min Bid Amount:</p>
                    @php
                    $topBid = $product->topBids->first()?->bid_amount;
                    $bidIncrement = $product->bid_increment_amount;
                    @endphp
                    <p class="show-detail-box-info-value">{{ $product->formatted($topBid ? ($topBid + $bidIncrement) : $product->start_price) }}</p>
                </div>
                <div class="d-flex justify-content-between py-3 show-detail-sub-info-wrapper" style="line-height:0.8">
                    <div>
                        <p class="show-detail-box-info-sub-head">Start price:&nbsp;<span class="show-detail-box-info-sub-head-value-price">{{ $product->formatted($product->start_price)}}</span></p>
                        <p class="show-detail-box-info-sub-head">End price:&nbsp;<span class="show-detail-box-info-sub-head-value-price">{{ $product->price_limit ? '-' : $product->formatted($product->end_price) }}</span></p>
                    </div>
                    <div>
                        <p class="show-detail-box-info-sub-head">Start date:&nbsp;<span class="show-detail-box-info-sub-head-value-date">{{ $product->formatted_start_date }}</span></p>
                        <p class="show-detail-box-info-sub-head">End date:&nbsp;<span class="show-detail-box-info-sub-head-value-date">{{ $product->formatted_end_date }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="product-detail-bidder-info-wrapper p-3">
                <div class="text-center counter pb-2">
                    <?php
                        $isExpired = $product->expired || $product->expired_early;
                      $productIsUpcoming = $product->is_upcoming;
                    ?>
                    @if ($product->is_upcoming)
                        <h3>This auction starts in:</h3>
                    @elseif(!$product->expired_early)
                        <h3>This auction ends in:</h3>
                    @endif

                    @if(!$product->expired_early)
                        <div class="bid-counter" style="font-size: 25px">
                            <span
                                class="countdown"
                                data-isupcoming="{{$productIsUpcoming}}"
                                data-countdown="{{$product->end_date}}"
                                data-countdownstartdate="{{$product->start_date}}"
                                data-isexpired="{{$isExpired}}"
                            ></span>
                        </div>
                    @endif
                </div>
                <section class="d-flex py-4">
                    <div style="height: 50px; width: 50px">
                        <img src="{{asset('assets/system_images/bidimage.png')}}" style="height: 100%; width: 100%"></img>
                    </div>
                    <div class="px-3 product-detail-total-bids-div">
                        <h2>{{ $product->bids->count()}}</h2>
                        <p>Total bids</p>
                    </div>
                </section>
                <div class="text-center">
                    @php
                    $myBids = $product->bids->where("user_id", auth()->user()?->id)->first()?->bid_amount;
                    @endphp
                    @if ($myBids)
                    <p style="color: red">You have bidded <b style="color: green">{{ $product->formatted($myBids) }}</b></p>
                    @else
                    <p style="color: red">You have not yet bidded.</p>
                    @endif
                </div>
            </div>
            @if (auth()->check())
                @if (
                    auth()->user()->id != $product->user_id
                    && !$product->expired
                    && !$product->is_upcoming
                    && !$product->expired_early
                )
                    <div class="mt-3 text-center p-3 shadow bid-box" id="bid_box">
                        <form method="post" action="{{route('products.bid')}}">
                            @csrf
                            <input type="hidden" value="{{$product->id}}" name="product_id"></input>
                            <input type="number" name="bid_amount" class="p-2" style="border-radius: 15px" placeholder="Enter bid amount" required="required" />
                            <div class="bid-btn-wrapper text-center py-3 mt-2">
                                <button type="submit" class="bid-button">{{($myBids) ? "Update a bid" : "Submit a bid"}}</button>
                            </div>
                        </form>
                    </div>
                @endif
            @else
                @if (!$product->expired)
                    <div class="mt-5 text-center shadow-lg p-3"><i class="fa-solid   fa-right-to-bracket"></i>&nbsp;<b style="color: red">Please login first to bid this item</b>&nbsp;<a href="{{route('login')}}">login now</a></div>
                @endif
            @endif

            <?php $winner = $product->topBids->where("granted", 1)?->first(); ?>
            @if (
                auth()->check()
                && $winner?->user_id == auth()->user()->id
                && $winner?->paid == 0
            )
                <h3 class="mt-3"><b style="color: green">Congratulation !!</b>&nbsp;you have won this item.</h3>
                <div class="py-3 shadow px-3 mt-3">
                    <img src="{{asset('assets/system_images/esewa_logo.png')}}" style="height: 40px; width: 150px" />
                    @php $userBidId = $product->topBids->where("granted", 1)?->first()?->id @endphp
                    <a class="btn-success btn-lg" href = "{{ route('payment.esewa', $userBidId) }}">Pay now</a>
                </div>
            @else
                <p>This product is granted to <b>{{$product->topBids->where("granted", 1)?->first()?->user->name}}.</b></p>
            @endif
        </div>
    </div>
</div>
<div class="container mb-5">
    @if ($product->is_live || $product->expired)
        <x-dashboard-top-bidders :topBidders="$product->topBids"></x-dashboard-top-bidders>
    @endif
</div>
@endsection
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

        var x = setInterval(function() {
            var now = new Date().getTime();
            console.log(new Date(now), new Date(countDownDate));
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
            console.log(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
            if (distance < 0 || isExpired) {
                clearInterval(x);
                element.innerHTML = "EXPIRED";
                document.getElementById("bid_box").innerHTML = "<b style = 'color: red'>Bid is expired</b>";
            }
        }, 1000);
    }

    // Get all elements with class "countdown"
    var countdownElements = document.querySelectorAll(".countdown");

    // Loop through each element and start the countdown
    countdownElements.forEach(function(element) {
        updateCountdown(element);
    });
</script>
@endsection