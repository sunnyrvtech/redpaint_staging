@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="col-md-4">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="payment-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Subscription start</th>
                        <th>Subscription end</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        $('#payment-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.payment') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user_name', name: 'user_name'},
                {data: 'email', name: 'email'},
                {data: 'subscription_plan', name: 'subscription_plan'},
                {data: 'amount', name: 'amount'},
                {data: 'subscription_start', name: 'subscription_start'},
                {data: 'subscription_end', name: 'subscription_end'}
            ]
        });
    });
</script>
@endpush
@endsection
