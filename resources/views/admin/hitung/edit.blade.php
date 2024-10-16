<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title}} | AHP TOPSIS - Dolphin</title> 
  <link href="{{asset('assets/assets/pdf/style.css')}}" rel="stylesheet">
</head>
<body>
  <div class="py-4">
      <div class="w-full align-top">
        <div style="text-align: center;">
          <img style="width: 110px; height: 120px;" src="{{asset('assets/dolphin.png')}}" class="h-10">
        </div>
      </div>
      <div class="bg-slate-100 px-14 py-6 text-sm" style="display: flex; justify-content: space-between;">
        <div class="text-sm text-neutral-600" style="display: flex; text-align: center">
          <strong> Rekapan Data Perankingan</strong>
        </div>
        <br/>
        <div class="text-sm text-neutral-600" style="display: flex; justify-content: space-between;">
            <p class="font-bold">Penilaian ini dilakukan pada :</p>
             <p>Tahun : {{ $periodes->tahun }}</p>
              <p>Periode : {{ $periodes->nama }}</p>
              <p>Status : 
                <?php if ($periodes->status == "Tidak Konsisten"): ?>
                  <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span>
                <?php else: ?>
                  <span style="color: #1AAC06; font-weight: 800;">Konsisten</span>
                <?php endif ?>
              </p>
        </div>           
      </div>
      <div class="px-14 py-10 text-sm text-neutral-700">
        <table class="w-full border-collapse border-spacing-0">
          <thead class="border-b-2 border-main pb-3 pl-3 text-center font-bold text-main">
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Total</th>
              <th>Ranking</th> 
            </tr>
          </thead>
          <tbody>
            @forelse($data as $val)
            <tr>
                <td class="border-b py-3 pl-3" style="text-align: center;">{{$loop->iteration}}</td>
                <td class="border-b py-3 pl-2">{{$val->kode}}</td>
                <td class="border-b py-3 pl-2">{{ucwords($val->nama)}}</td>
                <td class="border-b py-3 pl-2 text-right">{{$val->alrank_sum_total}}</td>
                <td class="border-b py-3 pl-2 text-center">{{$loop->iteration}}</td> 
            </tr>
            @empty
            <tr>
                <td colspan="15" class="text-center">Tidak Ada Data</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="px-14 py-10 text-sm text-neutral-700">
          <table class="w-full border-collapse border-spacing-0">
              <tbody>
                  <tr>
                      <td class="w-full"></td>
                      <td>
                          <table class="w-full border-collapse border-spacing-0">
                            <tbody>
                              <tr>
                                <td class="bg-slate p-3">
                                  <div class="whitespace-nowrap">Jumlah Karyawan:</div>
                                </td>
                                <td class="p-3 text-right">
                                  <div class="whitespace-nowrap font-bold text-main">{{$jua}}</div>
                                </td>
                              </tr>
                               
                          </tbody>
                  </table>
                  </tr>
              </tbody>
          </table>
      </div>
      <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
        Dolphin Laundry
        <span class="text-slate-300 px-2">|</span>
        info@company.com
        <span class="text-slate-300 px-2">|</span>
        +1-202-555-0106
      </footer>
  </div>
</body> 
</html>