@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="claim-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Event Name</th>
                        <th>Request By</th>
                        <th>Email</th>
                        <th>Account Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        $('#claim-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('claim.business') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'no', name: 'no'},
                {data: 'event_name', name: 'event_name'},
                {data: 'request_by', name: 'request_by'},
                {data: 'email', name: 'email'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'}
            ]
        });
    });
</script>
@endpush
@endsection
