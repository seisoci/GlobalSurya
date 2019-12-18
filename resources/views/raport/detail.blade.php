@extends('parts.appbase', ['title' => 'Detail Raport'])

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
                        <a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-brand btn-elevate btn-icon-sm">
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
                        <th colspan="10">2019</th>
                    </tr>
                    <tr>
                        <th colspan="1">Nama Siswa: </th>
                        <th colspan="3">Dummy</th>
                        <th colspan="3">Kelas: </th>
                        <th colspan="4">1B</th>
                    </tr>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Tugas 1</th>
                        <th>Tugas 2</th>
                        <th>Tugas 3</th>
                        <th>UTS</th>
                        <th>Tugas 5</th>
                        <th>Tugas 6</th>
                        <th>Tugas 7</th>
                        <th>UAS</th>
                        <th>Total</th>
                        <th>Actions</th>
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
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Nilai Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="formEdit" role="form" method="POST" action="{{ route('users.delete') }}">
                <div class="modal-body">
                        {{ csrf_field() }}
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('Tugas 1') }}</label>
                                <input type="text" name="username" class="form-control" placeholder="Your Username">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Tugas 2') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Tugas 3') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('UTS') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{ __('Tugas 4') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Tugas 5') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Tugas 6') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('UAS') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
$(function() {
    $('#modalUpdate').on('show.bs.modal', function (event) {
		var id  = $(event.relatedTarget).data('id');
		var uts = $(event.relatedTarget).data('uts');
		var uas = $(event.relatedTarget).data('uas');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
		$(this).find('.modal-body').find('input[name="uts"]').val(uts);
		$(this).find('.modal-body').find('input[name="uas"]').val(uas);
	});
	$('#modalUpdate').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="id"]').val('');
		$(this).find('.modal-body').find('input[name="uts"]').val('');
		$(this).find('.modal-body').find('input[name="uas"]').val('');
	});

    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [[-1], ["All"]],
        ajax: {
            url: '{{url('raport/datatabledetail')}}',
            type: 'GET',
            data: function (d) {
                d.tahun = {{ Request::segment(3) }};
                d.id_users = {{ Request::segment(4) }};
            }
        },
        order: [0, 'asc'],
        columns: [
            { data: 'matapelajaran.mata_pelajaran', name: 'matapelajaran.mata_pelajaran' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
            { data: 'action', name: 'action' },
        ],
        columnDefs: [
        {
            "targets": 0, // your case first column
            "className": "text-center",
            "width": "400px"
        },
        {
            "targets": 10, // your case first column
            "className": "text-center",
        },
        ],
    });

    $("#formEdit").submit(function(e){
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
                    setTimeout(function() {
                        window.location.href = "{{url('users')}}"
                    }, 3000);
				}
			},error: function(response){
                form.find("[type='submit']").removeClass("kt-spinner kt-spinner--sm kt-spinner--light").html(btnHtml);
                toastr.error("Please complete your form",'Failed !');
            }
		});
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

});
</script>
@endsection
