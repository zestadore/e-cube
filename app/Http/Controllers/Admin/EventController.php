<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\EventValidation;
use Carbon\Carbon;

class EventController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::latest();
            $search = $request->search;
            if ($search) {
                $data->where('title', 'like', '%' . $search . '%');
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('time', function ($row) {
                    return Carbon::parse($row->start_time)->format('h:i A') . ' - ' . Carbon::parse($row->end_time)->format('h:i A');
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    return view('admin.events.action', compact('id'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.events.index');
    }
   
    public function create()
    {
        //
    }

    public function store(EventValidation $request)
    {
        $image=Null;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/sliders'), $filename);
            $image= $filename;
        }
        $data=[
            'title'=>$request->title,
            'image'=>$image,
            'description'=>$request->description,
            'date'=>$request->date,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'location'=>$request->location
        ];
        if($request->filled('id')){
            $event=Event::find($request->id);
            if($image){
                if($event->image!=null){
                    unlink(public_path('uploads/events/'. $event->image));
                }
            }
            $res=$event->update($data);
        }else{
            $res=Event::create($data);
        }
        if($res){
            return response()->json(['success' => 'Event updated successfully']);
        }else{
            return response()->json(['error' => 'Failed to update event. Please try again.']);
        }
    }

    public function show(Event $event)
    {
        //
    }

    public function edit($id)
    {
        $event = Event::findOrFail(Crypt::decrypt($id));
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        //
    }

    public function destroy($id)
    {
        $event = Event::findOrFail(Crypt::decrypt($id));
        if($event->image!=null){
            unlink(public_path('uploads/events/'. $event->image));
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully');
    }
}
