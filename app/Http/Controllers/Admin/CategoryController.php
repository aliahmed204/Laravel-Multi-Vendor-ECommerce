<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCatRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $data = [
        'pageTitle' => 'Categories',
    ];

    public function index()
    {
        return view('back.pages.admin.categories.index', [
            'pageTitle' => $this->data['pageTitle'],
        ]);
    }

    public function create()
    {
        // subcategory where has parent and it's not child of subcategory
        $independent_subCategories = Category::isSubCat()->isNotSubCatChild()->get();

        // parents where (parent_id === null)
        $categories = Category::isParent()->get();

        return view('back.pages.admin.categories.create', [
            'pageTitle'     => $this->data['pageTitle'] . ' create',
            'categories'    => $categories,
            'subCategories' => $independent_subCategories
        ]);
    }

    public function store(CreateCatRequest $request)
    {
        $cat = Category::create($request->except('token', 'image'));

        if ($request->hasFile('image')){
            $cat->addMedia($request->file('image'))->toMediaCollection('image');
        }

        return redirect()->route('admin.categories.create')
            ->with('success', '<b>'.ucfirst($request->name).'</b> category has been successfully added.');
    }

    public function edit($category)
    {
        $category = Category::findOrFail($category);

        // subcategory where has parent and it's not child of subcategory
        $independent_subCategories = Category::isSubCat()->isNotSubCatChild()->get();

        // parents where (parent_id === null)
        $categories = Category::isParent()->get();
        return view('back.pages.admin.categories.edit', [
            'category' => $category,
            'pageTitle' => $this->data['pageTitle'] . ' edit',
            'categories'    => $categories,
            'subCategories' => $independent_subCategories
        ]);
    }

    public function update(string $id, CreateCatRequest $request)
    {
        $category = Category::findOrFail($id);
        // to update slug by the package

        if( $category->children->count() && (!empty($request->is_child_of) || isset($request->is_child_of)) ){
            return redirect()->back()
                ->with('fail','This sub category has ('.$category->children->count().')children. You can not change "Is Child Of" option unless you free its children.');
        }

        $category->slug = null;
        $category->update($request->except('token', 'image'));

        // check if there is new image for the category
        if ($request->hasFile('image')){
            $category->clearMediaCollection('image');
            $category->addMedia($request->file('image'))->toMediaCollection('image');
        }

        return redirect()->route('admin.categories.edit', $category)
            ->with('success', '<b>'.ucfirst($request->name).'</b> category has been successfully updated.');
    }
}
