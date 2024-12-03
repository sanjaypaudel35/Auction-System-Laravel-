@props(['pendingAuctionsCount', 'liveAuctionsCount', 'upcomingAuctionsCount', 'oldAuctionsCount'])
<div class = "row">
    <div class = "col-md-3">
        <div class = "shadow text-center p-3" style = "background: #eded99">
            <i class="fa-solid fa-spinner fa-3x"></i>
            <h3 class = "mt-3">Pending Products</h3>
            <b style = "font-size: 30px">{{$pendingAuctionsCount}}</b>
        </div>
    </div>
    <div class = "col-md-3">
        <div class = "shadow text-center p-3" style = "background: #49a949">
            <i class="fa-solid fa-pause fa-3x"></i>
            <h3 class = "mt-3 text-white">Live Auction</h3>
            <b class = "text-white" style = "font-size: 30px">{{$liveAuctionsCount}}</b>
        </div>
    </div>
    <div class = "col-md-3">
        <div class = "shadow text-center p-3" style = "background: #dbdbfb">
            <i class="fa-solid fa-hourglass-start fa-3x"></i>
            <h3 class = "mt-3">Upcoming Auction</h3>
            <b style = "font-size: 30px">{{$upcomingAuctionsCount}}</b>
        </div>
    </div>
    <div class = "col-md-3">
        <div class = "shadow text-center p-3" style = "background: #e95353">
            <i class="fa-solid fa-clock fa-3x text-white"></i>
            <h3 class = "mt-3 text-white">Old Auction</h3>
            <b class = "text-white" style = "font-size: 30px">{{$oldAuctionsCount}}</b>
        </div>
    </div>
</div>