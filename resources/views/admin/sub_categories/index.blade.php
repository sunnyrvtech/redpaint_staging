@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="{{ route('subcategories.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="subcategory-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Sub Category Name</th>
<!--                        <th>Category Image</th>-->
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
        $('#subcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ $ajaxURL }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'category_name', name: 'category_name', orderable: false},
                {data: 'name', name: 'name'},
//                {data: "category_image", render: function (data, type, row) {
//                        if (data != null) {
//                            return '<img width="100px" src="' + "<?= url('/category') ?>" + "/" + data + '" />';
//                        }
//                        return '';
//                    }
//                },
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action', orderable: false, searchable: false, render: function (data, type, row) {
                        return row.action;
                    }

                }
            ]
        });
    });
</script>
@endpush
@endsection
