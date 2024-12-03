<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
</head>
<body>
    <h1>Payment Receipt.</h1>
    <p>Hello! <b style = "color:green">Mr/Mrs {{ $mailData["user_name"]}}({{ $mailData["user_email"]}})</b></p>
    <p>Here is the payment receipt of your payment for the product {{ $mailData["product_name"] }} of id {{$mailData["product_id"]}}</p>

    <div>
    <table border="1" style = "background-color: whitesmoke">
        <tr>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Bidding Date</th>
            <th>Payment Status</th>
        </tr>
        <tr>
            <td>{{ $mailData["product_name"] }}</td>
            <td>{{ $mailData["bid_amount"] }}</td>
            <td>{{ $mailData["date"] }}</td>
            <td>"Successful"</td>
        </tr>
    </table>
    </div>
    <p>Thank you</p>
    <b>{{ env("APP_NAME") }}</b>
</body>
</html>