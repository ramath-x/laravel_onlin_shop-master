<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    // index
    public function index(Request $request)
    {
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'LIKE', '%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }
    // create
    public function create()
    {
        return view('admin.category.create');
    }
    // store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            $request->session()->flash('success', 'Category added successfully');

            return response()->json(
                [
                    'status' => true,
                    'massage' => 'Category added successfully'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors()
                ]
            );
        }
    }
    // edit
    public function edit()
    {
    }
    // update
    public function update()
    {
    }
    // destroy
    public function destroy()
    {
    }

    public function getSlug(Request $request)
    {
        $slug = '';
        if (!empty($request->title)) {
            $slug = Str::slug($request->title);
        }

        return response()->json([
            'status' => true,
            'slug' => $slug
        ]);
    }
}
