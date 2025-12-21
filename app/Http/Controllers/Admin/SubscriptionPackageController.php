<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\SubscriptionPackageValidation;
use Illuminate\Support\Facades\Crypt;

class SubscriptionPackageController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubscriptionPackage::latest();
            $search = $request->search;
            if ($search) {
                $data->where('name', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.subscription_packages.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.subscription_packages.index');
    }

    public function create()
    {
        //
    }

    public function store(SubscriptionPackageValidation $request)
    {
        $data = $request->except(['_token']);
        
        if($request->filled('id')){
            $package = SubscriptionPackage::find($request->id);
            $package->update($data);
            $successmsg='Subscription package updated successfully';
        }else{
            $package = SubscriptionPackage::create($data);
            $successmsg='Subscription package created successfully';
        }
        return response()->json(['success' => $successmsg]);
    }

    public function show(SubscriptionPackage $subscriptionPackage)
    {
        //
    }

    public function edit($id)
    {
        $package = SubscriptionPackage::findOrFail(Crypt::decrypt($id));
        return response()->json($package);
    }

    public function update(Request $request, SubscriptionPackage $subscriptionPackage)
    {
        //
    }

    public function destroy($id)
    {
        $package = SubscriptionPackage::findOrFail(Crypt::decrypt($id));
        $package->delete();
        return redirect()->route('admin.subscription_packages.index')->with('success', 'Subscription package deleted successfully');
    }
}
