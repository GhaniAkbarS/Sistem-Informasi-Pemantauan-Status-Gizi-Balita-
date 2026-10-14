<script src="{{ asset('tabler/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('tabler/js/tabler.min.js') }}"></script>
<script src="{{ asset('tabler/js/sip-chart-compat.js') }}?v=4"></script>
<script src="{{ asset('tabler/js/sip-icons.js') }}"></script>
<!-- Usability Testing Tracker -->
	@if(session('usability_session_id'))
	<style>
		#usability-widget {
			position: fixed; bottom: 24px; right: 24px; z-index: 9999;
			background: linear-gradient(135deg, #c2185b, #9d164c);
			color: white; border-radius: 16px; padding: 1rem 1.25rem;
			box-shadow: 0 8px 32px rgba(194,24,91,0.28);
			font-family: 'Segoe UI', sans-serif; font-size: 0.85rem;
			min-width: 240px;
		}
		#usability-widget .widget-title { font-weight: 700; font-size: 0.8rem; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem; }
		#usability-widget .timer { font-size: 1.6rem; font-weight: 800; margin-bottom: 0.75rem; }
		#usability-widget .task-btns { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 0.75rem; }
		#usability-widget .task-btn {
			background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
			color: white; border-radius: 8px; padding: 0.4rem 0.75rem;
			font-size: 0.78rem; cursor: pointer; text-align: left; transition: background 0.2s;
		}
		#usability-widget .task-btn:hover { background: rgba(255,255,255,0.25); }
		#usability-widget .task-btn.done { background: rgba(17,153,142,0.5); border-color: rgba(17,153,142,0.6); text-decoration: line-through; opacity: 0.7; }
		#usability-widget .end-btn {
			width: 100%; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4);
			color: white; border-radius: 8px; padding: 0.5rem;
			font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: background 0.2s;
		}
		#usability-widget .end-btn:hover { background: rgba(248,80,50,0.7); }
	</style>

	<div id="usability-widget">
		<div class="widget-title">🧪 Sesi Pengujian Aktif</div>
		<div class="timer" id="uTimer">00:00</div>
		<div class="task-btns" id="taskBtnList">
			<div style="font-size:0.78rem;opacity:0.8;margin-bottom:0.25rem;">Tandai skenario selesai:</div>
			@php $skenarios = App\Http\Controllers\UsabilityController::skenarioList(); @endphp
			@foreach($skenarios as $no => $nama)
				<button class="task-btn" id="task-btn-{{ $no }}" onclick="markTaskDone({{ $no }}, this)">
					S{{ $no }}: {{ Str::limit($nama, 30) }}
				</button>
			@endforeach
		</div>
		<button class="end-btn" onclick="endSession()">⏹ Selesai &amp; Lihat Report</button>
	</div>

	<script>
	(function() {
		const SESSION_START = {{ session('usability_session_id') ? 'true' : 'false' }};
		if (!SESSION_START) return;

		const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
		let pageEnterTime = Date.now();
		let currentPage   = document.title || window.location.pathname;
		let taskTimers    = {};
		let taskErrors    = {};
		const doneTasks   = new Set();

		// ── Timer ─────────────────────────────────────────────────────────────────
		const startTime = Date.now();
		setInterval(() => {
			const elapsed = Math.floor((Date.now() - startTime) / 1000);
			const m = String(Math.floor(elapsed / 60)).padStart(2, '0');
			const s = String(elapsed % 60).padStart(2, '0');
			document.getElementById('uTimer').textContent = m + ':' + s;
		}, 1000);

		// ── Catat kunjungan halaman ───────────────────────────────────────────────
		function logPageVisit(durasiSebelumnya) {
			fetch('/usability/log', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
				body: JSON.stringify({
					event_type:         'page_visit',
					page_url:           window.location.href,
					page_name:          document.title,
					durasi_di_halaman:  durasiSebelumnya || null,
					is_back_navigation: (window.history.state?.back !== undefined),
					is_error:           false,
				})
			}).catch(() => {});
		}

		// ── Catat klik ───────────────────────────────────────────────────────────
		document.addEventListener('click', function(e) {
			const el     = e.target.closest('a, button, [role="button"]');
			const elName = el ? (el.textContent.trim().substring(0, 50) || el.id || el.className) : null;
			if (!elName) return;
			// Skip widget sendiri
			if (e.target.closest('#usability-widget')) return;

			fetch('/usability/log', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
				body: JSON.stringify({
					event_type: 'click',
					page_url:   window.location.href,
					page_name:  document.title,
					element:    elName,
					is_error:   false,
				})
			}).catch(() => {});
		}, true);

		// Catat kunjungan pertama
		logPageVisit(null);

		// Catat saat user pindah halaman
		window.addEventListener('beforeunload', function() {
			const durasi = Math.floor((Date.now() - pageEnterTime) / 1000);
			navigator.sendBeacon('/usability/log', JSON.stringify({
				event_type:        'page_leave',
				page_url:          window.location.href,
				page_name:         document.title,
				durasi_di_halaman: durasi,
				is_error:          false,
			}));
		});

		// ── Tandai skenario selesai ───────────────────────────────────────────────
		window.markTaskDone = function(taskNo, btn) {
			if (doneTasks.has(taskNo)) return;
			doneTasks.add(taskNo);
			btn.classList.add('done');
			btn.disabled = true;

			const durasi = taskTimers[taskNo]
				? Math.floor((Date.now() - taskTimers[taskNo]) / 1000)
				: null;

			fetch('/usability/task-done', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
				body: JSON.stringify({
					task_number:   taskNo,
					berhasil:      true,
					durasi_detik:  durasi,
					jumlah_error:  taskErrors[taskNo] || 0,
				})
			}).catch(() => {});
		};

		// ── Akhiri sesi ───────────────────────────────────────────────────────────
		window.endSession = function() {
			if (!confirm('Akhiri sesi pengujian dan lihat laporan?')) return;
			window.location.href = '/usability/end';
		};
	})();
	</script>
	@endif

