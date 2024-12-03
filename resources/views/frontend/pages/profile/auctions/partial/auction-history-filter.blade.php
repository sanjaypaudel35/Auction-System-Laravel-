@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
@endphp

<select class="form-select mb-3" id="auction-selector">
  <option value="#paid_auction">Paid Auction</option>
  <option value="#unpaid_auction">Unpaid Auction</option>
  <option value="#unsuccess_auction">Unsuccess Auction (No bids)</option>
</select>
