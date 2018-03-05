@extends('admin/layouts.app')

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.5/css/select.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="card">
    <div class="card-header">Blogs <a href="#" class="btn btn-primary float-right btn-sm">Add</a></div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                     <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Created By</th>
                        <th>Created On</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<!-- Required: Datatable -->
<script src="https:////cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- Utilities for Datatable -->
<script src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('blogsAjaxData') !!}',
        columns: [
            { data: 'id', name: 'blogs.id' },
            { data: 'title', name: 'blogs.title' },
            { data: 'users.name', name: 'users.name' },
            { data: 'created_at', name: 'blogs.created_at' },
            { data: 'actions', name: 'actions' }
        ],
        "order": [[ 3, "desc" ]],
        "columnDefs": [
            { orderable: false, targets: 4 }
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                input.className = 'form-control form-control-sm';
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? val : '', true, false).draw();
                });
            });
        },
        "pagingType": "full_numbers",
        "deferRender": true,
        buttons: [
            {
                extend: 'copy',
                text: 'Copy All',
                className: 'btn btn-sm btn-secondary'
            },
            {
                extend: 'collection',
                text: 'Export Data',
                className: 'btn btn-sm btn-secondary',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'CSV all',
                    },
                    {
                        extend: 'excel',
                        text: 'Excel all',
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF all',
                    },
                ]
            },
            {
                extend: 'print',
                text: 'Print all',
                className: 'btn btn-sm btn-secondary'
            },
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
                className: 'btn btn-sm btn-secondary'
            },
        ],
        dom: 'lBfrtip',
    });
    $('.dt-buttons button, .dt-button-collection button').removeClass('dt-button');
});
</script>
@endsection