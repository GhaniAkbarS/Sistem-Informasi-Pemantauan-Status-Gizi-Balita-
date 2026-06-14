{{-- Partial: Riwayat Anak --}}
<div class="col-md-12 mt-2" id="riwayat-container" style="display: none;">
    <div class="card border-0" style="background: #f0f4ff; border-radius: 10px;">
        <div class="card-body py-3 px-4">

            {{-- Header --}}
            <div class="d-flex align-items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary me-2" width="20" height="20"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/>
                    <path d="M9 12h6"/><path d="M9 16h6"/>
                </svg>
                <strong class="text-primary">Riwayat Anak</strong>
            </div>

            {{-- Nav Tabs --}}
            <ul class="nav nav-tabs" id="riwayatTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-periksa" data-bs-toggle="tab"
                        data-bs-target="#tab-periksa-pane" type="button" role="tab">
                        Pemeriksaan
                        <span class="badge bg-primary ms-1" id="badge-periksa">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-imunisasi" data-bs-toggle="tab"
                        data-bs-target="#tab-imunisasi-pane" type="button" role="tab">
                        Imunisasi
                        <span class="badge bg-primary ms-1" id="badge-imunisasi">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-vitamin" data-bs-toggle="tab"
                        data-bs-target="#tab-vitamin-pane" type="button" role="tab">
                        Vitamin A
                        <span class="badge bg-primary ms-1" id="badge-vitamin">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-grafik" data-bs-toggle="tab"
                        data-bs-target="#tab-grafik-pane" type="button" role="tab">
                        📊 Grafik
                    </button>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content bg-white rounded-bottom p-3" id="riwayatTabContent">

                {{-- Tab Pemeriksaan --}}
                <div class="tab-pane fade show active" id="tab-periksa-pane" role="tabpanel">
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>BB (kg)</th>
                                    <th>TB (cm)</th>
                                    <th>Status Gizi</th>
                                </tr>
                            </thead>
                            <tbody id="list-periksa">
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data pemeriksaan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tab Imunisasi --}}
                <div class="tab-pane fade" id="tab-imunisasi-pane" role="tabpanel">
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Vaksin</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="list-imunisasi">
                                <tr><td colspan="3" class="text-center text-muted py-3">Belum ada data imunisasi</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tab Vitamin A --}}
                <div class="tab-pane fade" id="tab-vitamin-pane" role="tabpanel">
                    <div class="table-responsive mt-2">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Kapsul</th>
                                </tr>
                            </thead>
                            <tbody id="list-vitamin">
                                <tr><td colspan="2" class="text-center text-muted py-3">Belum ada data vitamin A</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tab Grafik Pertumbuhan --}}
                <div class="tab-pane fade" id="tab-grafik-pane" role="tabpanel">
                    <div class="mt-2 mb-2">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                            <small class="fw-bold text-muted">Filter Umur (BB/U & TB/U):</small>
                            <input type="number" id="kaderFilterMin" class="form-control form-control-sm" style="width:68px" placeholder="Min" min="0" max="60">
                            <span class="text-muted">–</span>
                            <input type="number" id="kaderFilterMax" class="form-control form-control-sm" style="width:68px" placeholder="Max" min="0" max="60">
                            <span class="text-muted small">bulan</span>
                            <button class="btn btn-xs btn-primary px-2" onclick="kaderApplyFilter()">Terapkan</button>
                            <button class="btn btn-xs btn-secondary px-2" onclick="kaderResetFilter()">Reset</button>
                        </div>
                        <p class="small fw-semibold text-muted mb-1">📈 Berat Badan Menurut Umur (BB/U)</p>
                        <canvas id="grafikBBU-kader" height="110"></canvas>
                        <p class="small fw-semibold text-muted mt-3 mb-1">📏 Tinggi Badan Menurut Umur (TB/U)</p>
                        <canvas id="grafikTBU-kader" height="110"></canvas>
                        <p class="small fw-semibold text-muted mt-3 mb-1">⚖️ Berat Badan Menurut Panjang Badan (BB/PB)</p>
                        <canvas id="grafikBBPB-kader" height="110"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
