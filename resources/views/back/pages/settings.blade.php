@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?: 'settings')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'settings' }}
    </li>
@endsection

@section('content')

    @livewire('admin-settings')

@endsection
@push('scripts')


    {{--read image--}}
    <script>
        $(document).ready(function() {
            $('#site_logo').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#site_logo_image_preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(file);
                } else {
                    $('#site_logo_image_preview').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#site_favicon').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#site_favicon_image_preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(file);
                } else {
                    $('#site_favicon_image_preview').hide();
                }
            });
        });
    </script>

    <script type="text/javascript">
        $('#change_site_logo_form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            var formdata = new FormData(form);
            var inputFileVal = $(form).find('input[type="file"][name="site_logo"]').val();

            if( inputFileVal.length > 0 ){
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:formdata,
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                        toastr.remove();
                        $(form).find('span.error-text').text('');
                    },
                    success:function(response){
                        if(response.status === 1){
                            toastr.success(response.msg);
                            $(form)[0].reset();
                        }else{
                            console.log(response.data)
                            toastr.error(response.msg);
                        }
                    }
                });
            }else{
                $(form).find('span.error-text').text('Please, select logo image file. PNG file type is recommended.');
            }
        });
    </script>

    <script type="text/javascript">
        $('#change_site_favicon_form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            var formdata = new FormData(form);
            var inputFileVal = $(form).find('input[type="file"][name="site_favicon"]').val();

            if( inputFileVal.length > 0 ){
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:formdata,
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                        toastr.remove();
                        $(form).find('span.error-text').text('');
                    },
                    success:function(response){
                        if(response.status === 1){
                            toastr.success(response.msg);
                            $(form)[0].reset();
                        }else{
                            console.log(response.data)
                            toastr.error(response.msg);
                        }
                    }
                });
            }else{
                $(form).find('span.error-text').text('Please, select site favicon image file. PNG file type is recommended.');
            }
        });
    </script>
@endpush
