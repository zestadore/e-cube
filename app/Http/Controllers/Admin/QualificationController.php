<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\QualificationValidation;
use Illuminate\Support\Facades\Crypt;

class QualificationController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Qualification::latest();
            $search = $request->search;
            if ($search) {
                $data->where('degree', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.qualification.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.qualification.index');
    }

    public function create()
    {
        //
    }

    public function store(QualificationValidation $request)
    {
        $data = $request->validated();
        
        if($request->filled('id')){
            $qualification = Qualification::find($request->id);
            $qualification->update($data);
            return response()->json(['success' => 'Qualification updated successfully']);
        }else{
            $qualification = Qualification::create($data);
            return response()->json(['success' => 'Qualification created successfully']);
        }
    }

    public function show(Qualification $qualification)
    {
        //
    }

    public function edit($id)
    {
        $qualification = Qualification::findOrFail(Crypt::decrypt($id));
        return response()->json($qualification);
    }

    public function update(Request $request, Qualification $qualification)
    {
        //
    }

    public function destroy($id)
    {
        $qualification = Qualification::findOrFail(Crypt::decrypt($id));
        $qualification->delete();
        return redirect()->route('admin.qualification.index')->with('success', 'Qualification deleted successfully');
    }
}