<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainCategoryRequest;
use App\Models\MainCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MainCategoryController extends Controller
{
    public function index()
    {
        $categories = MainCategory::where('translation_lang', get_default_lang())
            ->selection()
            ->orderBy('id', 'desc')
            ->paginate(default_paginate());

        return view('admin.main_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.main_categories.create');
    }

    public function store(MainCategoryRequest $request)
    {
        try{
            $main_categories = collect($request-> category);

            $filter = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] == get_default_lang();
            });

            $default_category = array_values($filter->all())[0];

            $filePath= "";
            if ($request->has('image')) {
                $filePath = uploadImageByName('categories', $request->category[0]['name'], $request->image, $request->id);
            }

            DB::beginTransaction();

            // Insert Default Language In Database
            $default_category_id = MainCategory::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'image' => $filePath,
            ]);

            $categories = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] != get_default_lang();
            });

            // Insert Anther Language Founded Into Database
            if(isset($categories) && $categories->count())
            {
                $categories_arr = [];
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'image' => $filePath,
                    ];
                }

                MainCategory::insert($categories_arr);
            }

            DB::commit();

            return redirect()->route('main_categories.index')->with(['success' => 'تم الحفظ بنجاح']);

        }catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }

    public function edit($id)
    {
        $category = MainCategory::with('categories')
            ->selection()
            ->find($id);

        if (!$category){
            return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود!']);
        }

        return view('admin.main_categories.edit', compact('category'));
    }

    public function update(MainCategoryRequest $request, $id)
    {

        try{
            $main_category = MainCategory::find($id);

            if (!$main_category){
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود!']);
            }

            $category =  array_values($request->category)[0];

            if (!$request->has('category.0.status')) {
                $request->request->add(['status' => 0]);
            } else {
                $request->request->add(['status' => 1]);
            }

            MainCategory::where('id', $id)->update([
                'name' => $category['name'],
                'status' => $request->status,
            ]);

            // Update Image
            if ($request->has('image')) {
                if (File::exists('assets/images/categories/' . $request->image)) {
                    unlink('assets/images/categories/' . $request->image);
                }
                $filePath = uploadImageByName('categories', $request->category[0]['name'], $request->image, $request->id);

                MainCategory::where('id', $id)->update([
                    'image' => $filePath
                ]);
            }

            return redirect()->route('main_categories.index')->with(['success' => 'تم التحديث بنجاح']);
        }catch (\Exception $exception){
            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }

    }

    public function destroy($id)
    {

        try {
            $mainCategory = MainCategory::find($id);

            if (!$mainCategory) {
                return redirect()->route('main_categories.index')->with(['error' => 'هذه اللغة غير موجودة']);
            }

            foreach ($mainCategory->categories as $category) {
                $category->delete();
            }

            if ($mainCategory->image) {
                if (File::exists('assets/images/' . $mainCategory->image)) {

                    unlink('assets/images/' . $mainCategory->image);
                }
            }

            $mainCategory->delete();

            return redirect()->route('main_categories.index')->with(['success' => 'تم حذف القسم والصورة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }
}
