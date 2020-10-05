<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function index()
    {
        $languages = Language::selection()
            ->paginate(default_paginate());
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request)
    {
        try {
            Language::create($request->except(['_token']));
            return redirect()->route('languages.index')->with(['success' => 'تم حفظ اللغة بنجاح']);
        }catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }

    public function edit($id)
    {
        $language = Language::selection()->find($id);

        if (!$language) {
            return redirect()->route('languages.index')->with(['error' => 'هذه اللغة غير موجودة']);
        }

        return view('admin.languages.edit', compact('language'));
    }

    public function show()
    {
        //
    }

    public function update(LanguageRequest $request, $id)
    {
        try {
            $language = Language::find($id);

            if (!$language) {
                return redirect()->route('languages.edit')->with(['error' => 'هذه اللغة غير موجودة']);
            }

            if (!$request->has('status')) {
                $request->request->add(['status' => 0]);
            } else {
                $request->request->add(['status' => 1]);
            }

            $language->update($request->except('_token'));

            return redirect()->route('languages.index')->with(['success' => 'تم تحديث اللغة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }

    }


    public function destroy($id)
    {
        try {
            $language = Language::find($id);

            if (!$language) {
                return redirect()->route('languages.index')->with(['error' => 'هذه اللغة غير موجودة']);
            }

            $language->delete();

            return redirect()->route('languages.index')->with(['success' => 'تم حذف اللغة بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }
}
