<?php

namespace App\Http\Controllers;

use App\Raport;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use App\Kelas;
use DataTables;

class RaportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function datatable(){
        $raport = Raport::all();
        $data = Raport::select('*')
        ->when(!empty($_GET["guru"]) , function ($query) use($raport){
            return $query->where('id_users',$_GET["guru"]);
        })
        ->when(!empty($_GET["user"]) , function ($query) use($raport){
            return $query->where('id_users',$_GET["user"]);
        })
        ->when(!empty($_GET["kelas"]) , function ($query) use($raport){
            return $query->where('id_kelas',$_GET["kelas"]);
        })
        ->get();
        $data->load('user:id,name');
        $data->load('guru:id,name');
        $data->load('kelas:id_kelas,nama_kelas');
        return DataTables::collection($data)
        ->addColumn('action', function ($row) {
            return '
            <span style="overflow: visible; position: relative; width: 110px;">
               </a><a href="users/edit/'.$row->id.'" title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </a><a href="#" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id.'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
               </span>';
        })
        ->toJson();

    }

    public function index(){
        $config = array(
            'title_page' => "Raport Siswa",
            'title_datatable' => "Raport Siswa"
        );
        // $guru = DB::table('users')->where('role', '=', 'guru')->distinct('id_users')->get();
        $gurus = User::where('role', '=', 'guru')->distinct('id')->get(['id', 'name']);
        $users = User::where('role', '=', 'admin')->distinct('id')->get(['id', 'name']);
        $kelas = Kelas::distinct('id_kelas')->get(['id_kelas', 'nama_kelas']);



        return view('raport.datatable', compact('config', 'gurus', 'users', 'kelas'));
    }
}
