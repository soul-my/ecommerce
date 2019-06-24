
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>NM Ukhuwah Payment Gateway</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Payment Form Widget Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="{{ asset('payment/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Alegreya+Sans:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="{{ asset('payment/js/jquery.min.js') }}"></script>
</head>
<body>
	<div class="main">
		<h1>Ukhuwah Payment Gateway</h1>
		<div class="content">

			<script src="{{ asset('payment/js/easyResponsiveTabs.js') }}" type="text/javascript"></script>
					<script type="text/javascript">
						$(document).ready(function () {
							$('#horizontalTab').easyResponsiveTabs({
								type: 'default', //Types: default, vertical, accordion
								width: 'auto', //auto or any width like 600px
								fit: true   // 100% fit in a container
							});
						});
					</script>
					<form method="GET" action="{{ route('gateway.backend') }}">
						<input type="hidden" name="order_id" value="{{ $body['order_id'] }}">
						<input type="hidden" name="transaction_id" value="{{ $body['transaction_id'] }}">
						<input type="hidden" name="status_id" value="1">
						<input type="hidden" name="msg" value="Payment_was_successful">
						<div class="sap_tabs">
							<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
								<div class="pay-tabs">
									<h2>Select Payment Method</h2>
									  <ul class="resp-tabs-list">
										  <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span><label class="pic3"></label>FPX Banking</span></li>
										  <div class="clear"></div>
									  </ul>
								</div>
								<div class="resp-tabs-container">

									<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
										<div class="payment-info">
											<h3>FPX Banking</h3>
											<div class="radio-btns">
												<div class="swit">
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio" checked=""><i></i>Affin Bank</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Alliance Bank</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Ambank Baroda</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Bank Islam</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Bank Muamalat</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Bank Rakyat</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>BSN Bank</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Hong Leong Bank</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Maybank Bank</label> </div></div>
													<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>RHB Bank</label> </div></div>
												</div>
												<div class="clear"></div>
											</div>
											<button style="padding: 8px 10px;
											font-size: 14px;
											color: #fff;
											font-weight: 600;
											text-transform: uppercase;
											background: #B5E045; border: 0px;">Pay Now</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>

		</div>
	</div>
</body>
</html>