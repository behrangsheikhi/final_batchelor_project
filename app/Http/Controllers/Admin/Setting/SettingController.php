<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Setting\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $setting = Setting::first();
        if ($setting == null) {
            $default = new SettingSeeder();
            $default->run();
            $setting = Setting::first();
        }

        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {

        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, Setting $setting, ImageService $imageService)
    {

        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            if (!empty($setting->logo)) {
                $imageService->deleteImage($setting->logo);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('logo');
            $result = $imageService->save($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.setting.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        }
        if ($request->hasFile('icon')) {
            if (!empty($setting->icon)) {
                $imageService->deleteImage($setting->icon);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('icon');
            $result = $imageService->save($request->file('icon'));
            if ($result === false) {
                return redirect()->route('admin.setting.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['icon'] = $result;
        }

        $setting->update($inputs);

        return redirect()->route('admin.setting.index')->with('swal-success', 'تنظیمات سایت شما با موفقیت ویرایش شد');
    }

}
