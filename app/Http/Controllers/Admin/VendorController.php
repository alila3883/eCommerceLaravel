<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VendorController extends Controller
{

    public function index()
    {
        $vendors = Vendor::selection()->paginate(default_paginate());
        return view('admin.vendors.index', compact('vendors'));
    }


    public function create()
    {
        $categories = MainCategory::whereStatus(1)->whereTranslationOf(0)->get();
        return view('admin.vendors.create', compact('categories'));
    }


    public function store(VendorRequest $request)
    {
        try {

            if (!$request->has('status')) {
                $request->request->add(['status' => 0]);
            } else {
                $request->request->add(['status' => 1]);
            }


            // insert Logo
            $filePath = "";
            if ($request->has('logo')) {
                if (File::exists('assets/images/vendors/' . $request->logo)) {
                    unlink('assets/images/vendors/' . $request->logo);
                }
                $filePath = uploadImageByName('vendors', $request->name, $request->logo, $request->id);
            }

            $vendor = Vendor::create([
                'name'         => $request->name,
                'category_id'  => $request->category_id,
                'email'        => $request->email,
//                'password'     => bcrypt($request->password),
                'mobile'       => $request->mobile,
                'status'       => $request->status,
                'address'      => $request->address,
                'logo'         => $filePath,
            ]);


            return redirect()->route('vendors.index')->with(['success' => 'تم انشاء المتجر بنجاح']);


        } catch (\Exception $exception) {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
