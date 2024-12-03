@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p style = "font-size: 13px">
                </p>
                <x-section-head>
                    @if ($product->is_live)
                        Live Auction
                    @elseif ($product->is_upcoming && $product->approved == 1)
                        Upcoming Auction
                    @elseif ($product->approved == 0)
                        Pending Auction
                    @else
                        Product Detail
                    @endif
                </x-section-head>
            </div>
        </div>
        <div class="row my-5">
            <div class = "col-md-12">
                <x-shadow-box shadowClass="shadow" :enableBorderRadius="true">
                    <div class="product-detail-img-wrapper">
                        <img src="{{ asset('storage/'.$product->image)}}" />
                    </div>
                </x-shadow-box>
            </div>
            <div class="col-md-8">
                <h1 class="product-detail-title">{{ $product->name }}</h1>
                <div class="d-flex">
                    <div class="mx-2 product-detail-sub-info"><b>Ads by: </b>&nbsp;<span>{{ $product->show_product_owner ? $product->user->name : "anonymous" }}</span></br>
                    @if (!$product->show_product_owner)
                    <span style = "color: red; font-size: 12px">[user {{ ($product->user->name)}} has marked him self as hide my identity] </span>
                    @endif
            </div>
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
                        @else
                            <h3>This auction ends in:</h3>
                        @endif
                        <div class="bid-counter" style="font-size: 25px">
                            <span
                                class="countdown"
                                data-isupcoming="{{$productIsUpcoming}}"
                                data-isexpired="{{$isExpired}}"
                                data-countdownstartdate="{{$product->start_date}}"
                                data-countdown="{{$product->end_date}}"
                            >
                            </span>
                        </div>
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
                </div>
            </div>
        </div>
        <div class="row my-3 d-flex justify-content-end px-3">
            <form method="post" action="{{route('dashboard.products.destroy', $product->id)}}">
                @csrf
                <div class="col-md-12 text-right">
                    @method("DELETE")
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product? All its related record will be deleted.')"><i class="fa-regular fa-trash-can"></i>&nbsp;Delete the record</button>
                </div>
            </form>
            <div>
                @if ($product->approved == 0)
                    &nbsp;<a type="submit" href="{{route('dashboard.products.pending.approve', $product->id)}}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to approve this product?')">Approve</a>
                @endif
                @if (!$product->is_live && !$product->expired)
                <a type="submit" class="btn btn-primary" href="{{ route('dashboard.products.edit', $product->id) }}">Edit Product</a>
                @endif
            </div>
        </div>
        @if ($product->is_live || $product->expired)
        <x-dashboard-top-bidders :topBidders="$product->topBids"></x-dashboard-top-bidders>
        @endif
    </x-shadow-box>
@endsection
@section('js')
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