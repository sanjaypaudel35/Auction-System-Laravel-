@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
@endphp
<ul class="nav dashboard-product-tab mb-3" id="myTab" role="tablist">
    <li>
        <a class="nav-link active {{ ($currentRouteName == 'profile.products.pending') ? 'active-profile-tab' : ''}}" id="profile.products.pending" href="{{ route('profile.products.pending') }}">Pending Products
            <!-- <b style="color: green">(@php echo $_pending_auctions @endphp)</b> -->
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'profile.products.live') ? 'active-profile-tab' : ''}}" id="profile.products.live" href="{{ route('profile.products.live') }}">Live Auction
            <!-- <b style="color: green">(@php echo $_live_auctions @endphp)</b> -->
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'profile.products.upcoming') ? 'active-profile-tab' : ''}}" id="profile.products.upcoming" href="{{ route('profile.products.upcoming') }}">Upcoming Auction
            <!-- <b style="color: green">(@php echo $_upcoming_auctions @endphp)</b> -->
        </a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'profile.products.expired') ? 'active-profile-tab' : ''}}" id="profile.products.expired" href="{{ route('profile.products.expired') }}">Auction History
            <!-- <b style="color: green">(@php echo $_upcoming_auctions @endphp)</b> -->
        </a>
    </li>
</ul>