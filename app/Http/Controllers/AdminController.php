<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function datatable(){
        return Datatables::of(User::where('role','admin'))
        ->addColumn('action', function ($row) {
            return '
            <span style="overflow: visible; position: relative; width: 110px;">
               </a><a href="admin/edit/'.$row->id.'" title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </a><a href="#" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
               </span>';
        })
        ->toJson();

    }

    public function index(){
        $config = array(
            'title_page' => "Admin",
            'title_datatable' => "Admin Table"
        );
        return view('admin.datatable', compact('config'));
    }

    public function create(){
        return view('admin.form');
    }

    public function edit($id){
        $data = User::findOrFail($id);
        return view('admin.edit', compact('data'));
    }

    public function store(Request $request)
    {
        $data = new User();
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->name= $request->name;
        $data->username= $request->username;
        $data->nis = $request->nis;
        $data->role = 'admin';
        if($data->save()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }


    public function update(Request $request)
    {
        $data = User::find($request->id);
        $data->name= $request->name;
        $data->nis = $request->nis;
        $data->role = 'admin';
        if($data->save()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function delete(Request $request)
    {
        $data = User::find($request->id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

}
