@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
@endphp
<ul class="nav dashboard-product-tab mb-3" id="myTab" role="tablist">
    <li>
        <a class="nav-link active {{ ($currentRouteName == 'dashboard.users.auction.pending') ? 'active-profile-tab' : ''}}" id="dashboard.users.auction.pending" href="{{ route('dashboard.users.auction.pending', $info['user']->id) }}">Pending Products
            @if ($currentRouteName == 'dashboard.users.auction.pending')
            <b style="color: yellow">(@php echo count($products)@endphp)</b>
            @endif
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'dashboard.users.auction.live') ? 'active-profile-tab' : ''}}" id="dashboard.users.auction.live" href="{{ route('dashboard.users.auction.live', $info['user']->id) }}">Live Auction
        @if ($currentRouteName == 'dashboard.users.auction.live')
        <b style="color: yellow">(@php echo count($products)@endphp)</b>
        @endif
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'dashboard.users.auction.upcoming') ? 'active-profile-tab' : ''}}" id="dashboard.users.auction.upcoming" href="{{ route('dashboard.users.auction.upcoming', $info['user']->id) }}">Upcoming Auction
            @if ($currentRouteName == 'dashboard.users.auction.upcoming')
            <b style="color: yellow">(@php echo count($products)@endphp)</b>
            @endif
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'dashboard.users.auction.history') ? 'active-profile-tab' : ''}}" id="dashboard.users.auction.history" href="{{ route('dashboard.users.auction.history', $info['user']->id) }}">Auction History
        @if ($currentRouteName == 'dashboard.users.auction.history')
            <b style="color: yellow">(@php echo count($expiredProducts["total_success_paid_ads"])
            + count($expiredProducts["total_success_unpaid_ads"]) @endphp)</b>
            @endif
        </a>
    </li>
</ul>