<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\SliderValidation;

class SliderController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::latest();
            $search = $request->search;
            if ($search) {
                $data->where('title', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.sliders.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.sliders.index');
    }

    public function create()
    {
        //
    }

    public function store(SliderValidation $request)
    {
        $image=Null;
        $status = $request->has('status') ? 1 : 0;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/sliders'), $filename);
            $image= $filename;
        }
        $data=[
            'title'=>$request->title,
            'image'=>$image,
            'status'=>$status,
            'description'=>$request->description,
        ];
        if($request->filled('id')){
            $slider=Slider::find($request->id);
            if($image){
                if($slider->image!=null){
                    unlink(public_path('uploads/sliders/'. $slider->image));
                }
            }
            $res=$slider->update($data);
        }else{
            $res=Slider::create($data);
        }
        if($res){
            return response()->json(['success' => 'Slider updated successfully']);
        }else{
            return response()->json(['error' => 'Failed to update slider. Please try again.']);
        }
    }

    public function show(Slider $slider)
    {
        //
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail(Crypt::decrypt($id));
        return response()->json($slider);
    }

    public function update(Request $request, Slider $slider)
    {
        //
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail(Crypt::decrypt($id));
        if($slider->image!=null){
            unlink(public_path('uploads/sliders/'. $slider->image));
        }
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully');
    }
}
