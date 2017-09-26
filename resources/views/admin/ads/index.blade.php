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
            <table class="ui celled table" id="ads-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>User name</th>
                        <th>Banner</th>
                        <th>Link</th>
                        <th>Created At</th>
                        <th>Updated At</th>
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
        $('#ads-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('ads_list.index') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'user_name', name: 'user_name'},
                {data: 'banner', name: 'banner'},
                {data: 'link', name: 'link'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
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
