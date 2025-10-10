<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator</title>
    <link href="<?php echo e(asset('admin/css/style.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="header-area">
                <i class="fas fa-lock header-icon"></i>
                <h1 class="card-title">Login ke Sistem</h1>
                <p class="card-subtitle">Silakan masukkan kredensial Anda untuk melanjutkan.</p>
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <?php if($errors->any()): ?>
                    <div class="alert-error">
                        <p>Login gagal. Mohon periksa kembali Username dan Password Anda.</p>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="<?php echo e(old('username')); ?>" required autofocus>
                    </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    </div>

				 <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: auto; margin: 0; padding: 0;">
                    <label for="remember_me" style="margin: 0; font-weight: normal;">Ingat Saya (Langsung Login)</label>
                </div>
                <button type="submit" class="login-button">MASUK</button>
            </form>

            <div class="footer-link">
                Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>
            </div>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>