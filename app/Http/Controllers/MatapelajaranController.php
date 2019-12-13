<?php

namespace App\Http\Controllers;

use App\Matapelajaran;
use Illuminate\Http\Request;
use DataTables;

class MatapelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function datatable(){
        return Datatables::of(Matapelajaran::query())
        ->addColumn('action', function ($row) {
            return '
            <span style="overflow: visible; position: relative; width: 110px;">
               </a><a href="#" data-toggle="modal" data-target="#modalUpdate" data-id="'. $row->id_matapelajaran.'"
               data-mata_pelajaran="'. $row->mata_pelajaran.'" title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </a><a href="#" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id_matapelajaran.'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
               </span>';
        })
        ->toJson();
    }

    public function index(){
        $config = array(
            'title_page' => "Mata Pelajaran",
            'title_datatable' => "Mata Pelajaran Table"
        );
        return view('matapelajaran.datatable', compact('config'));
    }

    public function add(Request $request)
    {
        $data = new Matapelajaran;
        $data->mata_pelajaran = $request->mata_pelajaran;
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
        $data = Matapelajaran::find($request->id);
        $data->mata_pelajaran =  $request->mata_pelajaran;
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
        $data = Matapelajaran::find($request->id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }
}
