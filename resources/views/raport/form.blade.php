@extends('parts.appbase', ['title' => 'Create Raport'])

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-md-6">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{$config['title_datatable']}}
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="kt-form" id="formStore" role="form" method="POST" action="{{ route('raport.store') }}">
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label>{{ __('Guru') }}</label>
                            @if (auth::user()->role === 'guru')
                                <input type="text" class="form-control" value="{{auth::user()->name}}">
                                <input type="hidden" class="form-control" name="id_guru" value="{{auth::user()->id}}"">
                            @else
                                <select class="form-control" name="id_guru">
                                    @foreach ($guru as $data)
                                         <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                 </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{ __('User') }}</label>
                            <select class="form-control" name="id_users">
                                @foreach ($siswa as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Mata Pelajaran') }}</label>
                            <select class="form-control" name="id_matapelajaran">
                               @foreach ($matapelajaran as $data)
                                    <option value="{{$data->id_matapelajaran}}">{{$data->mata_pelajaran}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Kelas') }}</label>
                            <select class="form-control" name="id_kelas">
                                @foreach ($kelas as $data)
                                    <option value="{{$data->id_kelas}}">{{$data->nama_kelas}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Tahun') }}</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="tahun" placeholder="Year Picker" id="datepicker">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions kt-align-right">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

                <!--end::Form-->
            </div>
            <!--end::Portlet-->
    </div>
</div>
@endsection
@section('extended')

@endsection
@section('script')
<script>
$(function() {
    $("#formStore").submit(function(e){
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
                        window.location.href = "{{url('raport')}}"
                    }, 3000);
				}
			},error: function(response){
                form.find("[type='submit']").removeClass("kt-spinner kt-spinner--sm kt-spinner--light").html(btnHtml);
                toastr.error("Please complete your form",'Failed !');
            }
		});
    });
    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    $('#datepicker').datepicker({
        rtl: KTUtil.isRTL(),
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        orientation: "top left",
        todayHighlight: true,
        templates: arrows
    });


});
</script>
@endsection
