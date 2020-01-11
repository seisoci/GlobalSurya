<!DOCTYPE html>
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}

<style>

h5{
    font-size: 16px;
    text-align: center;
    font-weight: bold;
}
img{
    position: absolute;
    margin-top: 4px;
    height: 75px;
    width: 100px;
}
.left{
  margin-top:10px;
  float: left;
  display: inline-block;
  width: 20%;
}
.right{
  margin-top:10px;
  float: right;
  display: inline-block;
  width: 80%;
  border: 0px solid white !important;

}
.right table, th, td{
    border: 1px solid black !important;
    text-align: center !important;
    border-collapse: none !important;

}
h5{
    margin-top: 0px;
    margin-bottom: 0.50em;
    padding-top: 0px;
    padding-bottom: 0px;
}
.ttdkiri{
  margin-top:10px;
  float: left;
  display: inline-block;
  width: 30%;
  border: 0px solid white !important;

}
.ttdkiri table, th, td{
    border: 0px solid black !important;
    text-align: left !important;
    border-collapse: none !important;

}
.ttdtengah{
  margin-top:10px;
  float: right;
  display: inline-block;
  width: 70%;
  border: 0px solid white !important;

}
.ttdtengah table, th, td{
    border: 0px solid black !important;
    text-align: left !important;
    border-collapse: none !important;

}
.ttdkanan{
  margin-top:10px;
  float: right;
  display: inline-block;
  width: 30%;
}
.ttdkanan table, th, td{
    border: 0px solid black !important;
    text-align: left !important;
    border-collapse: none !important;

}
table {
  border: 1px solid black;
}
td{
    border: 1px solid black !important;
}
.table th{
    border: 1px solid black !important;
}
table {
  border-collapse: collapse;
  font-size: 14px;
  text-align: center;
}
</style>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="header">
        <img src="{{asset('assets/media/bg/logo.png')}}" alt="Global Surya">
        <h5>LAPORAN HASIL CAPAIAN PESERTA DIDIK TENGAH SEMESTER</h5>
        <h5>SMA ISLAM GLOBAL SURYA BANDAR LAMPUNG</h5>
        <h5>TAHUN PELAJARAN {{$year}}</h5>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th colspan="1">Nama Siswa: </th>
                <th colspan="3">{{$data->name}}</th>
                <th colspan="3">Kelas: {{$data->raport[0]->kelas->nama_kelas}}</th>
                <th colspan="3">Tahun:{{$year}}</th>
                <th colspan="3">Semester: {{$semester}}</th>
                <th colspan="10"></th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4" class="text-center">Pengetahuan</th>
                <th rowspan="2" class="text-center">Rata-rata</th>
                <th rowspan="2" class="text-center">Predikat</th>
                <th colspan="4" class="text-center">Keterampilan</th>
                <th rowspan="2" class="text-center">Rata-rata</th>
                <th rowspan="2" class="text-center">Predikat</th>
                <th colspan="4" class="text-center">Sikap</th>
                <th rowspan="2" class="text-center">Rata-rata</th>
                <th rowspan="2" class="text-center">Predikat</th>
                <th colspan="3" class="text-center">PTS</th>
                <th rowspan="2" class="text-center">Predikat</th>
            </tr>
            <tr>
                <th class="text-center">Mata Pelajaran</th>
                <th class="text-center">KD1</th>
                <th class="text-center">KD2</th>
                <th class="text-center">KD3</th>
                <th class="text-center">KD4</th>
                <th class="text-center">KD1</th>
                <th class="text-center">KD2</th>
                <th class="text-center">KD3</th>
                <th class="text-center">KD4</th>
                <th class="text-center">KD1</th>
                <th class="text-center">KD2</th>
                <th class="text-center">KD3</th>
                <th class="text-center">KD4</th>
                <th class="text-center">K</th>
                <th class="text-center">P</th>
                <th class="text-center">A</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
            <tr>
                <td>{{$item->matapelajaran['mata_pelajaran']}}</td>
                <td>{{$item->genappengetahuankd1}}</td>
                <td>{{$item->genappengetahuankd2}}</td>
                <td>{{$item->genappengetahuankd3}}</td>
                <td>{{$item->genappengetahuankd4}}</td>
                <td>{{$item->pengetahuanrata}}</td>
                <td>{{$item->pengetahuanpredikat}}</td>
                <td>{{$item->genapketerampilankd1}}</td>
                <td>{{$item->genapketerampilankd2}}</td>
                <td>{{$item->genapketerampilankd3}}</td>
                <td>{{$item->genapketerampilankd4}}</td>
                <td>{{$item->keterampilanrata}}</td>
                <td>{{$item->keterampilanpredikat}}</td>
                <td>{{$item->genapsikapkd1}}</td>
                <td>{{$item->genapsikapkd2}}</td>
                <td>{{$item->genapsikapkd3}}</td>
                <td>{{$item->genapsikapkd4}}</td>
                <td>{{$item->sikaprata}}</td>
                <td>{{$item->sikappredikat}}</td>
                <td>{{$item->genappts1}}</td>
                <td>{{$item->genappts2}}</td>
                <td>{{$item->genappts3}}</td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <div class="left">
            <table style="padding:4px;">
                <thead>
                    <tr>
                        <th>Absensi</th>
                        <th>Hari</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sakit: </td>
                        <td>{{$data->absen->genapsakit}}</td>
                    </tr>
                    <tr>
                        <td>Izin: </td>
                        <td>{{$data->absen->genapizin}}</td>
                    </tr>
                    <tr>
                        <td>Alpa: </td>
                        <td>{{$data->absen->genapalpha}}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="right">
            <table>
                <thead>
                    <tr>
                        <th colspan="4">Predikat</th>
                    </tr>
                    <tr>
                        <th>D</th>
                        <th>C</th>
                        <th>B</th>
                        <th>A</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&lt;= 75</td>
                        <td>75  N &lt;= 83</td>
                        <td>84 &lt; N &lt;= 92</td>
                        <td>93 &lt; N &lt;= 100</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <p style="page-break-before: always">
    <div style="clear: both;">
        <div class="ttdkiri">
            <table>
                <thead>
                    <tr>
                        <th>Orang Tua  Wali Siswa</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="ttdtengah">
            <table>
                <thead>
                    <tr>
                        <th>Mengetahui,</th>
                    </tr>
                    <tr>
                        <th>Kepala SMA ISLAM Global Surya</th>
                    </tr>
                    <tr>
                        <th style="padding-top:50px">Drs. H. BANJIR SIHITE,M.Pd</th>
                    </tr>
                    <tr>
                        <th>NIP: 19620525 199102 2 001</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="ttdkanan">
            <table>
                <thead>
                    <tr>
                        <th>Wali Kelas,</th>
                    </tr>
                    <tr>
                        <th style="padding-top:80px">@foreach($detail as $item)
                            @if($loop->first)
                                {{$item->guru->name}}
                            @endif
                        @endforeach
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
  </body>
</html>
