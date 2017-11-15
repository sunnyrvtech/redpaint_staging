@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="row">
        <div class="col-sm-3">
            @include('accounts.sidebar')
        </div>

        <div class="col-sm-9">
            <div class="content-header">
                <div class="row">
                    <div class="col-md-8">
                        <div class="titled-nav-header_content">
                            <h3>Ads Plan Setting</h3>
                        </div>
                    </div>
                    <!--                            <div class="col-md-2 pull-right">
                                                    <button class="btn btn-primary" type="button">Create Event</button>
                                                </div>-->
                </div>
            </div>
            <div class="content-middle">
                @if (Auth::user()->subscribed('ads_subscription') || Auth::user()->get_active_plan)
                <div class="row">
                    <div class="tab" id="ads_tab" role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#auto-renew" data-toggle="tab">Auto Renew</a></li>
                            @if(!Auth::user()->subscription('ads_subscription')->cancelled())
                                <li class=""><a href="#change-plan" data-toggle="tab">Change Plan</a></li>
                            @endif
                            <li class=""><a href="#update-card" data-toggle="tab">Update Card</a></li>
                        </ul>
                        <div class="tab-content tabs">
                            <div role="tabpanel" class="tab-pane active" id="auto-renew">
                                <h3>Auto Renew Subscription</h3>
                                <div class="btn-group status-toggle">
                                    <button class="btn @if(Auth::user()->subscription('ads_subscription')->cancelled())btn-default confirmationStatus @else active btn-primary @endif" data-id="resume" data-href="{{ route('account-subscription-resume') }}" data-title="Resume subscription Plan" data-msg="Are you sure you want to resume your subscription plan !" data-method="post">ON</button>
                                    <button class="btn @if(Auth::user()->subscription('ads_subscription')->cancelled())active btn-primary @else btn-default confirmationStatus @endif" data-id="cancel" data-href="{{ route('account-subscription-cancel') }}" data-title="Cancel subscription Plan" data-msg="Are you sure you want to cancel your subscription plan !" data-method="post">OFF</button>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="change-plan">
                                <!--<h3>Change Your Plan</h3>-->
                                <div class="row">
                                    @include('ads.ads_plan',$packages)
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="update-card">
                                <h3>Update Card Information</h3>
                                <form id="subscription-form" action="{{ route('account-subscription-card') }}" method="post">
                                    {{ csrf_field()}}
                                    <div class="form-group">
                                        <label for="card_number" class="col-form-label">Card Number</label>
                                        <span class="help-block"></span>
                                        <input type="text" class="form-control" data-stripe="number" placeholder="Credit card number" name="card_number">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="exp_month" class="col-form-label">Exp Month</label>
                                            <span class="help-block"></span>
                                            <select  class="form-control" name="exp_month" data-stripe="exp-month">
                                                <option value="">Exp Month</option>
                                                @foreach($monthArray as $key=>$val)
                                                <option value="{{ $key }}">{{ $val }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exp_year" class="col-form-label">Exp Year</label>
                                            <span class="help-block"></span>
                                            <select  class="form-control" name="exp_year" data-stripe="exp-year">
                                                <option value="">Exp Year</option>
                                                <?php for ($yearArray['start']; $yearArray['start'] <= $yearArray['end']; $yearArray['start'] ++) { ?>
                                                    <option @if($yearArray['start'] == date('Y'))selected @endif value="{{ $yearArray['start'] }}">{{ $yearArray['start'] }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="cvv" class="col-form-label">Cvv</label>
                                            <span class="help-block"></span>
                                            <input type="text" class="form-control" placeholder="Cvv" data-stripe="cvc" name="cvv">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <div class="payment-errors"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="payment_form" ng-show="paymentForm">
                        <form id="subscription-form" action="{{ route('account-subscription-join') }}" method="post">
                            {{ csrf_field()}}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name" class="col-form-label">First Name</label>
                                    <span class="help-block"></span>
                                    <input type="text" class="form-control" readonly="" value="{{ Auth::user()->first_name }}" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name" class="col-form-label">Last Name</label>
                                    <span class="help-block"></span>
                                    <input type="text" class="form-control" readonly="" value="{{ Auth::user()->last_name }}" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-form-label">Email</label>
                                    <span class="help-block"></span>
                                    <input type="email" class="form-control" readonly="" value="{{ Auth::user()->email }}" placeholder="Email" name="email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="plan" class="col-form-label">Ads Plan</label>
                                    <span class="help-block"></span>
                                    <select name="plan" id="plan" class="form-control">
                                        <option value="">Select plan</option>
                                        @foreach($packages as $key=>$value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="card_number" class="col-form-label">Card Number</label>
                                <span class="help-block"></span>
                                <input type="text" class="form-control" data-stripe="number" value="4242424242424242" placeholder="Credit card number" name="card_number">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="exp_month" class="col-form-label">Exp Month</label>
                                    <span class="help-block"></span>
                                    <select  class="form-control" name="exp_month" data-stripe="exp-month">
                                        <option value="">Exp Month</option>
                                        @foreach($monthArray as $key=>$val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exp_year" class="col-form-label">Exp Year</label>
                                    <span class="help-block"></span>
                                    <select  class="form-control" name="exp_year" data-stripe="exp-year">
                                        <option value="">Exp Year</option>
                                        <?php for ($yearArray['start']; $yearArray['start'] <= $yearArray['end']; $yearArray['start'] ++) { ?>
                                            <option @if($yearArray['start'] == date('Y'))selected @endif value="{{ $yearArray['start'] }}">{{ $yearArray['start'] }}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cvv" class="col-form-label">Cvv</label>
                                    <span class="help-block"></span>
                                    <input type="text" class="form-control" placeholder="Cvv" data-stripe="cvc" name="cvv">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <div class="payment-errors"></div>
                        </form>

                    </div>
                </div>
                <div class="row">
                    @include('ads.ads_plan',$packages)
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://js.stripe.com/v2"></script>
<script type="text/javascript">
    var publish_key = "{{ env('STRIPE_KEY') }}";
</script>
<script src="{{ URL::asset('js/stripe.js') }}"></script>
@endpush
