@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?: 'Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'Profile' }}
    </li>
@endsection

@section('content')

<div class="row">
    {{--image --}}
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="javascript:;"
                   onclick="event.preventDefault();document.getElementById('adminProfilePictureFile').click();"
                   class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <?php /** @var \App\Models\Admin $admin */ ?>
                <img src="{{ $admin->getFirstMediaUrl('avatars') }}" alt="asd" class="avatar-photo" id="adminProfilePicture">
                <input type="file" name="adminProfilePictureFile" id="adminProfilePictureFile" class="d-none" style="opacity:0">
            </div>
            <h5 class="text-center h5 mb-0" id="adminProfileName">{{ $admin->first_name }}</h5>
            <p class="text-center text-muted font-14" id="adminProfileEmail">
                {{ $admin->email }}
            </p>
        </div>
    </div>
    {{--tabs --}}
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            @livewire('admin-profile-tabs')
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        /* live data change */
        window.addEventListener('updateAdminInfo', function(event){
            $('#adminProfileName').html(event.detail[0].adminName);
            $('#adminProfileEmail').html(event.detail[0].adminEmail);
        });

        /* crop and save image */
        $('input[type="file"][name="adminProfilePictureFile"][id="adminProfilePictureFile"]').ijaboCropTool({
          preview : '#adminProfilePicture',
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
