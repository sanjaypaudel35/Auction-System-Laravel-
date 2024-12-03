<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
</head>
<body>
    @if ($forProductOwner)
        <h1>Your Product Has Been Sold.</h1>
        <p>The product {{ $mailData["product_name"] }} that you have placed for auction is won by <b style = "color:red">Mr/Mrs {{ $mailData["winner_name"]}}({{ $mailData["winner_email"]}})</b>
        on the bidding price of {{ $mailData["bid_amount"]}}.</p>
    @else
    <h1>Congratulation You Have Been Granted A Product.</h1>
        <p>You have won The product ({{ $mailData["product_name"] }}) that has been placed by {{ $mailData["owner_name"] }}
        at the bidding price of {{ $mailData["bid_amount"]}}.</p>
        <div>
            <span>Kindly requested to pay for the product<span>
            <a href = "{{$mailData["product_url"]}}">Click Here</a>
        <div>
    @endif

    <p>Thank you</p>
    <b>{{ env("APP_NAME") }}</b>
</body>
</html>