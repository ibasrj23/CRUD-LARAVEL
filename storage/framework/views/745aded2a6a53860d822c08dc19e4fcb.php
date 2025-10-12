<header class="navbar navbar-dark bg-dark fixed-top shadow-sm px-3 py-2">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        
        <a class="navbar-brand fw-bold fs-5" href="<?php echo e(route('home')); ?>">
            <i class="bi bi-building me-2"></i>Company Name
        </a>

        
        <button class="navbar-toggler d-md-none border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="d-flex align-items-center">

            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm px-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger btn-sm px-3 d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                    </button>
                </form>
            <?php endif; ?>

        </div>
    </div>
</header>
<?php /**PATH C:\Users\ASUSTeK\latihan-laravel\resources\views/components/navbar.blade.php ENDPATH**/ ?>