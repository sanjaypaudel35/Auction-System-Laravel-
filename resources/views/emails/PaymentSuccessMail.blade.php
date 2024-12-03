<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
</head>
<body>
    <h1>Payment Successful.</h1>
    <p>The product {{ $mailData["product_name"] }} that you have placed for auction is won by <b style = "color:red">Mr/Mrs {{ $mailData["user_name"]}}({{ $mailData["user_email"]}})</b>
    on the bidding price of {{ $mailData["bid_amount"]}}.</p>
    <p>And it is notifying that he/she has transffered the fund successfully.</p>

    <p>Thank you</p>
    <b>{{ env("APP_NAME") }}</b>
</body>
</html>