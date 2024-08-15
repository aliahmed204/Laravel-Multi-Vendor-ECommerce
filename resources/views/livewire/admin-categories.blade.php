<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{route('admin.categories.create')}}" class="btn btn-primary btn-sm" type="button">
                            <i class="fa fa-plus"></i>
                            Add Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                        <tr>
                            <th>Category image</th>
                            <th>Category name</th>
                            <th>N. of sub categories</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="sortable_categories">
                        @forelse ($categories as $cat)
                            <tr data-index="{{ $cat->id }}" data-ordering="{{ $cat->ordering }}">
                                <td>
                                    <div class="avatar mr-2">
                                        <img src="{{ $cat->getFirstMediaUrl('image') }}" width="50" height="50" alt="">
                                    </div>
                                </td>
                                <td>
                                    {{ $cat->name }}
                                </td>
                                <td>
                                    {{ $cat->subCategories->count() }}
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{route('admin.categories.edit', ['category' => $cat->id])}}" class="text-primary">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="text-danger deleteCategoryBtn" data-id="{{ $cat->id }}">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <span class="text-danger">No category found!</span>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="d-block mt-2">
{{--                    {{ $categories->links('livewire::simple-bootstrap') }}--}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Sub Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{route('admin.categories.create',['sub' => true])}}" class="btn btn-primary btn-sm" type="button">
                            <i class="fa fa-plus"></i>
                            Add Sub Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                        <tr>
                            <th>Sub Category name</th>
                            <th>Parent Cat name</th>
                            <th>Child Sub Categories</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="sortable_subcategories">

                        @forelse ($subCategories as $subCat)


                            <tr data-index="{{ $subCat->id }}" data-ordering="{{ $subCat->ordering }}">

                                <td>
                                    {{ $subCat->name }}
                                </td>
                                <td>
                                    {{ $subCat->parent->name }}
                                </td>
                                <td>

                                    <ul class="list-group" id="sortable_child_subcategories">
                                        @forelse  ($subCat->children as $child)
                                            <li data-index="{{ $child->id }}" data-ordering="{{ $child->ordering }}" class="d-flex justify-content-between align-items-center">
                                                - {{ $child->name }}
                                                <div>
                                                    <a href="" class="text-primary" data-toggle="tooltip" title="Edit child sub category">Edit</a>
                                                    |
                                                    <a href="javascript:;" class="text-danger deleteChildSubCategoryBtn" data-toggle="tooltip" title="Delete child sub category" data-id="{{ $child->id }}" data-title="Child Sub Category">Delete</a>
                                                </div>
                                            </li>
                                        @empty
                                            none
                                        @endforelse
                                    </ul>

                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{route('admin.categories.edit', ['category' => $subCat->id, 'sub' => true])}}" class="text-primary">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="javascript:;" class="text-danger deleteSubCategoryBtn" data-id="{{ $subCat->id }}" data-title="Sub Category { {{ $subCat->name }} }">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4">
                                    <span class="text-danger">No sub category found!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-block mt-2">
{{--                    {{ $subcategories->links('livewire::simple-bootstrap') }}--}}
                </div>
            </div>
        </div>
    </div>
</div>
