<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Kelas;

class KelasController extends Controller
{

    public function datatable(){
        return Datatables::of(kelas::query())
        ->addColumn('action', function ($row) {
            return '
            <span style="overflow: visible; position: relative; width: 110px;">
               </a><a href="#" data-toggle="modal" data-target="#modalUpdate" data-id="'. $row->id_kelas.'"
               data-nama_kelas="'. $row->nama_kelas.'" title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </a><a href="#" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id_kelas.'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
               </span>';
        })
        ->toJson();
    }

    public function index(){
        $config = array(
            'title_page' => "Kelas",
            'title_datatable' => "Kelas Table"
        );
        return view('kelas.datatable', compact('config'));
    }

    public function add(Request $request)
    {
        $data = new Kelas;
        $data->nama_kelas = $request->nama_kelas;
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
        $data = Kelas::find($request->id);
        $data->nama_kelas =  $request->nama_kelas;
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
        $data = Kelas::find($request->id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }
}
