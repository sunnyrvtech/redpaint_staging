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
            <table class="ui celled table" id="event-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Event Name</th>
                        <th>Submit By</th>
                        <th>Comment</th>
                        <th>Average Rating</th>
                        <th>Status</th>
                        <th>View Review</th>
                        <th>View Event Images</th>
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
        $('#event-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('business.index') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'user_name', name: 'user_name'},
                {data: 'comment', name: 'comment'},
                {data: 'rate', name: 'rate'},
                {data: 'status', name: 'status',"width": "20%"},
                {data: 'view_review', name: 'view_review',"width": "2%"},
                {data: 'view_photo', name: 'view_photo',"width": "2%"},
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
