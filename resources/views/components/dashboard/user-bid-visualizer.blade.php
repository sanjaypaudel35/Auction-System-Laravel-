@props(['liveBidsCount', 'oldBidsCount'])
<div class = "row">
    <div class = "col-md-3">
        <div class = "shadow text-center p-3" style = "background: #eded99">
            <i class="fa-solid fa-clock fa-3x"></i>
            <h3 class = "mt-3">Old Bids</h3>
            <b style = "font-size: 30px">{{$oldBidsCount}}</b>
        </div>
    </div>
    <div class = "col-md-3">
        <div class = "shadow text-center p-3" style = "background: #49a949">
            <i class="fa-solid fa-pause fa-3x"></i>
            <h3 class = "mt-3 text-white">Live Auction</h3>
            <b class = "text-white" style = "font-size: 30px">{{$liveBidsCount}}</b>
        </div>
    </div>
</div>