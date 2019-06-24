<!-- using helper form to avoid any guzzle ssl issue -->

<html>
<body onload="document.order.submit()">
    <p>Sending Request to senangpay....</p>
    <form name="order" method="post" action="{{ $body['endpoint'] }}">
        <input type="hidden" name="detail" value="{{ $body['detail'] }}">
        <input type="hidden" name="amount" value="{{ $body['amount'] }}">
        <input type="hidden" name="order_id" value="{{ $body['order_id'] }}">
        <input type="hidden" name="name" value="{{ $body['name'] }}">
        <input type="hidden" name="phone" value="{{ $body['addr_1'] }}">
        <input type="hidden" name="addr_2" value="{{ $body['addr_2'] }}">
        <input type="hidden" name="addr_2" value="{{ $body['addr_3'] }}">
        <input type="hidden" name="state" value="{{ $body['state'] }}">
        <input type="hidden" name="city" value="{{ $body['city'] }}">
        <input type="hidden" name="postcode" value="{{ $body['postcode'] }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        <input type="hidden" name="phone" value="{{ $body['phone'] }}">
        <input type="hidden" name="hash" value="{{ $body['hash'] }}">
    </form>
</body>
</html>
