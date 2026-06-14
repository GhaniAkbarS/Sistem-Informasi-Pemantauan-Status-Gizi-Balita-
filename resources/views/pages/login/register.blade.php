<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Register - Posyandu Cendrawasih</title>
    <link href="{{ asset('tabler/css/tabler.min.css') }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
        font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body class="d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <h2 class="fw-bold text-primary">SiGizi | Sistem Pemantauan Gizi Balita
 </h2>
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Daftar Akun Baru</h2>
            <p class="text-center text-muted mb-4">Lengkapi data diri anda</p>

            @if(session('error'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" autocomplete="off" novalidate>
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama Lengkap" required>
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required style="text-transform: lowercase;">
                @error('username')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                  <span class="input-group-text">
                    <a href="javascript:void(0)" id="toggle-password" class="link-secondary" title="Tampilkan password" data-bs-toggle="tooltip">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                      </svg>
                    </a>
                  </span>
                  @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role"
                  class="form-select @error('role') is-invalid @enderror" required>
                  <option value="">Pilih Role</option>
                  <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Posyandu</option>
                  <option value="kader" {{ old('role') == 'kader' ? 'selected' : '' }}>Petugas/kader</option>
                  <option value="orang_tua" {{ old('role') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                </select>
                @error('role')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                  <label for="posyandu_id" class="form-label">Posyandu</label>
                  <select id="posyandu_id" name="posyandu_id" class="form-select" required>
                      <option value="">Pilih Posyandu</option>
                      @foreach($posyandus as $posyandu)
                          <option value="{{ $posyandu->id }}">{{ $posyandu->nama_posyandu }}</option>
                      @endforeach
                  </select>
                  @error('posyandu_id')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          Sudah punya akun? <a href="{{ route('login') }}" tabindex="-1">Login disini</a>
        </div>
      </div>
    </div>
    <script src="{{ asset('tabler/js/tabler.min.js') }}" defer></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        if (toggleBtn && passwordInput) {
          toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('text-primary');
          });
        }

        // Validasi form sebelum submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
          let isValid = true;

          const fields = [
            { id: 'name',         label: 'Nama Lengkap',  type: 'input'  },
            { id: 'username',     label: 'Username',       type: 'input'  },
            { id: 'password',     label: 'Password',       type: 'input'  },
            { id: 'role',         label: 'Role',           type: 'select' },
            { id: 'posyandu_id',  label: 'Posyandu',       type: 'select' },
          ];

          fields.forEach(function (field) {
            const input = document.getElementById(field.id);
            const errorId = 'error-' + field.id;
            let errorEl = document.getElementById(errorId);

            // Hapus pesan error lama
            if (errorEl) errorEl.remove();
            input.classList.remove('is-invalid');

            const value = input.value.trim();
            if (!value) {
              isValid = false;
              input.classList.add('is-invalid');

              const div = document.createElement('div');
              div.id = errorId;
              div.className = 'invalid-feedback d-block';
              div.textContent = field.label + ' tidak boleh kosong.';

              // Untuk password yang ada di dalam input-group, pasang di parent .mb-3
              if (field.id === 'password') {
                input.closest('.mb-3').appendChild(div);
              } else {
                input.parentNode.appendChild(div);
              }
            } else if (field.id === 'username' && /\s/.test(input.value)) {
              // Cek spasi di username
              isValid = false;
              input.classList.add('is-invalid');

              const div = document.createElement('div');
              div.id = errorId;
              div.className = 'invalid-feedback d-block';
              div.textContent = 'Username tidak boleh mengandung spasi.';
              input.parentNode.appendChild(div);
            }
          });

          if (!isValid) e.preventDefault();
        });

        // Hapus error saat user mulai mengisi
        document.querySelectorAll('input, select').forEach(function (el) {
          el.addEventListener('change', function () {
            this.classList.remove('is-invalid');
            const errorEl = document.getElementById('error-' + this.id);
            if (errorEl) errorEl.remove();
          });
          el.addEventListener('input', function () {
            this.classList.remove('is-invalid');
            const errorEl = document.getElementById('error-' + this.id);
            if (errorEl) errorEl.remove();
          });
        });

        // Blokir spasi di username secara langsung (real-time)
        const usernameInput = document.getElementById('username');
        if (usernameInput) {
          usernameInput.addEventListener('keydown', function (e) {
            if (e.key === ' ') e.preventDefault();
          });
          usernameInput.addEventListener('input', function () {
            this.value = this.value.replace(/\s/g, '').toLowerCase();
          });
        }
      });
    </script>

  </body>
</html>
