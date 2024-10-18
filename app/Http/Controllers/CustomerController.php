<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
{
    $customers = Customer::all();
    return view('customers.index', compact('customers'));
}


public function create()
{
    $customers = Customer::all();

    return view('customers.create', compact('customers'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'note' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.create')->with('success', 'Customer information saved successfully!');
    }
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            return redirect()->back()->with('success', 'تم حذف الزبون بنجاح');
        }
        return redirect()->back()->with('error', 'لم يتم العثور على الزبون');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'note' => 'nullable',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->back()->with('success', 'تم تحديث معلومات الزبون بنجاح!');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        // البحث عن الأسماء التي تبدأ بالحرف المدخل
        $customers = \App\Models\Customer::where('name', 'LIKE', "{$query}%")->get();

        return response()->json($customers);
    }

}
