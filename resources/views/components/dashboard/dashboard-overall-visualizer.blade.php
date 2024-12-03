<div class = "row">
    @props(
        [
            'pendingAuctionsCount',
            'liveAuctionsCount',
            'upcomingAuctionsCount',
            'oldAuctions',
            'registeredUsers',
            'systemAdmins',
            'pendingFundTransfer'
        ]
    )
    <div class = "col-md-8 my-3">
        <div class = "shadow text-center p-3 blinking-background" style = "background: #49a949">
            <i class="fa-solid fa-pause fa-3x"></i>
            <h3 class = "mt-3 text-white">Live Auction</h3>
            <b class = "text-white" style = "font-size: 30px">{{ $liveAuctionsCount }}</b>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background: #dbdbfb">
            <i class="fa-solid fa-hourglass-start fa-3x"></i>
            <h3 class = "mt-3">Upcoming Auction</h3>
            <b style = "font-size: 30px">{{ $upcomingAuctionsCount }}</b>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background: #eded99">
            <i class="fa-solid fa-spinner fa-3x"></i>
            <h3 class = "mt-3">Pending Products</h3>
            <b style = "font-size: 30px">{{ $pendingAuctionsCount }}</b>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background:#ffffdc">
        <i class="fa-solid fa-sack-dollar fa-3x"></i>

            <h3 class = "mt-3">Pending Fund Transfer&nbsp;<i class="fa-solid fa-circle-info" style = "font-size:20px" data-bs-toggle="tooltip" data-bs-placement="top" title="Todo: fund need to transfer from bid winner to to the product owner"></i></h3>
            <b style = "font-size: 30px">{{ $pendingFundTransfer }}</b>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background: #d7ffff;padding-bottom:0px !important">
        <i class="fa-solid fa-users fa-3x"></i>
            <h3 class = "mt-3">System Users</h3>
            <div class = "row">
                <div class = "col-md-6" style="padding: 20px;background:#9ad1d1;">
                    <b>{{$systemAdmins}}</b><br>
                    <b>[System Admins]</b>
                </div>
                <div class = "col-md-6" style="padding: 20px;background:#b6ecec;">
                    <b>{{$registeredUsers}}</b><br>
                    <b>[Registered Users]</b>
                </div>
            </div>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background: #ea7878">
            <i class="fa-solid fa-clock fa-3x text-white"></i>
            <h3 class = "mt-3 text-white">Expired Auction (Paid)</h3>
            <b class = "text-white" style = "font-size: 30px">{{count($oldAuctions["expired_with_paid"])}}</b>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background: #ea7878">
            <i class="fa-solid fa-clock fa-3x text-white"></i>
            <h3 class = "mt-3 text-white">Expired Auction (Unpaid)</h3>
            <b class = "text-white" style = "font-size: 30px">{{count($oldAuctions["expired_with_unpaid"])}}</b>
        </div>
    </div>
    <div class = "col-md-4 my-3">
        <div class = "shadow text-center p-3" style = "background: #ea7878">
            <i class="fa-solid fa-clock fa-3x text-white"></i>
            <h3 class = "mt-3 text-white">Expired Auction (No Bids)</h3>
            <b class = "text-white" style = "font-size: 30px">{{count($oldAuctions["expired_with_zero_bids"])}}</b>
        </div>
    </div>
</div>