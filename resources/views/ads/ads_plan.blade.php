<div class="pricing-plans" ng-show="planForm" ng-init="planForm = true">
    <div class="pricing-grids">
        @foreach($packages as $value)
        <div class="pricing-grid">
            <div class="price-value">
                <h3><a href="#">{{ $value->name}}</a></h3>
                <h5><span>$ {{ $value->price}}</span><lable> / {{ ucfirst($value->duration) }}</lable></h5>
            </div>
            <div class="price-bg">
<!--                <ul>
                    <li class="whyt"><a href="#">5GB Disk Space </a></li>
                    <li><a href="#">10 Domain Names</a></li>
                    <li class="whyt"><a href="#">5 E-Mail Address </a></li>
                    <li><a href="#">50GB Monthly Bandwidth </a></li>
                    <li class="whyt"><a href="#">Fully Support</a></li>
                </ul>-->
                <div class="cart">
                    @if(!Auth::user()->get_active_plan)
                    <a ng-click="choosePlan('{{ $value->id}}')" href="javascript:void(0);">Purchase</a>
                    @elseif(Auth::user()->get_active_plan->stripe_plan != $value->name)
                    <a href="javascript:void(0);" class="confirmationStatus" data-id="{{ $value->id }}" data-href="{{ route('subscription-change') }}" data-title="Change Subscription Plan" data-msg="Are you sure you want to change your subscription plan !" data-method="post">Change</a>
                    @else
                       <a href="javascript:void(0);">Activated</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>