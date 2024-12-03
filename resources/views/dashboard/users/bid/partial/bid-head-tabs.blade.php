@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
@endphp
<ul class="nav dashboard-product-tab mb-3" id="myTab" role="tablist">
    <li>
        <a class="nav-link active {{ ($currentRouteName == 'dashboard.users.bid.live') ? 'active-profile-tab' : ''}}" id="dashboard.users.bid.live" href="{{ route('dashboard.users.bid.live', $info['user']->id) }}">Live Bids
            @if ($currentRouteName == 'dashboard.users.bid.live')
            <b style="color: yellow">(@php echo count($products)@endphp)</b>
            @endif
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'dashboard.users.bid.history') ? 'active-profile-tab' : ''}}" id="dashboard.users.bid.history" href="{{ route('dashboard.users.bid.history', $info['user']->id) }}">Old Bids
        @if ($currentRouteName == 'dashboard.users.bid.history')
        <b style="color: yellow">(@php echo count($products)@endphp)</b>
        @endif
        </a>
    </li>
</ul>