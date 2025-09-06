<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ComputerAndOtherSkill;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\ComputerAndOtherSkillValidation;
use Illuminate\Support\Facades\Crypt;

class ComputerAndOtherSkillController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ComputerAndOtherSkill::latest();
            $search = $request->search;
            if ($search) {
                $data->where('skill', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = Crypt::encrypt($row->id);
                    return view('admin.computer_and_other_skill.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.computer_and_other_skill.index');
    }

    public function create()
    {
        //
    }

    public function store(ComputerAndOtherSkillValidation $request)
    {
        $data = $request->validated();
        
        if($request->filled('id')){
            $skill = ComputerAndOtherSkill::find($request->id);
            $skill->update($data);
            return response()->json(['success' => 'Skill updated successfully']);
        }else{
            $skill = ComputerAndOtherSkill::create($data);
            return response()->json(['success' => 'Skill created successfully']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);
        $skill = ComputerAndOtherSkill::find($id);
        return response()->json($skill);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);
        ComputerAndOtherSkill::find($id)->delete();
        return redirect()->back()->with('success', 'Skill deleted successfully');
    }
}