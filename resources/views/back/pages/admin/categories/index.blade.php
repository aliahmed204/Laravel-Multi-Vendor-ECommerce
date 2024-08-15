@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?? 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'Categories' }}
    </li>
@endsection

@section('content')
    @livewire('admin-categories')
@endsection

@push('scripts')

    <script>
        $('table tbody#sortable_categories').sortable({
            cursor:"move",
            update:function(event,ui){
                $(this).children().each(function(index){
                    if( $(this).attr("data-ordering") !== (index+1) ){
                        $(this).attr("data-ordering",(index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"),$(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });

                Livewire.dispatch("updateCategoriesOrdering",[positions]);
            }
        });

        $(document).on('click','.deleteCategoryBtn', function(e){
            e.preventDefault();
            var category_id = $(this).data('id');

            Swal.fire({
                title:'Are you sure?',
                html:'You want to delete this category',
                showCloseButton:true,
                showCancelButton:true,
                cancelButtonText:'Cancel',
                confirmButtonText:'Yes, Delete',
                cancelButtonColor:'#d33',
                confirmButtonColor:'#3085d6',
                width:300,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    Livewire.dispatch('deleteCategory',[category_id]);
                }
            });
        });

        $('table tbody#sortable_subcategories').sortable({
            cursor:"move",
            update:function(event, ui){
                $(this).children().each(function(index){
                    if( $(this).attr("data-ordering") != (index+1) ){
                        $(this).attr("data-ordering",(index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"),$(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                Livewire.dispatch("updateSubCategoriesOrdering",[positions]);
            }
        });

        $('ul#sortable_child_subcategories').sortable({
            cursor:"move",
            update:function(event, ui){
                $(this).children().each(function(index){
                    if( $(this).attr("data-ordering") != (index+1) ){
                        $(this).attr("data-ordering",(index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"),$(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                Livewire.dispatch("updateChildSubCategoriesOrdering",[positions]);
            }
        });

        $(document).on('click', '.deleteSubCategoryBtn, .deleteChildSubCategoryBtn', function(e) {
            e.preventDefault();
            var subcategory_id = $(this).data("id");
            var title = $(this).data("title");
            Swal.fire({
                title: 'Are you sure?',
                html: 'You want to delete this <b>' + title + '</b>',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    Livewire.dispatch("deleteSubCategory", [subcategory_id]);
                }
            });
        });


    </script>
@endpush
