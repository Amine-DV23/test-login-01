<?php

namespace App\Http\Controllers;

use App\Models\Bopos;
use Illuminate\Http\Request;

class BoposController extends Controller
{
    public function store(Request $request)
    {
        // التحقق من وجود ملف صورة
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // التحقق من الصورة
        ]);

        if ($request->hasFile('image')) {
            // رفع الصورة وتخزينها في مجلد storage/images
            $path = $request->file('image')->store('images', 'public');

            // حفظ مسار الصورة في قاعدة البيانات
            Bopos::create([
                'name' => $request->name,
                'imagepath' => '/storage/' . $path,  // مسار الصورة
            ]);
        }

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }
}
