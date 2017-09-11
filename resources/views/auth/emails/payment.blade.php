<!-- email template -->
Dear customer {{ $pay_name }},<br><br>

{{ $payment_message }} <br />
-------------------------------<br>
<!--PaymentID: 				{{ $stripe_id }} <br />-->
Subscription Plan:   	                {{ $subscription_plan }} <br />
Amount:    				$ {{ $amount }} <br />
Subscription Starting Date:	        {{ $subscription_start }} <br />
Subscription Expiry Date:  	        {{ $subscription_end }} <br />

------------------------------- <br />
you have charged $ {{ $amount_due }} amount for {{ $subscription_plan }} plan.