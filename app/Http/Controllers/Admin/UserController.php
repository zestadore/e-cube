<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function employees(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'employee')->latest();
            $search = $request->search;
            if ($search) {
                $data->where(function($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                          ->orWhere('last_name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('email_field', function ($row) {
                    if ($row->email_verified_at == null) {
                        return $row->email . '<span class="text-danger"> Pending</span>';
                    }
                    return $row->email . '<span class="text-success"> Verified</span>';
                })
                ->addColumn('mobile_field', function ($row) {
                    if ($row->mobile_verified_at == null) {
                        return $row->mobile . '<span class="text-danger"> Pending</span>';
                    }
                    return $row->mobile . '<span class="text-success"> Verified</span>';
                })
                ->addColumn('status_field', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge bg-success">Active</span>';
                    }
                    return '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $id = Crypt::encrypt($row->id);
                    return view('admin.users.action', compact('id', 'row'));
                })
                ->rawColumns(['action', 'status_field'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.users.employees');
    }

    public function employers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'employer')->latest();
            $search = $request->search;
            if ($search) {
                $data->where(function($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                          ->orWhere('last_name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('email_field', function ($row) {
                    if ($row->email_verified_at == null) {
                        return $row->email . '<span class="text-danger"> Pending</span>';
                    }
                    return $row->email . '<span class="text-success"> Verified</span>';
                })
                ->addColumn('mobile_field', function ($row) {
                    if ($row->mobile_verified_at == null) {
                        return $row->mobile . '<span class="text-danger"> Pending</span>';
                    }
                    return $row->mobile . '<span class="text-success"> Verified</span>';
                })
                ->addColumn('status_field', function ($row) {
                    if ($row->status == 'active') {
                        return '<span class="badge bg-success">Active</span>';
                    }
                    return '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $id = Crypt::encrypt($row->id);
                    return view('admin.users.action', compact('id', 'row'));
                })
                ->rawColumns(['action', 'status_field'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.users.employers');
    }

    public function show($id)
    {
        $user = User::where('id', Crypt::decrypt($id))->firstOrFail();
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', Crypt::decrypt($id))->first();
        $user->mobile_verified_at = now();
        $user->update();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $user = User::where('id', Crypt::decrypt($id))->firstOrFail();
        $user->status = $user->status == 'active' ? 'inactive' : 'active';
        $user->save();
        return response()->json(['success' => true, 'status' => $user->status]);
    }

    public function destroy($id)
    {
        $user = User::where('id', Crypt::decrypt($id))->firstOrFail();
        $user->delete();
        return response()->json(['success' => true]);
    }
}
