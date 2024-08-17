@extends('back.layout.pages-master')
@section('pageTitle', isset($pageTitle) ?: 'Shop page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'Shop Settings' }}
    </li>
@endsection
@section('content')


<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <x-alert.form-alert/>
    <form action="{{ route('seller.shop.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><b>Shop name:</b></label>
                <input type="text" class="form-control" name="name" placeholder="Enter your shop name here..." value="{{ old('name') ?: $shop->name }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""><b>Shop phone:</b></label>
                <input type="text" class="form-control" name="phone" placeholder="eg: +1 234 567 890" value="{{ old('phone') ?: $shop->phone }}">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for=""><b>Shop address:</b></label>
                <input type="text" class="form-control" name="address" placeholder="eg: 8977 HUXS Street 56" value="{{ old('address') ?: $shop->address }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label for=""><b>Shop description:</b></label>
                <textarea class="form-control" name="description" cols="30" rows="10" placeholder="Describe your shop...">{{ old('description') ?: $shop->description }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for=""><b>Shop logo:</b></label>
                <input type="file" name="logo" id="logo" class="form-control">
                <div class="mb-2 mt-1" style="max-width: 200px">
                    <img src="{{ $shop->getFirstMediaUrl('logos') }}" alt="" class="img-thumbnail" id="shop_logo_preview">
                </div>
                @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#logo').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#shop_logo_preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(file);
                } else {
                    $('#shop_logo_preview').hide();
                }
            });
        });
    </script>
@endpush
