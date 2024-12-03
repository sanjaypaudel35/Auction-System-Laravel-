@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('frontend.pages.profile.account.partial.account-head-tabs')
            </div>
            <div class="col-md-12">
                <div class="profile-info-wrapper">
                    <div class="personal-info-wrapper">
                        <div><b>Name</b>: <span>{{ $profileInfo->name }}</span></div>
                        <div><b>Email</b>: <span>{{ $profileInfo->email }}</span></div>
                        <div><b>Address</b>: <span>{{ $profileInfo->address }}</span></div>
                        <div><b>Phone Number</b>: <span>{{ $profileInfo->phone_number }}</span></div>
                        <div><b>Registered At</b>: <span>{{ $profileInfo->formatted_created_at }}</span></div>
                        <div><b>Total Ads</b>: <span>{{ $profileInfo->totalProducts }}</span></div>
                        <div><b>Total Bids</b>: <span>{{ $profileInfo->totalBids }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="success-bid-wrapper shadow mt-4">
                                <div><i class="fa-solid fa-trophy" style="color:#cbcb07;font-size:60px"></i></div>
                                <div class="my-3"><b style="font-size: 22px">Bids Overview</b></div>
                                <div class="success-bid-number-box"><b style="font-size:30px;color:#65c9c9">{{ $profileInfo->totalSuccessBids }}</b></div>
                                <div class = "mt-3">
                                    <b>Total unpaid bids: </b>:<span>{{ $profileInfo->totalSuccessUnpaidBids }}</span><br>
                                    <b>Total paid bids: </b>:<span>{{ $profileInfo->totalSuccessPaidBids }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="success-bid-wrapper shadow mt-4">
                                <div><i class="fa-solid fa-sack-dollar" style="color:green;font-size:60px"></i></div>
                                <div class="my-3"><b style="font-size: 22px">Ads Overview</b></div>
                                <div class="success-bid-number-box"><b style="font-size:30px;color:#65c9c9">{{ $profileInfo->totalSuccessAds }}</b></div>
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <div class = "mt-3">
                                            <b>Total Unpaid Aids: </b>:<span>{{ $profileInfo->totalSuccessUnPaidAds }}</span><br>
                                            <b>Total Paid Aids: </b>:<span>{{ $profileInfo->totalSuccessPaidAds }}</span><br>
                                            <b>Total Failed Aids: </b>:<span>{{ $profileInfo->totalFailedAds }}</span>
                                        </div>
                                    </div>
                                    <div class = "col-md-6">
                                        <div class = "mt-3">
                                            <b>Total Pending Aids: </b>:<span>{{ $profileInfo->totalPendingAds }}</span><br>
                                            <b>Total Upcoming Aids: </b>:<span>{{ $profileInfo->totalUpcomingAds }}</span><br>
                                            <b>Total Live Aids: </b>:<span>{{ $profileInfo->totalLiveAds }}</span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-shadow-box>
</div>
@endsection
@section('js')
<script>
</script>
@endsection