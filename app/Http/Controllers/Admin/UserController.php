<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNot('role', 'admin')->latest();
            $search = $request->search;
            if ($search) {
                $data->where('first_name', 'like', '%' . $search . '%');
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
                ->addColumn('role_field', function ($row) {
                    return ucfirst($row->role);
                })
                ->addColumn('action', function ($row) {
                    $id = Crypt::encrypt($row->id);
                    return view('admin.users.action', compact('id', 'row'));
                })
                ->rawColumns(['action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', Crypt::decrypt($id))->first();
        $user->mobile_verified_at = now();
        $user->update();
        return response()->json(['success' => true]);
    }
}
