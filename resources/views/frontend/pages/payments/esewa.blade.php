@extends('frontend.layouts.master')

@section('content')
<div class="container">
  <div class="row justify-content-center p-3">
    <div class="col-md-12">
      <x-shadow-box shadowClass="shadow">
        <h1> Redirecting to esewa page </h1>
      <form id="paymentForm" action="https://uat.esewa.com.np/epay/main" method="POST">
        <input value="{{$paymentData['tAmt']}}" name="tAmt" type="hidden">
        <input value="{{$paymentData['amt']}}" name="amt" type="hidden">
        <input value="{{$paymentData['txAmt']}}" name="txAmt" type="hidden">
        <input value="{{$paymentData['psc']}}" name="psc" type="hidden">
        <input value="{{$paymentData['pdc']}}" name="pdc" type="hidden">
        <input value="{{$paymentData['scd']}}" name="scd" type="hidden">
        <input value="{{$paymentData['pid']}}" name="pid" type="hidden">
        <input value="{{route('payment.esewa.success')}}?q=su" type="hidden" name="su">
        <input value="{{route('payment.esewa.failure')}}?q=fu" type="hidden" name="fu">
    </form>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('paymentForm').submit();
    });
</script>
      </x-shadow-box>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>

</script>
@endsection