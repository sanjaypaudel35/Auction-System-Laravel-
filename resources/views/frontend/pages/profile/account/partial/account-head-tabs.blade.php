@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
@endphp
<ul class="nav dashboard-product-tab mb-3 pb-3" id="myTab" role="tablist"  style = "border-bottom: 2px solid #fdf0f0">
    <li>
        <a class="nav-link active {{ ($currentRouteName == 'profile.account.info') ? 'active-profile-tab' : ''}}" href="{{ route('profile.account.info') }}">Profile Information</a>
    </li>
    <li>
        <a class="nav-link active {{ ($currentRouteName == 'profile.account.edit') ? 'active-profile-tab' : ''}}" href="{{ route('profile.account.edit') }}">Profile Edit</a>
    </li>
    <li>
        <a class="nav-link {{ ($currentRouteName == 'profile.account.password.edit') ? 'active-profile-tab' : ''}}" href="{{ route('profile.account.password.edit') }}">Change Password</a>
    </li>
</ul>