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
        $('input[type="file"][name="sellerProfilePictureFile"][id="sellerProfilePictureFile"]').ijaboCropTool({
          preview : '#sellerProfilePicture',
          setRatio:1,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CROP', 'QUIT'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:'{{ route("admin.change-profile-picture") }}',
          withCSRF:['_token','{{ csrf_token() }}'],
          onSuccess:function(message, element, status){
              Livewire.dispatch('updateAdminSellerHeaderInfo');
              alert(message)
             //toastr.success(message);
          },
          onError:function(message, element, status){
              alert(message)
            //toastr.error(message);
          }
       });
    </script>
@endpush
