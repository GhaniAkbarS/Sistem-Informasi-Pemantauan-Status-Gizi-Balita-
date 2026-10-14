<x-app-layout>
<div class="main-content">

<section class="sip-hero"><div><h1>Ringkasan pemantauan gizi</h1><p>Pantau tumbuh kembang balita dari satu halaman.</p></div><span class="sip-posyandu">{{ session('posyandu_nama','Posyandu') }}</span></section>
@if($perluRujukan > 0)<div class="sip-alert" role="alert"><strong>Hasil pemeriksaan yang perlu ditinjau</strong><p>{{ $perluRujukan }} catatan pemeriksaan berstatus di luar kategori normal. Kader dapat meninjau hasil bersama tenaga kesehatan.</p></div>@endif
<section class="sip-stats" aria-label="Ringkasan statistik">
<div class="sip-stat"><div class="sip-stat-label">Total Balita Terdaftar</div><div class="sip-stat-value">{{ $totalBalita }}</div><div class="sip-stat-note">Balita aktif di sistem</div></div>
<div class="sip-stat"><div class="sip-stat-label">Pemeriksaan Bulan Ini</div><div class="sip-stat-value">{{ $pemeriksaanBulanIni }}</div><div class="sip-stat-note">Pemeriksaan tercatat</div></div>
<div class="sip-stat"><div class="sip-stat-label">Status Gizi Normal</div><div class="sip-stat-value">{{ $giziNormal }}</div><div class="sip-stat-note">Berdasarkan pemeriksaan</div></div>
<div class="sip-stat"><div class="sip-stat-label">Perlu Ditinjau</div><div class="sip-stat-value">{{ $perluRujukan }}</div><div class="sip-stat-note">Jumlah catatan, bukan jumlah anak</div></div>
</section>
<section class="sip-grid"><div class="sip-card"><h2>Tren Pemeriksaan 6 Bulan Terakhir</h2><div id="sip-trend" class="sip-chart" role="img" aria-label="Grafik tren pemeriksaan enam bulan"></div></div>
<div class="sip-card"><h2>Distribusi Status Gizi</h2>
@foreach([['Gizi Normal',$distNormal,'#2c8066'],['Gizi Kurang',$distKurang,'#d19534'],['Stunting',$distStunting,'#bb3653'],['Gizi Lebih',$distLebih,'#c2185b']] as [$label,$count,$color])
<div class="sip-dist-row"><span>{{ $label }}</span><div class="sip-track"><div class="sip-fill" style="width:{{ $totalDist ? round($count / $totalDist * 100) : 0 }}%;background:{{ $color }}"></div></div><strong>{{ $totalDist ? round($count / $totalDist * 100) : 0 }}%</strong></div>
@endforeach
</div></section>
<section class="sip-card"><h2>Pemeriksaan Terbaru</h2>
<p class="text-secondary small">Z-score berasal dari tabel proyek saat ini dan belum diverifikasi terhadap metode LMS WHO. Tinjau hasil bersama tenaga kesehatan.</p>
<div class="table-responsive"><table class="table table-vcenter sip-table"><thead><tr><th>Nama Balita</th><th>Umur</th><th>Tanggal Periksa</th><th>BB / TB</th><th>Z-score</th><th>Status Gizi</th><th>Aksi</th></tr></thead><tbody>
@forelse($recentExaminations as $periksa)
@php $status=$periksa->status_gizi; $badge=in_array($status,['Stunting','Sangat Pendek'])?'sip-badge-bad':($status==='Gizi Kurang'?'sip-badge-warn':(in_array($status,['Gizi Baik','Gizi Normal'])?'sip-badge-good':'sip-badge-other')); @endphp
<tr><td><strong>{{ $periksa->balita->nama ?? 'N/A' }}</strong></td><td>{{ $periksa->umur_bulan }} bulan</td><td>{{ \Carbon\Carbon::parse($periksa->tanggal_periksa)->translatedFormat('d M Y') }}</td><td>{{ $periksa->berat_badan }} kg / {{ $periksa->tinggi_badan }} cm</td><td>BB/U: {{ $periksa->z_bbu !== null ? number_format($periksa->z_bbu,2) : '—' }}<br>TB/U: {{ $periksa->z_tbu !== null ? number_format($periksa->z_tbu,2) : '—' }}<br>BB/PB: {{ $periksa->z_bbpb !== null ? number_format($periksa->z_bbpb,2) : '—' }}</td><td><span class="sip-badge {{ $badge }}">{{ \App\Services\StatusGizi::label($status) }}</span></td><td><a href="{{ route('periksa.edit',$periksa->id) }}">Detail</a></td></tr>
@empty<tr><td colspan="7" class="text-center text-secondary py-4">Belum ada pemeriksaan terbaru</td></tr>@endforelse
</tbody></table></div></section>

</div>
@push('after-script')
<script>
document.addEventListener('DOMContentLoaded',function(){
  const el=document.getElementById('sip-trend');if(!el||!window.ApexCharts)return;
  new ApexCharts(el,{chart:{type:'area',height:235,toolbar:{show:false},fontFamily:'inherit'},
    series:[{name:'Gizi Normal',data:@json($trenDataNormal)},{name:'Stunting',data:@json($trenDataStunting)}],
    xaxis:{categories:@json($trenLabels)},colors:['#2c8066','#bb3653'],dataLabels:{enabled:false},
    stroke:{curve:'smooth',width:2},fill:{type:'solid',opacity:.12},grid:{borderColor:'#efdee6'},
    legend:{position:'top',horizontalAlign:'left'}}).render();
});
</script>
@endpush
</x-app-layout>
