<?php

namespace App\Http\Controllers;

use App\Raport;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use App\Kelas;
use App\Matapelajaran;
use DataTables;

class RaportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function datatable(){
        $raport = Raport::all();
        $data = Raport::select('id_users', 'id_guru', 'tahun', 'id_kelas')
        ->when(!empty($_GET["guru"]) , function ($query) use($raport){
            return $query->where('id_users',$_GET["guru"]);
        })
        ->when(!empty($_GET["user"]) , function ($query) use($raport){
            return $query->where('id_users',$_GET["user"]);
        })
        ->when(!empty($_GET["kelas"]) , function ($query) use($raport){
            return $query->where('id_kelas',$_GET["kelas"]);
        })
        ->groupBy('id_users', 'tahun', 'id_guru', 'id_kelas')
        ->get();
        $data->load('user:id,name');
        $data->load('guru:id,name');
        $data->load('kelas:id_kelas,nama_kelas');
        return DataTables::collection($data)
        ->addColumn('action', function ($row) {
            return '
            <span style="overflow: visible; position: relative; width: 110px;">
               </a><a href="raport/detail/'.$row->tahun.'/'.$row->id_users.' " title="Lihat Raport" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </span>';
        })
        ->toJson();
    }


    public function datatabledetail(){
        $year = $_GET["tahun"];
        $id = $_GET["id_users"];
        // $data = User::with(['raport' => function($q) use($year) {
        //     $q->where('raport.tahun', $year);
        // }, 'raport.matapelajaran'])->where('id', $id)
        // ->get();
        // return response()->json(['data' => $data]);


        $data = Raport::with(['matapelajaran:id_matapelajaran,mata_pelajaran'])->where('id_users', $id)->where('tahun', $year)->get();
        return DataTables::collection($data)
        ->addColumn('tugas1', function($row) {
            return '
                <a href="#" name="tugas1" data-type="text" data-pk="'.$row->id.'" data-url="/post" data-title="Enter username">Tugas 1</a>
            ';
        })
        ->addColumn('action', function ($row) {
            return '
            <span style="overflow: visible; position: relative; width: 110px;">
               </a><a href="raport/detail/edit/'.$row->id.'" data-toggle="modal" data-target="#modalEdit" title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </span>';
        })
        ->toJson();
    }

    public function store(Request $request)
    {
        $data = new Raport();
        $data->id_users         = $request->id_users;
        $data->id_guru          = $request->id_guru;
        $data->id_kelas         = $request->id_kelas;
        $data->id_matapelajaran = $request->id_matapelajaran;
        $data->tahun            = $request->tahun;
        if($data->save()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function index(){
        $config = array(
            'title_page' => "Raport Siswa",
            'title_datatable' => "Raport Siswa"
        );
        // $guru = DB::table('users')->where('role', '=', 'guru')->distinct('id_users')->get();
        $gurus = User::where('role', '=', 'guru')->distinct('id')->get(['id', 'name']);
        $users = User::where('role', '=', 'siswa')->distinct('id')->get(['id', 'name']);
        $kelas = Kelas::distinct('id_kelas')->get(['id_kelas', 'nama_kelas']);

        return view('raport.datatable', compact('config', 'gurus', 'users', 'kelas'));
    }

    public function create(){
        $config = array(
            'title_page' => "Add Raport Siswa",
            'title_datatable' => "Add Raport Siswa"
        );
        $siswa = User::select('id', 'name')->where('role', '=', 'siswa')->get();
        $guru = User::select('id', 'name')->where('role', '=', 'guru')->get();
        $matapelajaran = Matapelajaran::select('id_matapelajaran','mata_pelajaran')->get();
        $kelas = Kelas::select('id_kelas', 'nama_kelas')->get();
        return view('raport.form', compact('config', 'siswa', 'guru', 'matapelajaran', 'kelas'));
    }


    public function detail($year, $id){
        $config = array(
            'title_page' => "Raport Siswa",
            'title_datatable' => "Raport Siswa"
        );
        return view('raport.detail', compact('config'));
    }


    public function delete(Request $request)
    {
        $data = Raport::find($request->id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }
}
