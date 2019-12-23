<!DOCTYPE html>
<style>
table, th, td {
  border: 1px solid black;
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
    <table class="table table-striped- table-bordered table-hover table-checkable">
        <thead>
            <tr>
                <th colspan="1">Nama Siswa: </th>
                <th colspan="3">{{$data->name}}</th>
                <th colspan="3">Kelas: {{$data->raport[0]->kelas->nama_kelas}}</th>
                <th colspan="3">Tahun:{{$year}}</th>
                <th colspan="3">Semester: {{$semester}}/th>
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
                <td>{{$item->pengetahuankd1}}</td>
                <td>{{$item->pengetahuankd2}}</td>
                <td>{{$item->pengetahuankd3}}</td>
                <td>{{$item->pengetahuankd4}}</td>
                <td>{{$item->pengetahuanrata}}</td>
                <td>{{$item->pengetahuanpredikat}}</td>
                <td>{{$item->keterampilankd1}}</td>
                <td>{{$item->keterampilankd2}}</td>
                <td>{{$item->keterampilankd3}}</td>
                <td>{{$item->keterampilankd4}}</td>
                <td>{{$item->keterampilanrata}}</td>
                <td>{{$item->sikapkd1}}</td>
                <td>{{$item->sikapkd2}}</td>
                <td>{{$item->sikapkd3}}</td>
                <td>{{$item->sikapkd4}}</td>
                <td>{{$item->sikaprata}}</td>
                <td>{{$item->sikappredikat}}</td>
                <td>{{$item->pts1}}</td>
                <td>{{$item->pts2}}</td>
                <td>{{$item->pts3}}</td>
                <td>{{$item->pts3}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </body>
</html>
