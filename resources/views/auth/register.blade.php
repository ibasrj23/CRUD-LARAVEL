<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card" style="max-width: 450px;">
            <div class="header-area">
                <i class="fas fa-user-plus header-icon"></i>
                <h1 class="card-title">Buat Akun Baru</h1>
                <p class="card-subtitle">Silakan isi data Anda untuk mendaftar.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="alert-error">
                        <p>Pendaftaran gagal. Mohon periksa kembali data yang Anda masukkan.</p>
                    </div>
                @endif

                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo">Photo Profil</label>
                    <input id="photo" type="file" name="photo" accept="image/*" required>
                    @error('photo')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
					<label for="password_confirmation">Confirm Password</label>
					<input id="password_confirmation" type="password" name="password_confirmation" required>
				@error('password_confirmation')
						<p class="field-error">{{ $message }}</p>
				@enderror
		</div>
                 <button type="submit" class="login-button">DAFTAR</button>
            <div class="footer-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>

</body>
</html>