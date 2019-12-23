<?php

namespace App\Http\Controllers;

use App\Absen;
use App\Raport;
use App\User;
use Illuminate\Http\Request;
use App\Kelas;
use App\Matapelajaran;
use DataTables;
use Illuminate\Support\Facades\DB;
use PDF;

class RaportController extends Controller
{

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
               </a><a href="raport/detail/'.$row->tahun.'/'.$row->id_users.'/ganjil" title="Lihat Raport Ganjil" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </a><a href="raport/detail/'.$row->tahun.'/'.$row->id_users.'/genap" title="Lihat Raport Genap" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </a><a href="raport/detail/'.$row->tahun.'/'.$row->id_users.'/akhir" title="Lihat Raport Akhir" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
               </span>';
        })
        ->toJson();
    }

    public function datatabledetail($semester){
        $year = $_GET["tahun"];
        $id = $_GET["id_users"];
        // $data = User::with(['raport' => function($q) use($year) {
        //     $q->where('raport.tahun', $year);
        // }, 'raport.matapelajaran'])->where('id', $id)
        // ->get();
        // return response()->json(['data' => $data]);

        if($semester == "ganjil"){
            $data = Raport::select('*',
            DB::raw('(ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 AS pengetahuanrata'),
            DB::raw('(ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 AS keterampilanrata'),
            DB::raw('(ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 AS sikaprata'),
            DB::raw('(ganjilpts1+ganjilpts2+ganjilpts3)/3 AS ptsrata'),
            DB::raw('CASE
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=75 THEN "D"
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <75 AND (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=83 THEN "C"
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <84 AND (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=92 THEN "B"
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <93 AND (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS pengetahuanpredikat
            '),
            DB::raw('CASE
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=75 THEN "D"
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <75 AND (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=83 THEN "C"
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <84 AND (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=92 THEN "B"
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <93 AND (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS keterampilanpredikat
            '),
            DB::raw('CASE
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=75 THEN "D"
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <75 AND (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=83 THEN "C"
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <84 AND (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=92 THEN "B"
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <93 AND (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS sikappredikat
            '),
            DB::raw('CASE
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <=75 THEN "D"
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <75 AND (ganjilpts1+ganjilpts2+ganjilpts3)/4 <=83 THEN "C"
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <84 AND (ganjilpts1+ganjilpts2+ganjilpts3)/4 <=92 THEN "B"
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <93 AND (ganjilpts1+ganjilpts2+ganjilpts3)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS ptspredikat
            '),
            )->with(['matapelajaran:id_matapelajaran,mata_pelajaran'])->where('id_users', $id)->where('tahun', $year)->get();
            return DataTables::collection($data)
            ->addColumn('action', function ($row) {
                return '
                <span style="overflow: visible; position: relative; width: 110px;">
                   </a><a href="#"
                   data-toggle="modal"
                   data-id = "'.$row->id_raport.'"
                   data-ganjilpengetahuankd1 = "'.$row->ganjilpengetahuankd1.'"
                   data-ganjilpengetahuankd2 = "'.$row->ganjilpengetahuankd2.'"
                   data-ganjilpengetahuankd3 = "'.$row->ganjilpengetahuankd3.'"
                   data-ganjilpengetahuankd4 = "'.$row->ganjilpengetahuankd4.'"
                   data-ganjilketerampilankd1 = "'.$row->ganjilketerampilankd1.'"
                   data-ganjilketerampilankd2 = "'.$row->ganjilketerampilankd2.'"
                   data-ganjilketerampilankd3 = "'.$row->ganjilketerampilankd3.'"
                   data-ganjilketerampilankd4 = "'.$row->ganjilketerampilankd4.'"
                   data-ganjilsikapkd1 = "'.$row->ganjilsikapkd1.'"
                   data-ganjilsikapkd2 = "'.$row->ganjilsikapkd2.'"
                   data-ganjilsikapkd3 = "'.$row->ganjilsikapkd3.'"
                   data-ganjilsikapkd4 = "'.$row->ganjilsikapkd4.'"
                   data-ganjilpts1 = "'.$row->ganjilpts1.'"
                   data-ganjilpts2 = "'.$row->ganjilpts2.'"
                   data-ganjilpts3 = "'.$row->ganjilpts3.'"
                   data-target="#modalUpdate" title="Edit"
                   class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
                   </a><a href="#" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id_raport.'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
                   </span>';
            })
            ->toJson();
        }else if($semester == "genap"){
            $data = Raport::select('*',
            DB::raw('(genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 AS pengetahuanrata'),
            DB::raw('(genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 AS keterampilanrata'),
            DB::raw('(genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 AS sikaprata'),
            DB::raw('(genappts1+genappts2+genappts3)/3 AS ptsrata'),
            DB::raw('CASE
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=75 THEN "D"
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <75 AND (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=83 THEN "C"
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <84 AND (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=92 THEN "B"
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <93 AND (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS pengetahuanpredikat
            '),
            DB::raw('CASE
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=75 THEN "D"
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <75 AND (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=83 THEN "C"
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <84 AND (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=92 THEN "B"
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <93 AND (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS keterampilanpredikat
            '),
            DB::raw('CASE
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=75 THEN "D"
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <75 AND (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=83 THEN "C"
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <84 AND (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=92 THEN "B"
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <93 AND (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS sikappredikat
            '),
            DB::raw('CASE
            WHEN (genappts1+genappts2+genappts3)/3 <=75 THEN "D"
            WHEN (genappts1+genappts2+genappts3)/3 <75 AND (genappts1+genappts2+genappts3)/4 <=83 THEN "C"
            WHEN (genappts1+genappts2+genappts3)/3 <84 AND (genappts1+genappts2+genappts3)/4 <=92 THEN "B"
            WHEN (genappts1+genappts2+genappts3)/3 <93 AND (genappts1+genappts2+genappts3)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS ptspredikat
            '),
            )->with(['matapelajaran:id_matapelajaran,mata_pelajaran'])->where('id_users', $id)->where('tahun', $year)->get();
            return DataTables::collection($data)
            ->addColumn('action', function ($row) {
                return '
                <span style="overflow: visible; position: relative; width: 110px;">
                   </a><a href="#"
                   data-toggle="modal"
                   data-id = "'.$row->id_raport.'"
                   data-genappengetahuankd1 = "'.$row->genappengetahuankd1.'"
                   data-genappengetahuankd2 = "'.$row->genappengetahuankd2.'"
                   data-genappengetahuankd3 = "'.$row->genappengetahuankd3.'"
                   data-genappengetahuankd4 = "'.$row->genappengetahuankd4.'"
                   data-genapketerampilankd1 = "'.$row->genapketerampilankd1.'"
                   data-genapketerampilankd2 = "'.$row->genapketerampilankd2.'"
                   data-genapketerampilankd3 = "'.$row->genapketerampilankd3.'"
                   data-genapketerampilankd4 = "'.$row->genapketerampilankd4.'"
                   data-genapsikapkd1 = "'.$row->genapsikapkd1.'"
                   data-genapsikapkd2 = "'.$row->genapsikapkd2.'"
                   data-genapsikapkd3 = "'.$row->genapsikapkd3.'"
                   data-genapsikapkd4 = "'.$row->genapsikapkd4.'"
                   data-genappts1 = "'.$row->genappts1.'"
                   data-genappts2 = "'.$row->genappts2.'"
                   data-genappts3 = "'.$row->genappts3.'"
                   data-target="#modalUpdate" title="Edit"
                   class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
                   </a><a href="#" data-toggle="modal" data-target="#modalDelete" data-id="'. $row->id_raport.'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
                   </span>';
            })
            ->toJson();
        }


    }

    public function store(Request $request){
        $data = new Raport();
        $data->id_users         = $request->id_users;
        $data->id_guru          = $request->id_guru;
        $data->id_kelas         = $request->id_kelas;
        $data->id_matapelajaran = $request->id_matapelajaran;
        $data->tahun            = $request->tahun;

        $absen = new Absen();
        $count = Absen::where('tahun', $request->tahun)->where('id_users', $request->id_users)->count();
        if($count < 1){
            $absen->id_users        = $request->id_users;
            $absen->tahun           = $request->tahun;
            $absen->save();
        }

        if($data->save()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function update(Request $request){
        if ($request->semester == "ganjil") {
            $data = Raport::find($request->id);
            $data->ganjilpengetahuankd1   = $request->ganjilpengetahuankd1;
            $data->ganjilpengetahuankd2   = $request->ganjilpengetahuankd2;
            $data->ganjilpengetahuankd3   = $request->ganjilpengetahuankd3;
            $data->ganjilpengetahuankd4   = $request->ganjilpengetahuankd4;
            $data->ganjilketerampilankd1  = $request->ganjilketerampilankd1;
            $data->ganjilketerampilankd2  = $request->ganjilketerampilankd2;
            $data->ganjilketerampilankd3  = $request->ganjilketerampilankd3;
            $data->ganjilketerampilankd4  = $request->ganjilketerampilankd4;
            $data->ganjilsikapkd1         = $request->ganjilsikapkd1;
            $data->ganjilsikapkd2         = $request->ganjilsikapkd2;
            $data->ganjilsikapkd3         = $request->ganjilsikapkd3;
            $data->ganjilsikapkd4         = $request->ganjilsikapkd4;
            $data->ganjilpts1             = $request->ganjilpts1;
            $data->ganjilpts2             = $request->ganjilpts2;
            $data->ganjilpts3             = $request->ganjilpts3;
        } else {
            $data = Raport::find($request->id);
            $data->genappengetahuankd1   = $request->genappengetahuankd1;
            $data->genappengetahuankd2   = $request->genappengetahuankd2;
            $data->genappengetahuankd3   = $request->genappengetahuankd3;
            $data->genappengetahuankd4   = $request->genappengetahuankd4;
            $data->genapketerampilankd1  = $request->genapketerampilankd1;
            $data->genapketerampilankd2  = $request->genapketerampilankd2;
            $data->genapketerampilankd3  = $request->genapketerampilankd3;
            $data->genapketerampilankd4  = $request->genapketerampilankd4;
            $data->genapsikapkd1         = $request->genapsikapkd1;
            $data->genapsikapkd2         = $request->genapsikapkd2;
            $data->genapsikapkd3         = $request->genapsikapkd3;
            $data->genapsikapkd4         = $request->genapsikapkd4;
            $data->genappts1             = $request->genappts1;
            $data->genappts2             = $request->genappts2;
            $data->genappts3             = $request->genappts3;
        }

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

    public function detail($year, $id, $semester){
        if($semester == "ganjil"){
            $config = array(
                'title_page' => "Raport Siswa Ganjil",
                'title_datatable' => "Raport Siswa Ganjil"
            );
            $data = User::with(['raport' => function($q) use($year) {
                $q->where('raport.tahun', $year);
            }, 'raport.matapelajaran', 'raport.kelas'],)->where('id', $id)
            ->first();
            $absen = Absen::where('tahun', $year)->where('id_users', $id)->first();
            return view('raport.ganjil', compact('config', 'data', 'year', 'absen'));
        }else if($semester == "genap"){
            $config = array(
                'title_page' => "Raport Siswa Genap",
                'title_datatable' => "Raport Siswa Genap"
            );
            $data = User::with(['raport' => function($q) use($year) {
                $q->where('raport.tahun', $year);
            }, 'raport.matapelajaran', 'raport.kelas'],)->where('id', $id)
            ->first();
            $absen = Absen::where('tahun', $year)->where('id_users', $id)->first();
            return view('raport.genap', compact('config', 'data', 'year', 'absen'));
        }
    }

    public function delete(Request $request){
        $data = Raport::find($request->id);
        if($data->delete()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function absensi(Request $request){
        if ($request->semester == "ganjil") {
            $data               = Absen::find($request->id);
            $data->ganjilsakit  = $request->ganjilsakit;
            $data->ganjilizin   = $request->ganjilizin;
            $data->ganjilalpha  = $request->ganjilalpha;
        }else{
            $data               = Absen::find($request->id);
            $data->genapsakit  = $request->genapsakit;
            $data->genapizin   = $request->genapizin;
            $data->genapalpha  = $request->genapalpha;
        }
        if($data->save()){
            $response = response()->json([
                'status' => 'success',
                'message' => 'Data has been saved'
            ]);
        }
        return $response;
    }

    public function downloadPDF($year ,$id, $semester) {
        if($semester == "ganjil"){
            $detail = Raport::select('*',
            DB::raw('(ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 AS pengetahuanrata'),
            DB::raw('(ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 AS keterampilanrata'),
            DB::raw('(ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 AS sikaprata'),
            DB::raw('(ganjilpts1+ganjilpts2+ganjilpts3)/3 AS ptsrata'),
            DB::raw('CASE
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=75 THEN "D"
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <75 AND (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=83 THEN "C"
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <84 AND (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=92 THEN "B"
            WHEN (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <93 AND (ganjilpengetahuankd1+ganjilpengetahuankd2+ganjilpengetahuankd3+ganjilpengetahuankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS pengetahuanpredikat
            '),
            DB::raw('CASE
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=75 THEN "D"
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <75 AND (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=83 THEN "C"
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <84 AND (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=92 THEN "B"
            WHEN (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <93 AND (ganjilketerampilankd1+ganjilketerampilankd2+ganjilketerampilankd3+ganjilketerampilankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS keterampilanpredikat
            '),
            DB::raw('CASE
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=75 THEN "D"
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <75 AND (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=83 THEN "C"
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <84 AND (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=92 THEN "B"
            WHEN (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <93 AND (ganjilsikapkd1+ganjilsikapkd2+ganjilsikapkd3+ganjilsikapkd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS sikappredikat
            '),
            DB::raw('CASE
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <=75 THEN "D"
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <75 AND (ganjilpts1+ganjilpts2+ganjilpts3)/4 <=83 THEN "C"
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <84 AND (ganjilpts1+ganjilpts2+ganjilpts3)/4 <=92 THEN "B"
            WHEN (ganjilpts1+ganjilpts2+ganjilpts3)/3 <93 AND (ganjilpts1+ganjilpts2+ganjilpts3)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS ptspredikat
            '),
            )->with(['matapelajaran:id_matapelajaran,mata_pelajaran'])->where('id_users', $id)->where('tahun', $year)->get();

        }else if($semester == "genap"){
            $detail = Raport::select('*',
            DB::raw('(genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 AS pengetahuanrata'),
            DB::raw('(genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 AS keterampilanrata'),
            DB::raw('(genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 AS sikaprata'),
            DB::raw('(genappts1+genappts2+genappts3)/3 AS ptsrata'),
            DB::raw('CASE
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=75 THEN "D"
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <75 AND (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=83 THEN "C"
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <84 AND (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=92 THEN "B"
            WHEN (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <93 AND (genappengetahuankd1+genappengetahuankd2+genappengetahuankd3+genappengetahuankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS pengetahuanpredikat
            '),
            DB::raw('CASE
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=75 THEN "D"
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <75 AND (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=83 THEN "C"
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <84 AND (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=92 THEN "B"
            WHEN (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <93 AND (genapketerampilankd1+genapketerampilankd2+genapketerampilankd3+genapketerampilankd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS keterampilanpredikat
            '),
            DB::raw('CASE
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=75 THEN "D"
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <75 AND (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=83 THEN "C"
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <84 AND (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=92 THEN "B"
            WHEN (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <93 AND (genapsikapkd1+genapsikapkd2+genapsikapkd3+genapsikapkd4)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS sikappredikat
            '),
            DB::raw('CASE
            WHEN (genappts1+genappts2+genappts3)/3 <=75 THEN "D"
            WHEN (genappts1+genappts2+genappts3)/3 <75 AND (genappts1+genappts2+genappts3)/4 <=83 THEN "C"
            WHEN (genappts1+genappts2+genappts3)/3 <84 AND (genappts1+genappts2+genappts3)/4 <=92 THEN "B"
            WHEN (genappts1+genappts2+genappts3)/3 <93 AND (genappts1+genappts2+genappts3)/4 <=100 THEN "A"
            ELSE "NULL"
            END AS ptspredikat
            '),
            )->with(['matapelajaran:id_matapelajaran,mata_pelajaran'])->where('id_users', $id)->where('tahun', $year)->get();

        }

        $data = User::with(['raport' => function($q) use($year) {
            $q->where('raport.tahun', $year);
        }, 'raport.matapelajaran', 'raport.kelas'],)->where('id', $id)
        ->first();

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('raport.pdf', compact('data', 'detail', 'year', 'semester'));
        return $pdf->setPaper('a4', 'landscape')->download('raport.pdf');
    }


}
