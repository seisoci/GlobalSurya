@extends('parts.appbase', ['title' => 'Admin'])

@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-crisp-icons"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ $config['title_datatable'] }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        &nbsp;
                        <a href="{{route('admin.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            New Record
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="datatable">
                <thead>
                    <tr>
                        <th></th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection
@section('extended')
<!--begin::Modal-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Delete ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="formDelete" role="form" method="POST" action="{{ route('admin.delete') }}">
            <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id">
                <p>Are you sure you want to delete this data ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--end::Modal-->
@endsection
@section('script')
    <script src="{{('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
$(function() {
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        ajax: 'admin/datatable',
        order: [[2, 'asc']],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nis', name: 'nis' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        headerCallback: function(thead, data, start, end, display) {
            thead.getElementsByTagName('th')[0].innerHTML = `
                <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                    <input type="checkbox" value="" class="kt-group-checkable">
                    <span></span>
                </label>`;
        },
        columnDefs: [
        {
            targets: 0,
            width: '30px',
            className: 'dt-right',
            orderable: false,
            render: function(data, type, full, meta) {
                return `
                <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                    <input type="checkbox" value="" class="kt-checkable">
                    <span></span>
                </label>`;
            },
        },
        {
            "targets": 4    , // your case first column
            "className": "text-center",
            "width": "110px"
        }
        ],
    });
    datatable.on('change', '.kt-group-checkable', function() {
			var set = $(this).closest('table').find('td:first-child .kt-checkable');
			var checked = $(this).is(':checked');

			$(set).each(function() {
				if (checked) {
					$(this).prop('checked', true);
					$(this).closest('tr').addClass('active');
				}
				else {
					$(this).prop('checked', false);
					$(this).closest('tr').removeClass('active');
				}
			});
		});

    datatable.on('change', 'tbody tr .kt-checkbox', function() {
        $(this).parents('tr').toggleClass('active');
    });

    $('#modalDelete').on('show.bs.modal', function (event) {
		var id = $(event.relatedTarget).data('id');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
	});
	$('#modalDelete').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="nama_kelas"]').val('');
	});

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };


    $("#formDelete").submit(function(e){
		e.preventDefault();
		var form 	= $(this);
		var btnHtml = form.find("[type='submit']").html();
		var url 	= form.attr("action");
		var data 	= new FormData(this);
		$.ajax({
            beforeSend:function() {
				form.find("[type='submit']").addClass("kt-spinner kt-spinner--sm kt-spinner--light").text("Processing...");
			},
			cache: false,
			processData: false,
			contentType: false,
			type: "POST",
			url : url,
			data : data,
			success: function(response) {
                form.find("[type='submit']").removeClass("kt-spinner kt-spinner--sm kt-spinner--light").html(btnHtml);
				if ( response.status == "success" ){
					toastr.success(response.message,'Success !');
					$('#modalDelete').modal('hide');
					datatable.draw();
                }
			},error: function(response){
                toastr.error("Please complete your form",'Failed !');
            }
		});
	});
});
</script>
@endsection
