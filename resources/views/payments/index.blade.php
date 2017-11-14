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
                            <h3>Payment History</h3>
                        </div>
                    </div>
                    <!--                            <div class="col-md-2 pull-right">
                                                    <button class="btn btn-primary" type="button">Create Event</button>
                                                </div>-->
                </div>
            </div>
            <div class="content-middle">
                <div class="table-responsive">
                    <table class="table">
                        @forelse ($history as $key=>$details)
                        @if($key == 0)
                        <tr>
                            <th width="30%">Plan</th>
                            <th width="30%">Amount</th>
                            <th width="30%">Date</th>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ $details->subscription_plan }}</td>
                            <td>${{ $details->amount }}</td>
                            <td>{{ date('M,d Y H:ia',strtotime($details->subscription_start)) }}</td>
                        </tr>
                        @empty
                            <tr><th>No history found !</th></tr>
                        @endforelse
                    </table>
                    <div class="pagination_main_wrapper text-center">{{ $history->links() }}</div>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush
