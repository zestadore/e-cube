<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use App\Http\Requests\ReviewValidation;

class ReviewController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::latest();
            $search = $request->search;
            if ($search) {
                $data->where('title', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.reviews.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.reviews.index');
    }

    public function create()
    {
        //
    }

    public function store(ReviewValidation $request)
    {
        $data = $request->validated();
        
        if($request->filled('id')){
            $qualification = Review::find($request->id);
            $qualification->update($data);
            return response()->json(['success' => 'Review updated successfully']);
        }else{
            $qualification = Review::create($data);
            return response()->json(['success' => 'Review created successfully']);
        }
    }

    public function show(Review $review)
    {
        //
    }

    public function edit($id)
    {
        $review = Review::findOrFail(Crypt::decrypt($id));
        return response()->json($review);
    }

    public function update(Request $request, Review $review)
    {
        //
    }

    public function destroy($id)
    {
        $review = Review::findOrFail(Crypt::decrypt($id));
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully');
    }
}
