<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bopo;

class AdminProductController extends Controller
{
    public function store(Request $request)
    {
        // تحقق من البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'imagepath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // رفع الصورة وتخزينها
        if ($request->hasFile('imagepath')) {
            // تحقق من رفع الصورة
            if ($request->file('imagepath')->isValid()) {
                $imagePath = $request->file('imagepath')->store('images', 'public'); // تخزين الصورة في مجلد storage/app/public/images

                // حفظ المنتج في قاعدة البيانات
                Bopo::create([
                    'name' => $request->name,
                    'imagepath' => $imagePath, // تخزين مسار الصورة
                ]);

                return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
            } else {
                return redirect()->back()->withErrors(['imagepath' => 'صورة غير صالحة.']);
            }
        }

        return redirect()->back()->withErrors(['imagepath' => 'يجب رفع صورة.']);
    }
}
