<div class="row">
    <div class="col-md-12">
        <h2> Top bidders list</h2>
        <ul class="list-group">
            @foreach($topBidders as $key => $topBidder)
            @php
            $bidUser = $topBidder->user;
            @endphp
            <li
                class="list-group-item d-flex justify-content-between"
                style = "
                    background-color: @if($key == 0) #b2f6b2; @else white; @endif
                    font-size: @if($key == 0) 20px @endif
                ">
            <a href="#"><span style = "font-weight:bold;color:black">
                @if($key == 0)
                    <i class="fa-solid fa-trophy" style = "color:#afaf17"></i>
                @endif
                &nbsp;#rank{{$key + 1.}}:</span>&nbsp;&nbsp;{{ $bidUser?->name }} ({{$bidUser?->email}})
                </a>
                <span><b>Bidded at:</b> {{$topBidder->formatted_bid_date}}</span>
                <span><b>Amount:</b> {{$topBidder->bid_amount}} <span>
                @if (auth()->user()?->role?->slug == "super-admin")
                    @if ($topBidder->paid)
                        <b class="badge badge-success" style = "font-size: 14px">&nbsp;paid</b>
                    @else
                        <b class="badge badge-danger" style = "font-size: 14px">&nbsp;unpaid</b>
                    @endif
                @endif
                </span></span>
            </li>
            @endforeach
        </ul>
    </div>
</div>