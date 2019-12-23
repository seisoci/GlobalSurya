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
            <table class="table table-striped- table-bordered table-hover table-checkable" id="datatable">
                <thead>
                    <tr>
                        <th colspan="1">Nama Siswa: </th>
                        <th colspan="3">{{$data->name}}</th>
                        <th colspan="3">Kelas: {{$data->raport[0]->kelas->nama_kelas}}</th>
                        <th colspan="3">Tahun:{{$year}}</th>
                        <th colspan="3">Semester: Ganjil</th>
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
                        <td>{{$absen->ganjilsakit}}</td>
                    </tr>
                    <tr>
                        <td>Izin</td>
                        <td>{{$absen->ganjilizin}}</td>
                    </tr>
                    <tr>
                        <td>Alpha</td>
                        <td>{{$absen->ganjilalpha}}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="#" data-toggle="modal" data-target="#modalAbsensi" data-id="{{$absen->id_absen}}" data-ganjilsakit="{{$absen->ganjilsakit}}" data-ganjilizin="{{$absen->ganjilizin}}" data-ganjilalpha="{{$absen->ganjilalpha}}" title="Update" class="btn btn-sm btn-clean btn-icon-md"><i class="la la-trash"> Edit </i></a>
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
                            <input type="text" name="ganjilsakit" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Izin') }}</label>
                            <input type="text" name="ganjilizin" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Alpha') }}</label>
                            <input type="text" name="ganjilalpha" class="form-control" placeholder="Nilai">
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
                <input type="hidden" name="semester" value="ganjil">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD1') }}</label>
                            <input type="text" name="ganjilpengetahuankd1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD2') }}</label>
                            <input type="text" name="ganjilpengetahuankd2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD3') }}</label>
                            <input type="text" name="ganjilpengetahuankd3" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Pengetahuan KD4') }}</label>
                            <input type="text" name="ganjilpengetahuankd4" class="form-control" placeholder="Nilai">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD1') }}</label>
                            <input type="text" name="ganjilketerampilankd1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD2') }}</label>
                            <input type="text" name="ganjilketerampilankd2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD3') }}</label>
                            <input type="text" name="ganjilketerampilankd3" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Keterampilan KD4') }}</label>
                            <input type="text" name="ganjilketerampilankd4" class="form-control" placeholder="Nilai">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>{{ __('Sikap KD1') }}</label>
                            <input type="text" name="ganjilsikapkd1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sikap KD2') }}</label>
                            <input type="text" name="ganjilsikapkd2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sikap KD3') }}</label>
                            <input type="text" name="ganjilsikapkd3" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sikap KD4') }}</label>
                            <input type="text" name="ganjilsikapkd4" class="form-control" placeholder="Nilai">
                        </div>
                    </div>
                    <div class="col sm-3">
                        <div class="form-group">
                            <label>{{ __('PTS K') }}</label>
                            <input type="text" name="ganjilpts1" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('PTS P') }}</label>
                            <input type="text" name="ganjilpts2" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="form-group">
                            <label>{{ __('PTS A') }}</label>
                            <input type="text" name="ganjilpts3" class="form-control" placeholder="Nilai">
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
		var ganjilpengetahuankd1 = $(event.relatedTarget).data('ganjilpengetahuankd1');
		var ganjilpengetahuankd2 = $(event.relatedTarget).data('ganjilpengetahuankd2');
		var ganjilpengetahuankd3 = $(event.relatedTarget).data('ganjilpengetahuankd3');
		var ganjilpengetahuankd4 = $(event.relatedTarget).data('ganjilpengetahuankd4');
		var ganjilketerampilankd1 = $(event.relatedTarget).data('ganjilketerampilankd1');
		var ganjilketerampilankd2 = $(event.relatedTarget).data('ganjilketerampilankd2');
		var ganjilketerampilankd3 = $(event.relatedTarget).data('ganjilketerampilankd3');
		var ganjilketerampilankd4 = $(event.relatedTarget).data('ganjilketerampilankd4');
		var ganjilsikapkd1 = $(event.relatedTarget).data('ganjilsikapkd1');
		var ganjilsikapkd2 = $(event.relatedTarget).data('ganjilsikapkd2');
		var ganjilsikapkd3 = $(event.relatedTarget).data('ganjilsikapkd3');
		var ganjilsikapkd4 = $(event.relatedTarget).data('ganjilsikapkd4');
		var ganjilpts1 = $(event.relatedTarget).data('ganjilpts1');
		var ganjilpts2 = $(event.relatedTarget).data('ganjilpts2');
		var ganjilpts3 = $(event.relatedTarget).data('ganjilpts3');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd1"]').val(ganjilpengetahuankd1);
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd2"]').val(ganjilpengetahuankd2);
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd3"]').val(ganjilpengetahuankd3);
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd4"]').val(ganjilpengetahuankd4);
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd1"]').val(ganjilketerampilankd1);
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd2"]').val(ganjilketerampilankd2);
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd3"]').val(ganjilketerampilankd3);
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd4"]').val(ganjilketerampilankd4);
		$(this).find('.modal-body').find('input[name="ganjilsikapkd1"]').val(ganjilsikapkd1);
		$(this).find('.modal-body').find('input[name="ganjilsikapkd2"]').val(ganjilsikapkd2);
		$(this).find('.modal-body').find('input[name="ganjilsikapkd3"]').val(ganjilsikapkd3);
		$(this).find('.modal-body').find('input[name="ganjilsikapkd4"]').val(ganjilsikapkd4);
		$(this).find('.modal-body').find('input[name="ganjilpts1"]').val(ganjilpts1);
		$(this).find('.modal-body').find('input[name="ganjilpts2"]').val(ganjilpts2);
		$(this).find('.modal-body').find('input[name="ganjilpts3"]').val(ganjilpts3);
	});
	$('#modalUpdate').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="id"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd1"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd2"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd3"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpengetahuankd4"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd1"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd2"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd3"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilketerampilankd4"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilsikapkd1"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilsikapkd2"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilsikapkd3"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilsikapkd4"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpts1"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpts2"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilpts3"]').val('');
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
		var ganjilsakit = $(event.relatedTarget).data('ganjilsakit');
		var ganjilizin = $(event.relatedTarget).data('ganjilizin');
		var ganjilalpha = $(event.relatedTarget).data('ganjilalpha');
		$(this).find('.modal-body').find('input[name="id"]').val(id);
		$(this).find('.modal-body').find('input[name="ganjilsakit"]').val(ganjilsakit);
		$(this).find('.modal-body').find('input[name="ganjilizin"]').val(ganjilizin);
		$(this).find('.modal-body').find('input[name="ganjilalpha"]').val(ganjilalpha);
	});
	$('#modalAbsensi').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('input[name="id"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilsakit"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilizin"]').val('');
		$(this).find('.modal-body').find('input[name="ganjilalpha"]').val('');
	});

    var datatable = $('#datatable').DataTable({
        scrollX: !0,
        processing: true,
        serverSide: true,
        lengthMenu: [[-1], ["All"]],
        ajax: {
            url: '{{url('raport/datatabledetail/ganjil')}}',
            type: 'GET',
            data: function (d) {
                d.tahun = {{ Request::segment(3) }};
                d.id_users = {{ Request::segment(4) }};
            }
        },
        order: [0, 'asc'],
        columns: [
            { data: 'matapelajaran.mata_pelajaran', name: 'matapelajaran.mata_pelajaran' },
            { data: 'ganjilpengetahuankd1', name: 'ganjilpengetahuankd1' },
            { data: 'ganjilpengetahuankd2', name: 'ganjilpengetahuankd2' },
            { data: 'ganjilpengetahuankd3', name: 'ganjilpengetahuankd3' },
            { data: 'ganjilpengetahuankd4', name: 'ganjilpengetahuankd4' },
            { data: 'pengetahuanrata', name: 'pengetahuanrata' },
            { data: 'pengetahuanpredikat', name: 'pengetahuanpredikat' },
            { data: 'ganjilketerampilankd1', name: 'ganjilketerampilankd1' },
            { data: 'ganjilketerampilankd2', name: 'ganjilketerampilankd2' },
            { data: 'ganjilketerampilankd3', name: 'ganjilketerampilankd3' },
            { data: 'ganjilketerampilankd4', name: 'ganjilketerampilankd4'  },
            { data: 'keterampilanrata', name: 'keterampilanrata'  },
            { data: 'keterampilanpredikat', name: 'keterampilanpredikat'  },
            { data: 'ganjilsikapkd1', name: 'ganjilsikapkd1' },
            { data: 'ganjilsikapkd2', name: 'ganjilsikapkd2' },
            { data: 'ganjilsikapkd3', name: 'ganjilsikapkd3' },
            { data: 'ganjilsikapkd4', name: 'ganjilsikapkd4' },
            { data: 'sikaprata', name: 'sikaprata' },
            { data: 'sikappredikat', name: 'sikappredikat' },
            { data: 'ganjilpts1', name: 'ganjilpts1' },
            { data: 'ganjilpts2', name: 'ganjilpts2' },
            { data: 'ganjilpts3', name: 'ganjilpts3' },
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
