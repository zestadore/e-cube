<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BackGroundQuestion;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\BackGroundQuestionValidation;

class BackGroundQuestionController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BackGroundQuestion::latest();
            $search = $request->search;
            if ($search) {
                $data->where('question', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.background_question.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.background_question.index');
    }
    
    public function create()
    {
        //
    }

    public function store(BackGroundQuestionValidation $request)
    {
        $data = $request->validated();
        
        if($request->filled('id')){
            $qualification = BackGroundQuestion::find($request->id);
            $qualification->update($data);
            return response()->json(['success' => 'Background question updated successfully']);
        }else{
            $qualification = BackGroundQuestion::create($data);
            return response()->json(['success' => 'Background question created successfully']);
        }
    }

    public function show(BackGroundQuestion $backGroundQuestion)
    {
        //
    }

    public function edit($id)
    {
        $qualification = BackGroundQuestion::findOrFail(Crypt::decrypt($id));
        return response()->json($qualification);
    }

    public function update(Request $request, BackGroundQuestion $backGroundQuestion)
    {
        //
    }

    public function destroy($id)
    {
        $qualification = BackGroundQuestion::findOrFail(Crypt::decrypt($id));
        $qualification->delete();
        return redirect()->route('admin.background-question.index')->with('success', 'Background question deleted successfully');
    }
}
