@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?? 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'Categories' }}
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-dark">Add Category</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">
                            <i class="ion-arrow-left-a"></i> Back to categories list
                        </a>
                    </div>
                </div>
                <hr>
                <form action="{{ route('admin.categories.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    @method('PUT')
                    <x-session.flash name="fail" type="danger" />
                    <x-session.htmlFlash name="success" type="success" />

                    <div class="row">
                        {{--Category name--}}
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="">Category name</label>
                                <input type="text" class="form-control"
                                       name="name" placeholder="Enter category name"
                                       value="{{ $category->name}}">
                                @error('name')
                                <span class="text-danger ml-2">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{--Category name--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Category slug</label>
                                <input type="text" class="form-control"
                                       placeholder="Enter category name"
                                       value="{{ $category->slug}}" disabled readonly>
                            </div>
                        </div>
                        {{--ordering--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Category ordering</label>
                                <input type="number" class="form-control"
                                       name="ordering" aria-valuemin="1" placeholder="Enter category ordering"
                                       value="{{ $category->ordering  }}">
                                @error('ordering')
                                <span class="text-danger ml-2">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{--Category description--}}
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Category description</label>
                                <textarea  cols="4" rows="4" name="description" placeholder="Category desc...." class="form-control">{{$category->description}}</textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @if(request()->query('sub') == 1)
                            {{--Parent--}}
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="">Parent category</label>
                                    <select name="parent_id" id="" class="form-control">
                                        <option value="">Not Set</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" @selected($category->parent_id == $cat->id)>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <span class="text-danger ml-2">
                                {{ $message }}
                            </span>
                                    @enderror
                                </div>
                            </div>

                            {{--is child of--}}
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="">Is Child Of</label>
                                    <select name="is_child_of" id="" class="form-control">
                                        <option readonly>-- Independent --</option>
                                        @foreach ($subCategories as $subCat)
                                            <option value="{{ $subCat->id }}"  @selected($category->is_child_of == $subCat->id )>
                                                {{ $subCat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('is_child_of')
                                    <span class="text-danger ml-2">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                            </div>
                        @endif

                        {{--is_active--}}
                        <div class="col-md-7">
                            <div class="form-group">
                                <div class="form-check form-check-custom form-check-solid" >
                                    <input class="form-check-input" type="checkbox" @checked($category->is_active)
                                           value="1" id="CheckIsActive" name="is_active"
                                    />
                                    <label class="form-check-label" for="CheckIsActive">
                                        is_active
                                    </label>
                                </div>
                                @error('is_active')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--image--}}
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="">Category image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                <span class="text-danger ml-2">
                                {{ $message }}
                            </span>
                                @enderror
                            </div>
                            <div class="avatar mb-3">
                                <img src="{{$category->getFirstMediaUrl('image')}}" alt="cat image preview" data-ijabo-default-img="" width="150" height="150" id="category_image_preview">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{--read image--}}
    <script>
        $(document).ready(function() {
            $('#image').on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#category_image_preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(file);
                } else {
                    $('#category_image_preview').hide();
                }
            });
        });
    </script>

@endpush
