<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\PaymentMethodValidation;

class PaymentMethodController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PaymentMethod::latest();
            $search = $request->search;
            if ($search) {
                $data->where('name', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('details', function ($row) {
                    return $row->account_number . '<br>' . $row->branch_name . '<br>' . $row->ifsc_code;
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.payment_methods.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.payment_methods.index');
    }

    public function create()
    {
        //
    }

    public function store(PaymentMethodValidation $request)
    {
        $image=Null;
        $status = $request->has('status') ? 1 : 0;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/payments'), $filename);
            $image= $filename;
        }
        $data=[
            'name'=>$request->name,
            'image'=>$image,
            'status'=>$status,
            'description'=>$request->description,
            'upi_id'=>$request->upi_id,
            'bank_name'=>$request->bank_name,
            'account_number'=>$request->account_number,
            'branch_name'=>$request->branch_name,
            'ifsc_code'=>$request->ifsc_code,
            'account_name'=>$request->account_name,
        ];
        if($request->filled('id')){
            $method=PaymentMethod::find($request->id);
            if($image){
                if($method->image!=null){
                    unlink(public_path('uploads/payments/'. $method->image));
                }
            }
            $res=$method->update($data);
        }else{
            $res=PaymentMethod::create($data);
        }
        if($res){
            return response()->json(['success' => 'Payment method updated successfully']);
        }else{
            return response()->json(['error' => 'Failed to update payment method. Please try again.']);
        }
    }

    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail(Crypt::decrypt($id));
        return response()->json($method);
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail(Crypt::decrypt($id));
        if($method->image!=null){
            unlink(public_path('uploads/payments/'. $method->image));
        }
        $method->delete();
        return redirect()->route('admin.payment-methods.index')->with('success', 'Payment method deleted successfully');
    }
}
