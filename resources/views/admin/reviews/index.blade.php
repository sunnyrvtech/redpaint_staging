@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="col-md-4">
            </div>
            <!--            <div class="col-md-8">
                            <div class="text-right">
                                <a class="browse btn btn-primary" type="button"><i class="glyphicon glyphicon-import"></i>Import Category</a>
                                <input style="display: none;" id="file_type" name="csvFile" class="uploadCsv" type="file">
                            </div>
                        </div>-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="review-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Event Name</th>
                        <th>Submit By</th>
                        <th>Comment</th>
                        <th>Status</th>
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
        $('#review-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('reviews.index') }}?event_id={{ $event_id }}",
            order: [[ 6, "desc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'event_name', name: 'event_name'},
                {data: 'user_name', name: 'user_name'},
                {data: 'comment', name: 'comment'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'Action', orderable: false, searchable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return row.action;
                    }

                }
            ]
        });  
    });
</script>
@endpush
@endsection
