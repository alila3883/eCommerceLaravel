<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VendorController extends Controller
{

    public function index()
    {
        $vendors = Vendor::selection()->paginate(default_paginate());
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        $categories = MainCategory::active()->whereTranslationOf(0)->get();
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
                'password'     => $request->password,
                'mobile'       => $request->mobile,
                'status'       => $request->status,
                'address'      => $request->address,
                'logo'         => $filePath,
            ]);

            // Send Notification To User
            Notification::send($vendor, new VendorCreated($vendor));

            return redirect()->route('vendors.index')->with(['success' => 'تم انشاء المتجر بنجاح']);


        } catch (\Exception $exception) {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }

    public function edit($id)
    {
        try {

            $vendor = Vendor::selection()->find($id);

            if (!$vendor) {
                return redirect()->route('vendors.index')->with(['error' => 'هذا المتجر غير موجود']);
            }

            $categories = MainCategory::where('translation_of', 0)->active()->get();

            return view('admin.vendors.edit', compact('vendor', 'categories'));

        } catch (\Exception $exception) {

            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }

    public function update(VendorRequest $request, $id)
    {
        try {


            $vendor = Vendor::selection()->find($id);

            DB::beginTransaction();

            if (!$vendor){
                return redirect()->route('vendors.index')->with(['error' => 'هذا المتجر غير موجود!']);
            }

            if (!$request->has('status')) {
                $request->request->add(['status' => 0]);
            } else {
                $request->request->add(['status' => 1]);
            }

            $data = $request->except('_token', 'id', 'logo', 'password', 'latitude', 'longitude');

            // Update Logo
            if ($request->has('logo')) {

                if (File::exists('assets/images/vendors/' . $request->logo)) {
                    unlink('assets/images/vendors/' . $request->logo);
                }

                $filePath = uploadImageByName('vendors', $request->name, $request->logo, $request->id);

                Vendor::where('id', $id)->update([
                    'logo' => $filePath
                ]);
            }

            $vendor->update($data);

            // Update Password
            if ($request->has('password')) {

                Vendor::where('id', $id)->update([
                    'password' => bcrypt($request->password)
                ]);
            }

            DB::commit();

            return redirect()->route('vendors.index')->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $exception) {
            return $exception->getMessage();
            DB::rollBack();
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطأ أثناء انشاء الارسال يرجى المحاولة لاحقا']);
        }
    }

    public function destroy($id)
    {
        try {

            $vendor = Vendor::find($id);

            if (!$vendor) {
                return redirect()->route('main_categories.index')->with(['error' => 'هذا المتجر غير موجود']);
            }

//            if ($vendor->logo) {
//                if (File::exists('assets/images/' . $vendor->logo)) {
//
//                    unlink('assets/images/' . $vendor->logo);
//                }
//            }


            $logo = Str::after($vendor->logo, 'assets/');
            $logo = base_path('public/assets/'.$logo);
            unlink($logo);


            $vendor->delete();

            return redirect()->route('vendors.index')->with(['success' => 'تم حذف المتجر بنجاح']);

        } catch (\Exception $exception) {

            return redirect()->back()->with(['error' => 'حدث خطأ يرجى المحاولة لاحقا']);
        }
    }
}
