@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="col-md-4">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New</a>
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
            <table class="ui celled table" id="category-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Icon Class Name</th>
                        <th>Status</th>
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
        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories.index') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'class_name', name: 'class_name'},
                {data: 'status', name: 'status'},
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
