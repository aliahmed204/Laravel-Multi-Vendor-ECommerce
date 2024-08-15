<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

/** @var Category $categories */
class AdminCategories extends Component
{
    use WithPagination;
    public $catPerPage = 6;
    public $subCatsPerPage = 10;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory',
        'updateSubCategoriesOrdering',
        'updateChildSubCategoriesOrdering',
        'deleteSubCategory'
    ];
    public function updateCategoriesOrdering($positions)
    {
        foreach($positions as $position){
            $id = $position[0];
            $newPosition = $position[1];
            Category::where('id', $id)->update([
                'ordering'=>$newPosition
            ]);

            $this->showToastr('success','Categories ordering have been successfully updated.');
        }
    }
    public function deleteCategory($cat_id)
    {
        /**@var Category $cat*/

        $cat = Category::firstWhere('id', $cat_id);

        if ($cat->subCategories()->count() > 0){
            $this->showToastr('error','This category has ('.$cat->subCategories()->count().')sub-categories. You can not delete it unless you free its sub-categories.');
            return;
        }

        $cat->getFirstMedia('image')->delete();
        $deleted = $cat->delete();

        if ($deleted)
            $this->showToastr('success','category deleted successfully');
        else
            $this->showToastr('error','something went wrong');
    }

    public function deleteSubCategory($sub_category_id)
    {
        $cat = Category::findOrFail($sub_category_id);

        if( $cat->children->count() ){
            $this->showToastr('error','This sub category has ('.$cat->children->count().')children. You can not delete it unless you free its children.');
            return;
            // or i can delete children of this sub category
            /*foreach ($cat->children as $child)
            {
                $child->getFirstMedia('image')->delete();
                $child->delete();
            }*/
        }
//        if ($cat->products->count()){
//            $this->showToastr('error','This sub category has ('.$cat->products->count().')products. You can not delete it unless you free its products.');
//            return;
//        }

        $cat->getFirstMedia('image')->delete();
        $deleted = $cat->delete();

        if ($deleted)
            $this->showToastr('success','Sub-Category deleted successfully');
        else
            $this->showToastr('error','something went wrong');
    }

    public function updateSubCategoriesOrdering($positions)
    {
        foreach($positions as $position){
            $id = $position[0];
            $newPosition = $position[1];
            Category::where('id', $id)->update([
                'ordering' => $newPosition
            ]);
        }
        $this->showToastr('success','Sub-Categories ordering have been successfully updated.');
    }

    public function updateChildSubCategoriesOrdering($positions)
    {
        foreach($positions as $position){
            $id = $position[0];
            $newPosition = $position[1];
            Category::where('id', $id)->update([
                'ordering' => $newPosition
            ]);
        }
        $this->showToastr('success','ChildSub-Categories ordering have been successfully updated.');
    }

    public function render()
    {
        return view('livewire.admin-categories',[
            'categories' => Category::isParent()->ordered()->paginate($this->catPerPage),
            'subCategories' => Category::isSubCat()->ordered()->paginate($this->subCatsPerPage, ['*'], 'subcatspage'),
        ]);
    }
    public function showToastr($type,$message){
        return $this->dispatch('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
}
