@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="container">
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
                    <!--                <div class="row">
                                        <div class="tab" id="ads_tab" role="tabpanel">
                                             Nav tabs 
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="active"><a href="#auto-renew" data-toggle="tab">Auto Renew</a></li>
                                                <li class=""><a href="#change-plan" data-toggle="tab">Change Plan</a></li>
                                                <li class=""><a href="#update-card" data-toggle="tab">Update Card</a></li>
                                            </ul>
                                             Tab panes 
                                            <div class="tab-content tabs">
                                                <div role="tabpanel" class="tab-pane active" id="auto-renew">
                                                    <h3>Section 1</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="change-plan">
                                                    <h3>Section 2</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="update-card">
                                                    <h3>Section 3</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                    <div class="row">
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
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script src="https://js.stripe.com/v2"></script>
<script src="{{ URL::asset('js/stripe.js') }}"></script>
@endpush
