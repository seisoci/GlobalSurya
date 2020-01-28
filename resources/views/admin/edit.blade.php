@extends('parts.appbase', ['title' => 'Edit Admin'])

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-md-6">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Edit Admin
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="kt-form" id="formStore" role="form" method="POST" action="{{route('admin.update')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <div class="kt-portlet__body">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email" value="{{$data->email}}">
                            <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{$data->name}}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('NIS/NIP') }}</label>
                            <input type="text" name="nis" class="form-control" placeholder="ex: 12345789" value="{{$data->nis}}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Role') }}</label>
                            <input type="text" class="form-control" value="Wali Kelas" disabled>
                            <input type="hidden" class="form-control" value="admin" name="role" disabled>
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
                        window.location.href = "{{url('admin')}}"
                    }, 3000);
				}
			},error: function(response){
                form.find("[type='submit']").removeClass("kt-spinner kt-spinner--sm kt-spinner--light").html(btnHtml);
                toastr.error("Please complete your form",'Failed !');
            }
		});
	});
});
</script>
@endsection
