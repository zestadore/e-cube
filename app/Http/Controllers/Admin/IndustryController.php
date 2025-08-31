<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\IndustryValidation;
use Illuminate\Support\Facades\Crypt;

class IndustryController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Industry::query()->latest();
            $search = $request->search;
            if ($search) {
                $data->where('industry_name', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('parent', function ($row) {
                    return $row->parents->pluck('industry_name')->implode(', ');
                })
                ->addColumn('created', function ($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('action', 'admin.industry.action')
                ->make(true);
        }
        $industries = Industry::where('status', 1)->get();
        return view('admin.industry.index', compact('industries'));
    }

    public function create()
    {
        //
    }

    public function store(IndustryValidation $request)
    {
        $status = $request->has('status') ? 1 : 0;
        if($request->filled('id')){
            $industry = Industry::find($request->id);
            $industry->update($request->except(['_token', 'parent', 'status']) + [
                'status' => $status,
            ]);
            $successmsg='Industry updated successfully';
        }else{
            $industry = Industry::create($request->except(['_token', 'parent', 'status']) + [
                'status' => $status,
            ]);
            $successmsg='Industry created successfully';
        }
        if ($request->filled('parent')) {
            $industry->parents()->sync($request->parent);
        }else{
            $industry->parents()->detach();
        }
        return redirect()->route('admin.industry.index')->with('success', $successmsg);
    }

    public function show(Industry $industry)
    {
        //
    }

    public function edit($id)
    {
        $industry = Industry::with('parents')->findOrFail(Crypt::decrypt($id));
        return response()->json($industry);
    }

    public function update(Request $request, Industry $industry)
    {
        //
    }

    public function destroy($id)
    {
        $industry = Industry::findOrFail(Crypt::decrypt($id));
        $industry->parents()->detach();
        $industry->delete();
        return redirect()->route('admin.industry.index')->with('success', 'Industry deleted successfully');
    }
}
