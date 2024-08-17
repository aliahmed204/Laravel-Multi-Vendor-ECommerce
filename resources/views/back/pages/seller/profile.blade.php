@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?: 'Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'Profile' }}
    </li>
@endsection

@section('content')
    @livewire('seller.seller-profile')
@endsection

@push('scripts')
    <script>
        /* live data change */
        window.addEventListener('updateAdminInfo', function(event){
            $('#sellerProfileName').html(event.detail[0].adminName);
            $('#sellerProfileEmail').html(event.detail[0].adminEmail);
        });

        /* crop and save image */
        $('input[type="file"][id="sellerProfilePictureFile"]').Kropify({
          preview : '#sellerProfilePicture',
            viewMode:1,
            aspectRatio:1,
            cancelButtonText:'Cancel',
            resetButtonText:'Reset',
            cropButtonText:'Crop & update',
            processURL:'{{ route("seller.change-profile-picture") }}',
            maxSize:2097152,
            showLoader:true,
            success:function(data){
                if( data.status == 1 ){
                    toastr.success(data.msg);
                     Livewire.dispatch('updateAdminSellerHeaderInfo');
                     Livewire.dispatch('updateSellerProfilePage');
                }else{
                    toastr.error(data.msg);
                }
            },
            errors:function(error, text){
                console.log(text);
            },
       });
    </script>
@endpush
