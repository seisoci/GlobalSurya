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
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped table-bordered table-hover table-checkable" id="datatable">
                <thead>
                    <tr>
                        <th colspan="1">Nama Siswa: </th>
                        <th colspan="3">{{$data->name}}</th>
                        <th colspan="3">Kelas: {{$data->raport[0]->kelas->nama_kelas}}</th>
                        <th colspan="3">Tahun:{{$year}}</th>
                        <th colspan="3">Semester: Genap</th>
                        <th colspan="11"></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="4" class="text-center">Pengetahuan</th>
                        <th rowspan="2" class="text-center">Rata-rata</th>
                        <th rowspan="2" class="text-center">Predikat</th>
                        <th colspan="4" class="text-center">Keterampilan</th>
                        <th rowspan="2" class="text-center">Rata-rata</th>
                        <th rowspan="2" class="text-center">Predikat</th>
                        <th colspan="4" class="text-center">Sikap</th>
                        <th rowspan="2" class="text-center">Rata-rata</th>
                        <th rowspan="2" class="text-center">Predikat</th>
                        <th colspan="3" class="text-center">PTS</th>
                        <th rowspan="2" class="text-center">Predikat</th>
                        <th class="text-center"></th>
                    </tr>
                    <tr>
                        <th class="text-center">Mata Pelajaran</th>
                        <th class="text-center">KD1</th>
                        <th class="text-center">KD2</th>
                        <th class="text-center">KD3</th>
                        <th class="text-center">KD4</th>
                        <th class="text-center">KD1</th>
                        <th class="text-center">KD2</th>
                        <th class="text-center">KD3</th>
                        <th class="text-center">KD4</th>
                        <th class="text-center">KD1</th>
                        <th class="text-center">KD2</th>
                        <th class="text-center">KD3</th>
                        <th class="text-center">KD4</th>
                        <th class="text-center">K</th>
                        <th class="text-center">P</th>
                        <th class="text-center">A</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
            </table>
            <table style="width:100px; margin-top: 20px" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Absensi</th>
                        <th>Hari</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sakit</td>
                        <td>{{$absen->genapsakit}}</td>
                    </tr>
                    <tr>
                        <td>Izin</td>
                        <td>{{$absen->genapizin}}</td>
                    </tr>
                    <tr>
                        <td>Alpha</td>
                        <td>{{$absen->genapalpha}}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="#" data-toggle="modal" data-target="#modalAbsensi" data-id="{{$absen->id_absen}}" data-genapsakit="{{$absen->genapsakit}}" data-genapizin="{{$absen->genapizin}}" data-genapalpha="{{$absen->genapalpha}}" title="Update" class="btn btn-sm btn-clean btn-icon-md"><i class="la la-trash"> Edit </i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection
@section('extended')
<div class="modal fade" id="modalAbsensi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="formAbsensi" role="form" method="POST" action="{{ route('raport.absensi') }}">
            <div class="modal-body">
                {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="semester" value="{{ Request::segment(5) }}">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Sakit') }}</label>
                            <input type="text" name="genapsakit" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Izin') }}</label>
                            <input type="text" name="genapizin" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Alpha') }}</label>
                            <input type="text" name="genapalpha" class="form-control" placeholder="Nilai">
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
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Nilai Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="formUpdate" role="form" method="POST" action="{{ route('raport.update') }}">
            <div class="modal-body">
                    {{ csrf_field() }}
                <input type="hidden" name="id">
                <input type="hidden" name="semester" value="genap">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD1') }}</label>
                            <input type="text" name="genappengetahuankd1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD2') }}</label>
                            <input type="text" name="genappengetahuankd2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD3') }}</label>
                            <input type="text" name="genappengetahuankd3" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD4') }}</label>
                            <input type="text" name="genappengetahuankd4" class="form-control" placeholder="Nilai">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD1') }}</label>
                            <input type="text" name="genapketerampilankd1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD2') }}</label>
                            <input type="text" name="genapketerampilankd2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD3') }}</label>
                            <input type="text" name="genapketerampilankd3" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD4') }}</label>
                            <input type="text" name="genapketerampilankd4" class="form-control" placeholder="Nilai">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Sikap KD1') }}</label>
                            <input type="text" name="genapsikapkd1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sikap KD2') }}</label>
                            <input type="text" name="genapsikapkd2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sikap KD3') }}</label>
                            <input type="text" name="genapsikapkd3" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sikap KD4') }}</label>
                            <input type="text" name="genapsikapkd4" class="form-control" placeholder="Nilai">
                        </div>
                    </div>
                    <div class="col sm-3">
                        <div class="form-group">
                            <label>{{ __('PTS K') }}</label>
                            <input type="text" name="genappts1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('PTS P') }}</label>
                            <input type="text" name="genappts2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('PTS A') }}</label>
                            <input type="text" name="genappts3" class="form-control" placeholder="Nilai">
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
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Delete ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="formDelete" role="form" method="POST" action="{{ route('raport.delete') }}">
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
@endsection
@section('script')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
$(function() {
    $('#modalUpdate').on('show.bs.modal', function (event) {
		var id  = $(event.relatedTarget).data('id');
		var genappengetahuankd1 = $(event.relatedTarget).data('genappengetahuankd1');
		var genappengetahuankd2 = $(event.relatedTarget).data('genappengetahuankd2');
		var genappengetahuankd3 = $(event.relatedTarget).data('genappengetahuankd3');
		var genappengetahuankd4 = $(event.relatedTarget).data('genappengetahuankd4');
		var genapketerampilankd1 = $(event.relatedTarget).data('genapketerampilankd1');
		var genapketerampilankd2 = $(event.relatedTarget).data('genapketerampilankd2');
		var genapketerampilankd3 = $(event.relatedTarget).data('genapketerampilankd3');
		var genapketerampilankd4 = $(event.relatedTarget).data('genapketerampilankd4');
		var genapsikapkd1 = $(event.relatedTarget).data('genapsikapkd1');
		var genapsikapkd2 = $(event.relatedTarget).data('genapsikapkd2');
		var genapsikapkd3 = $(event.relatedTarget).data('genapsikapkd3');
		var genapsikapkd4 = $(event.relatedTarget).data('genapsikapkd4');
		var genappts1 = $(event.relatedTarget).data('genappts1');
		var genappts2 = $(event.relatedTarget).data('genappts2');
		var genappts3 = $(event.relatedTarget).data('genappts3');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
		$(this).find('.modal-body').find('input[name="genappengetahuankd1"]').val(genappengetahuankd1);
		$(this).find('.modal-body').find('input[name="genappengetahuankd2"]').val(genappengetahuankd2);
		$(this).find('.modal-body').find('input[name="genappengetahuankd3"]').val(genappengetahuankd3);
		$(this).find('.modal-body').find('input[name="genappengetahuankd4"]').val(genappengetahuankd4);
		$(this).find('.modal-body').find('input[name="genapketerampilankd1"]').val(genapketerampilankd1);
		$(this).find('.modal-body').find('input[name="genapketerampilankd2"]').val(genapketerampilankd2);
		$(this).find('.modal-body').find('input[name="genapketerampilankd3"]').val(genapketerampilankd3);
		$(this).find('.modal-body').find('input[name="genapketerampilankd4"]').val(genapketerampilankd4);
		$(this).find('.modal-body').find('input[name="genapsikapkd1"]').val(genapsikapkd1);
		$(this).find('.modal-body').find('input[name="genapsikapkd2"]').val(genapsikapkd2);
		$(this).find('.modal-body').find('input[name="genapsikapkd3"]').val(genapsikapkd3);
		$(this).find('.modal-body').find('input[name="genapsikapkd4"]').val(genapsikapkd4);
		$(this).find('.modal-body').find('input[name="genappts1"]').val(genappts1);
		$(this).find('.modal-body').find('input[name="genappts2"]').val(genappts2);
		$(this).find('.modal-body').find('input[name="genappts3"]').val(genappts3);
	});
	$('#modalUpdate').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="id"]').val('');
		$(this).find('.modal-body').find('input[name="genappengetahuankd1"]').val('');
		$(this).find('.modal-body').find('input[name="genappengetahuankd2"]').val('');
		$(this).find('.modal-body').find('input[name="genappengetahuankd3"]').val('');
		$(this).find('.modal-body').find('input[name="genappengetahuankd4"]').val('');
		$(this).find('.modal-body').find('input[name="genapketerampilankd1"]').val('');
		$(this).find('.modal-body').find('input[name="genapketerampilankd2"]').val('');
		$(this).find('.modal-body').find('input[name="genapketerampilankd3"]').val('');
		$(this).find('.modal-body').find('input[name="genapketerampilankd4"]').val('');
		$(this).find('.modal-body').find('input[name="genapsikapkd1"]').val('');
		$(this).find('.modal-body').find('input[name="genapsikapkd2"]').val('');
		$(this).find('.modal-body').find('input[name="genapsikapkd3"]').val('');
		$(this).find('.modal-body').find('input[name="genapsikapkd4"]').val('');
		$(this).find('.modal-body').find('input[name="genappts1"]').val('');
		$(this).find('.modal-body').find('input[name="genappts2"]').val('');
		$(this).find('.modal-body').find('input[name="genappts3"]').val('');
    });

    $('#modalDelete').on('show.bs.modal', function (event) {
		var id = $(event.relatedTarget).data('id');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
	});
	$('#modalDelete').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="id"]').val('');
	});

    $('#modalAbsensi').on('show.bs.modal', function (event) {
		var id = $(event.relatedTarget).data('id');
		var genapsakit = $(event.relatedTarget).data('genapsakit');
		var genapizin = $(event.relatedTarget).data('genapizin');
		var genapalpha = $(event.relatedTarget).data('genapalpha');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
		$(this).find('.modal-body').find('input[name="genapsakit"]').val(genapsakit);
		$(this).find('.modal-body').find('input[name="genapizin"]').val(genapizin);
		$(this).find('.modal-body').find('input[name="genapalpha"]').val(genapalpha);
	});
	$('#modalAbsensi').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="id"]').val('');
		$(this).find('.modal-body').find('input[name="genapsakit"]').val('');
		$(this).find('.modal-body').find('input[name="genapizin"]').val('');
		$(this).find('.modal-body').find('input[name="genapalpha"]').val('');
	});


    var datatable = $('#datatable').DataTable({
        scrollX: !0,
        processing: true,
        serverSide: true,
        lengthMenu: [[-1], ["All"]],
        ajax: {
            url: '{{url('raport/datatabledetail/genap')}}',
            type: 'GET',
            data: function (d) {
                d.tahun = {{ Request::segment(3) }};
                d.id_users = {{ Request::segment(4) }};
            }
        },
        order: [0, 'asc'],
        columns: [
            { data: 'matapelajaran.mata_pelajaran', name: 'matapelajaran.mata_pelajaran' },
            { data: 'genappengetahuankd1', name: 'genappengetahuankd1' },
            { data: 'genappengetahuankd2', name: 'genappengetahuankd2' },
            { data: 'genappengetahuankd3', name: 'genappengetahuankd3' },
            { data: 'genappengetahuankd4', name: 'genappengetahuankd4' },
            { data: 'pengetahuanrata', name: 'pengetahuanrata' },
            { data: 'pengetahuanpredikat', name: 'pengetahuanpredikat' },
            { data: 'genapketerampilankd1', name: 'genapketerampilankd1' },
            { data: 'genapketerampilankd2', name: 'genapketerampilankd2' },
            { data: 'genapketerampilankd3', name: 'genapketerampilankd3' },
            { data: 'genapketerampilankd4', name: 'genapketerampilankd4'  },
            { data: 'keterampilanrata', name: 'keterampilanrata'  },
            { data: 'keterampilanpredikat', name: 'keterampilanpredikat'  },
            { data: 'genapsikapkd1', name: 'genapsikapkd1' },
            { data: 'genapsikapkd2', name: 'genapsikapkd2' },
            { data: 'genapsikapkd3', name: 'genapsikapkd3' },
            { data: 'genapsikapkd4', name: 'genapsikapkd4' },
            { data: 'sikaprata', name: 'sikaprata' },
            { data: 'sikappredikat', name: 'sikappredikat' },
            { data: 'genappts1', name: 'genappts1' },
            { data: 'genappts2', name: 'genappts2' },
            { data: 'genappts3', name: 'genappts3' },
            { data: 'ptspredikat', name: 'ptspredikat' },
            { data: 'action', name: 'action' },
        ],
        columnDefs: [
        {
            "targets": 0, // your case first column
            "className": "text-center",
            "width": "400px"
        },
        {
            "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23], // your case first column
            "className": "text-center",
        },
        ],
    });

    $("#formUpdate").submit(function(e){
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
                    $('#modalUpdate').modal('hide');
                    datatable.draw();
				}
			},error: function(response){
                form.find("[type='submit']").removeClass("kt-spinner kt-spinner--sm kt-spinner--light").html(btnHtml);
                toastr.error("Please complete your form",'Failed !');
            }
		});
    });

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
                form.find("[type='submit']").removeClass("kt-spinner kt-spinner--sm kt-spinner--light").html(btnHtml);
                toastr.error("Please complete your form",'Failed !');
            }
		});
	});

    $("#formAbsensi").submit(function(e){
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
                        location.reload();
                    }, 3000);
					datatable.draw();
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
