
<x-app-layout>
    
    <div class="main-content">
        <!-- Basic Card Example -->
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Data Pemeriksaan</h4>
                    <p class="m-0" style="opacity: 0.8;">{{ session('posyandu_nama') }}</p>
                </div>
                <div class="text-right px-3">
                    <p class="m-0"><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p class="m-0" style="opacity: 0.8;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <div class="row row-cards">
                <div class="col-12">
                    <form class="card" action="{{ route('periksa.store') }}" method="post">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Form Data Pemeriksaan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <!-- Baris 1: Nama & Tanggal -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Anak</label>
                                        <!-- Placeholder select, nanti bisa diisi data dari controller -->
                                        <select class="form-select" name="balita_id">
                                            <option value="">Pilih Nama Anak</option>
                                            @foreach ($balitas as $balita)
                                                <option value="{{ $balita->id }}">{{ $balita->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @include('pages.periksa.riwayat_anak')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pemeriksaan</label>
                                        <input type="date" class="form-control" name="tgl_periksa" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <!-- Baris 2: Data Fisik -->
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Berat Badan (kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="berat_badan" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" step="0.01" class="form-control" name="tinggi_badan" placeholder="0.00">
                                    </div>
                                </div>
                                    
                                <!-- Baris 3: Catatan -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Catatan Tambahan</label>
                                        <textarea class="form-control" name="catatan" rows="3" placeholder="Tulis catatan hasil pemeriksaan jika ada..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('periksa.index') }}" class="btn btn-link link-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Simpan Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('after-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // === WHO helper & data (sama dengan halaman detail ortu) ===
    function whoLines(pairs) {
        return {
            neg3: pairs.map(([m,s]) => +((m-3*s).toFixed(2))),
            neg2: pairs.map(([m,s]) => +((m-2*s).toFixed(2))),
            med:  pairs.map(([m,s]) => +(m.toFixed(2))),
            pos2: pairs.map(([m,s]) => +((m+2*s).toFixed(2))),
            pos3: pairs.map(([m,s]) => +((m+3*s).toFixed(2))),
        };
    }
    const rawBBU = {
        L: [[3.3,0.46],[4.5,0.55],[5.6,0.62],[6.4,0.67],[7.0,0.72],[7.5,0.76],[7.9,0.79],[8.3,0.82],[8.6,0.85],[8.9,0.87],[9.2,0.90],[9.4,0.92],[9.6,0.94],[9.9,0.97],[10.1,0.99],[10.3,1.01],[10.5,1.03],[10.7,1.05],[10.9,1.07],[11.1,1.09],[11.3,1.11],[11.5,1.13],[11.8,1.15],[12.0,1.17],[12.2,1.19],[12.4,1.21],[12.5,1.23],[12.7,1.25],[12.9,1.27],[13.1,1.29],[13.3,1.31],[13.5,1.33],[13.7,1.35],[13.8,1.37],[14.0,1.39],[14.2,1.41],[14.3,1.43],[14.5,1.45],[14.7,1.47],[14.8,1.49],[15.0,1.51],[15.2,1.53],[15.3,1.55],[15.5,1.57],[15.7,1.59],[15.8,1.61],[16.0,1.63],[16.2,1.65],[16.3,1.67],[16.5,1.69],[16.7,1.71],[16.9,1.73],[17.0,1.75],[17.2,1.77],[17.4,1.79],[17.5,1.81],[17.7,1.83],[17.9,1.85],[18.0,1.87],[18.2,1.89],[18.3,1.91]],
        P: [[3.2,0.44],[4.2,0.52],[5.1,0.58],[5.8,0.63],[6.4,0.67],[6.9,0.71],[7.3,0.75],[7.6,0.78],[7.9,0.81],[8.2,0.84],[8.5,0.87],[8.7,0.89],[8.9,0.92],[9.2,0.94],[9.4,0.97],[9.6,0.99],[9.8,1.01],[10.0,1.03],[10.2,1.05],[10.4,1.08],[10.6,1.10],[10.9,1.12],[11.1,1.14],[11.3,1.16],[11.5,1.18],[11.7,1.20],[11.9,1.22],[12.1,1.25],[12.3,1.27],[12.5,1.29],[12.7,1.31],[12.9,1.33],[13.1,1.36],[13.3,1.38],[13.5,1.40],[13.7,1.42],[13.9,1.45],[14.0,1.47],[14.2,1.49],[14.4,1.52],[14.6,1.54],[14.8,1.56],[15.0,1.59],[15.2,1.61],[15.3,1.63],[15.5,1.66],[15.7,1.68],[15.9,1.71],[16.1,1.73],[16.3,1.76],[16.5,1.78],[16.7,1.81],[16.9,1.83],[17.1,1.86],[17.3,1.88],[17.5,1.91],[17.7,1.93],[17.9,1.96],[18.1,1.98],[18.3,2.01],[18.5,2.03]],
    };
    const rawTBU = {
        L: [[49.9,1.89],[54.7,1.99],[58.4,2.05],[61.4,2.09],[63.9,2.13],[65.9,2.18],[67.6,2.24],[69.2,2.30],[70.6,2.36],[72.0,2.42],[73.3,2.49],[74.5,2.55],[75.7,2.62],[76.9,2.68],[78.0,2.74],[79.1,2.80],[80.2,2.86],[81.2,2.92],[82.3,2.98],[83.2,3.04],[84.2,3.10],[85.1,3.16],[86.0,3.22],[86.9,3.28],[87.8,3.34],[88.7,3.40],[89.6,3.45],[90.4,3.51],[91.2,3.57],[92.1,3.63],[92.9,3.69],[93.7,3.74],[94.4,3.80],[95.2,3.86],[96.0,3.92],[96.7,3.97],[97.4,4.03],[98.2,4.08],[98.9,4.14],[99.6,4.20],[100.4,4.25],[101.1,4.31],[101.8,4.36],[102.5,4.42],[103.2,4.47],[103.9,4.53],[104.6,4.58],[105.3,4.64],[106.0,4.69],[106.7,4.74],[107.4,4.80],[108.0,4.85],[108.7,4.90],[109.4,4.96],[110.0,5.01],[110.7,5.06],[111.3,5.11],[112.0,5.17],[112.6,5.22],[113.3,5.27],[113.9,5.32]],
        P: [[49.1,1.86],[53.7,1.96],[57.1,2.01],[59.8,2.06],[62.1,2.11],[64.0,2.17],[65.7,2.23],[67.3,2.29],[68.7,2.35],[70.1,2.41],[71.5,2.47],[72.8,2.53],[74.0,2.59],[75.2,2.65],[76.4,2.71],[77.5,2.78],[78.6,2.84],[79.7,2.90],[80.7,2.96],[81.7,3.02],[82.7,3.08],[83.7,3.14],[84.6,3.20],[85.5,3.26],[86.4,3.32],[87.3,3.38],[88.2,3.43],[89.1,3.49],[89.9,3.55],[90.8,3.61],[91.6,3.67],[92.4,3.72],[93.2,3.78],[94.0,3.84],[94.8,3.89],[95.6,3.95],[96.4,4.01],[97.2,4.06],[97.9,4.12],[98.7,4.17],[99.4,4.23],[100.2,4.28],[100.9,4.34],[101.6,4.39],[102.3,4.45],[103.0,4.50],[103.7,4.55],[104.4,4.61],[105.1,4.66],[105.8,4.71],[106.5,4.77],[107.2,4.82],[107.8,4.87],[108.5,4.92],[109.2,4.97],[109.8,5.03],[110.5,5.08],[111.1,5.13],[111.8,5.18],[112.4,5.23],[113.0,5.28]],
    };
    const rawBBPB = {
        L: [[2.4,0.31],[2.6,0.33],[2.8,0.36],[3.0,0.39],[3.3,0.41],[3.5,0.44],[3.8,0.46],[4.0,0.48],[4.3,0.50],[4.6,0.52],[4.9,0.54],[5.2,0.56],[5.5,0.58],[5.8,0.60],[6.0,0.62],[6.3,0.64],[6.6,0.66],[6.8,0.68],[7.1,0.70],[7.3,0.72],[7.5,0.74],[7.8,0.76],[8.0,0.77],[8.2,0.79],[8.4,0.81],[8.6,0.83],[8.9,0.84],[9.1,0.86],[9.3,0.88],[9.5,0.90],[9.7,0.92],[9.9,0.93],[10.2,0.95],[10.4,0.97],[10.6,0.99],[10.8,1.01],[11.0,1.03],[11.3,1.05],[11.5,1.07],[11.7,1.09],[11.9,1.11],[12.2,1.13],[12.4,1.15],[12.7,1.17],[12.9,1.19],[13.2,1.21],[13.4,1.23],[13.7,1.26],[13.9,1.28],[14.2,1.30],[14.4,1.32],[14.7,1.35],[15.0,1.37],[15.2,1.39],[15.5,1.42],[15.7,1.44],[16.0,1.46],[16.3,1.48],[16.6,1.51],[16.8,1.53],[17.1,1.55],[17.4,1.58],[17.7,1.60],[18.0,1.62],[18.3,1.65],[18.5,1.67]],
        P: [[2.5,0.33],[2.6,0.35],[2.8,0.38],[3.0,0.40],[3.2,0.43],[3.4,0.45],[3.7,0.47],[3.9,0.50],[4.2,0.52],[4.5,0.54],[4.7,0.56],[5.0,0.58],[5.3,0.60],[5.6,0.62],[5.9,0.64],[6.1,0.66],[6.4,0.68],[6.6,0.70],[6.9,0.71],[7.1,0.73],[7.3,0.75],[7.5,0.77],[7.7,0.79],[7.9,0.81],[8.1,0.83],[8.3,0.84],[8.5,0.86],[8.7,0.88],[8.9,0.90],[9.2,0.92],[9.4,0.94],[9.6,0.96],[9.8,0.98],[10.0,1.00],[10.3,1.02],[10.5,1.04],[10.7,1.06],[10.9,1.08],[11.2,1.10],[11.4,1.12],[11.6,1.14],[11.8,1.16],[12.1,1.18],[12.3,1.20],[12.6,1.22],[12.8,1.24],[13.1,1.27],[13.3,1.29],[13.6,1.31],[13.8,1.33],[14.1,1.36],[14.4,1.38],[14.6,1.40],[14.9,1.43],[15.2,1.45],[15.4,1.47],[15.7,1.50],[16.0,1.52],[16.2,1.54],[16.5,1.57],[16.8,1.59],[17.1,1.62],[17.3,1.64],[17.6,1.67],[17.9,1.69],[18.2,1.72]],
    };

    const monthLabels = Array.from({length: 61}, (_, i) => i);
    const pbLabels    = Array.from({length: 66}, (_, i) => i + 45);

    // Simpan instance chart agar bisa di-destroy saat ganti anak
    let kaderCharts = { bbu: null, tbu: null, bbpb: null };
    // Simpan data WHO saat ini untuk fungsi filter
    let kaderWho = { bbu: null, tbu: null, bbpb: null };
    let kaderChild = { bbu: null, tbu: null, bbpb: null };

    function buildKaderWhoChart(ctxId, whoData, childData, labels, childLabel, childColor, xTitle, yTitle, chartType) {
        let datasets;
        if (chartType === 'bbu') {
            datasets = [
                { label: '< -3 SD (Berat Badan Sangat Kurang)',          data: whoData.neg3, borderColor:'rgba(220,53,69,0.75)',  borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '-3 SD s.d. < -2 SD (Berat Badan Kurang)',      data: whoData.neg2, borderColor:'rgba(255,140,0,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '-2 SD s.d. +1 SD (Berat Badan Normal)',        data: whoData.med,  borderColor:'rgba(40,167,69,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '> +1 SD (Risiko Berat Badan Lebih)',           data: whoData.pos2, borderColor:'rgba(255,140,0,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '',                                               data: whoData.pos3, borderColor:'rgba(220,53,69,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: childLabel, data: childData, borderColor:childColor, borderWidth:2.5, pointRadius:5, pointHoverRadius:8, fill:false, spanGaps:false, tension:0 },
            ];
        } else if (chartType === 'tbu') {
            datasets = [
                { label: '< -3 SD (Sangat Pendek / Severely Stunted)',   data: whoData.neg3, borderColor:'rgba(220,53,69,0.75)',  borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '-3 SD s.d. < -2 SD (Pendek / Stunted)',        data: whoData.neg2, borderColor:'rgba(255,140,0,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '-2 SD s.d. +3 SD (Normal)',                    data: whoData.med,  borderColor:'rgba(40,167,69,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '',                                               data: whoData.pos2, borderColor:'rgba(255,140,0,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '> +3 SD (Tinggi)',                              data: whoData.pos3, borderColor:'rgba(220,53,69,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: childLabel, data: childData, borderColor:childColor, borderWidth:2.5, pointRadius:5, pointHoverRadius:8, fill:false, spanGaps:false, tension:0 },
            ];
        } else {
            // BB/PB - tetap seperti semula
            datasets = [
                { label: '< -3 SD (Gizi Buruk)',                          data: whoData.neg3, borderColor:'rgba(220,53,69,0.75)',  borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '-3 SD s.d. < -2 SD (Gizi Kurang)',              data: whoData.neg2, borderColor:'rgba(255,140,0,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '-2 SD s.d. +1 SD (Gizi Baik)',                  data: whoData.med,  borderColor:'rgba(40,167,69,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '+1 SD s.d. +2 SD (Berisiko Gizi Lebih)',        data: whoData.pos2, borderColor:'rgba(255,140,0,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: '> +3 SD (Obesitas)',                             data: whoData.pos3, borderColor:'rgba(220,53,69,0.75)', borderWidth:1.5, pointRadius:0, fill:false, tension:0.3 },
                { label: childLabel, data: childData, borderColor:childColor, borderWidth:2.5, pointRadius:5, pointHoverRadius:8, fill:false, spanGaps:false, tension:0 },
            ];
        }
        return new Chart(document.getElementById(ctxId).getContext('2d'), {
            type: 'line',
            data: { labels, datasets },
            options: {
                responsive: true,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font:{size:10}, padding:8, usePointStyle:true },
                        filter: function(item) { return item.text !== ''; }
                    }
                },
                scales: {
                    x: { title: { display:true, text:xTitle }, ticks:{ maxTicksLimit:20 } },
                    y: { title: { display:true, text:yTitle }, beginAtZero:false },
                },
            },
        });
    }

    function kaderApplyFilter() {
        const min  = parseInt(document.getElementById('kaderFilterMin').value);
        const max  = parseInt(document.getElementById('kaderFilterMax').value);
        const fMin = isNaN(min) ? 0  : Math.max(0, min);
        const fMax = isNaN(max) ? 60 : Math.min(60, max);
        kaderUpdateChart(kaderCharts.bbu, kaderWho.bbu, kaderChild.bbu, monthLabels, fMin, fMax);
        kaderUpdateChart(kaderCharts.tbu, kaderWho.tbu, kaderChild.tbu, monthLabels, fMin, fMax);
    }
    function kaderResetFilter() {
        document.getElementById('kaderFilterMin').value = '';
        document.getElementById('kaderFilterMax').value = '';
        kaderUpdateChart(kaderCharts.bbu, kaderWho.bbu, kaderChild.bbu, monthLabels, 0, 60);
        kaderUpdateChart(kaderCharts.tbu, kaderWho.tbu, kaderChild.tbu, monthLabels, 0, 60);
    }
    function kaderUpdateChart(chart, who, child, allLabels, min, max) {
        if (!chart) return;
        chart.data.labels           = allLabels.slice(min, max + 1);
        chart.data.datasets[0].data = who.neg3.slice(min, max + 1);
        chart.data.datasets[1].data = who.neg2.slice(min, max + 1);
        chart.data.datasets[2].data = who.med.slice(min, max + 1);
        chart.data.datasets[3].data = who.pos2.slice(min, max + 1);
        chart.data.datasets[4].data = who.pos3.slice(min, max + 1);
        chart.data.datasets[5].data = child.slice(min, max + 1);
        chart.update();
    }

    document.querySelector('select[name="balita_id"]').addEventListener('change', function () {
        const balitaId = this.value;
        const container = document.getElementById('riwayat-container');

        if (!balitaId) {
            container.style.display = 'none';
            return;
        }

        fetch(`/periksa/riwayat-anak/${balitaId}`)
            .then(res => res.json())
            .then(data => {
                const fmt = (tgl) => tgl
                    ? new Date(tgl).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
                    : '-';

                const statusBadge = (status) => {
                    const color = status === 'Gizi Baik' ? 'success'
                        : (status === 'Stunting' || status === 'Gizi Buruk') ? 'danger'
                        : 'warning';
                    return `<span class="badge bg-${color}">${status ?? '-'}</span>`;
                };

                // Render Pemeriksaan
                document.getElementById('badge-periksa').textContent = data.periksa.length;
                document.getElementById('list-periksa').innerHTML = data.periksa.length
                    ? data.periksa.map(p => `
                        <tr>
                            <td>${fmt(p.tanggal)}</td>
                            <td>${p.berat_badan ?? '-'}</td>
                            <td>${p.tinggi_badan ?? '-'}</td>
                            <td>${statusBadge(p.status_gizi)}</td>
                        </tr>`).join('')
                    : `<tr><td colspan="4" class="text-center text-muted py-3">Belum ada data pemeriksaan</td></tr>`;

                // Render Imunisasi
                document.getElementById('badge-imunisasi').textContent = data.imunisasi.length;
                document.getElementById('list-imunisasi').innerHTML = data.imunisasi.length
                    ? data.imunisasi.map(i => `
                        <tr>
                            <td>${fmt(i.tanggal)}</td>
                            <td>${i.nama_vaksin ?? '-'}</td>
                            <td>${i.keterangan ?? '-'}</td>
                        </tr>`).join('')
                    : `<tr><td colspan="3" class="text-center text-muted py-3">Belum ada data imunisasi</td></tr>`;

                // Render Vitamin A
                document.getElementById('badge-vitamin').textContent = data.vitamin_a.length;
                document.getElementById('list-vitamin').innerHTML = data.vitamin_a.length
                    ? data.vitamin_a.map(v => `
                        <tr>
                            <td>${fmt(v.tanggal)}</td>
                            <td>${v.jenis_kapsul ? 'Kapsul ' + v.jenis_kapsul : '-'}</td>
                        </tr>`).join('')
                    : `<tr><td colspan="2" class="text-center text-muted py-3">Belum ada data vitamin A</td></tr>`;

                container.style.display = 'block';

                // === Bangun Grafik WHO ===
                const jk = data.jk || 'L';
                const who_bbu  = whoLines(rawBBU[jk]);
                const who_tbu  = whoLines(rawTBU[jk]);
                const who_bbpb = whoLines(rawBBPB[jk]);

                // Distribusikan data anak ke array 0-60 bulan
                const cBBU  = new Array(61).fill(null);
                const cTBU  = new Array(61).fill(null);
                const cBBPB = new Array(66).fill(null);

                data.periksa.forEach(p => {
                    const m = Math.round(p.umur_bulan || 0);
                    if (m >= 0 && m <= 60) { cBBU[m] = p.berat_badan; cTBU[m] = p.tinggi_badan; }
                    const idx = Math.round(p.tinggi_badan) - 45;
                    if (idx >= 0 && idx <= 65) cBBPB[idx] = p.berat_badan;
                });

                // Simpan untuk filter
                kaderWho   = { bbu: who_bbu, tbu: who_tbu, bbpb: who_bbpb };
                kaderChild = { bbu: cBBU,    tbu: cTBU,    bbpb: cBBPB };

                // Destroy chart lama sebelum buat baru
                if (kaderCharts.bbu)  kaderCharts.bbu.destroy();
                if (kaderCharts.tbu)  kaderCharts.tbu.destroy();
                if (kaderCharts.bbpb) kaderCharts.bbpb.destroy();

                kaderCharts.bbu  = buildKaderWhoChart('grafikBBU-kader',  who_bbu,  cBBU,  monthLabels, 'BB Anak (kg)', 'rgba(78,115,223,1)',  'Umur (Bulan)',        'Berat Badan (kg)',  'bbu');
                kaderCharts.tbu  = buildKaderWhoChart('grafikTBU-kader',  who_tbu,  cTBU,  monthLabels, 'TB Anak (cm)', 'rgba(28,200,138,1)',  'Umur (Bulan)',        'Tinggi Badan (cm)', 'tbu');
                kaderCharts.bbpb = buildKaderWhoChart('grafikBBPB-kader', who_bbpb, cBBPB, pbLabels,    'BB Anak (kg)', 'rgba(153,102,255,1)', 'Panjang Badan (cm)', 'Berat Badan (kg)',  'bbpb');
            });
    });
    // ======= Validasi form kolom kosong =======
    document.querySelector('form').addEventListener('submit', function (e) {
        let isValid = true;

        const fields = [
            { name: 'balita_id',    label: 'Nama Anak',            type: 'select' },
            { name: 'tgl_periksa',  label: 'Tanggal Pemeriksaan',  type: 'input'  },
            { name: 'berat_badan',  label: 'Berat Badan',          type: 'input'  },
            { name: 'tinggi_badan', label: 'Tinggi Badan',         type: 'input'  },
        ];

        fields.forEach(function (field) {
            const input   = document.querySelector(`[name="${field.name}"]`);
            const errorId = 'error-' + field.name;
            const oldErr  = document.getElementById(errorId);
            if (oldErr) oldErr.remove();
            input.classList.remove('is-invalid');

            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');

                const div = document.createElement('div');
                div.id        = errorId;
                div.className = 'invalid-feedback d-block';
                div.textContent = field.label + ' tidak boleh kosong.';
                input.parentNode.appendChild(div);
            }
        });

        if (!isValid) e.preventDefault();
    });

    // Hapus error saat user mengisi
    document.querySelectorAll('select[name="balita_id"], input[name="tgl_periksa"], input[name="berat_badan"], input[name="tinggi_badan"]').forEach(function (el) {
        ['change', 'input'].forEach(function (evt) {
            el.addEventListener(evt, function () {
                this.classList.remove('is-invalid');
                const err = document.getElementById('error-' + this.name);
                if (err) err.remove();
            });
        });
    });

</script>
@endpush
</x-app-layout>