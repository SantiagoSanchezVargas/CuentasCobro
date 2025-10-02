<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'CuentasCobro'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --uc-verde: #009739;
            --uc-gris: #333333;
            --uc-blanco: #FFFFFF;
            --uc-negro: #000000;
        }

        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--uc-verde) 0%, var(--uc-gris) 100%);
        }

        .login-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--uc-verde) !important;
        }

        .navbar, .bg-dark {
            background: var(--uc-gris) !important;
        }

        .sidebar {
            background: var(--uc-verde);
            min-height: calc(100vh - 56px);
        }

        .sidebar .nav-link {
            color: var(--uc-blanco);
            padding: 12px 20px;
            border-radius: 5px;
            margin: 2px 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--uc-gris);
            color: var(--uc-blanco);
        }

        .main-content {
            background: #f8f9fa;
            min-height: calc(100vh - 56px);
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body></html><?php /**PATH C:\xampp2\htdocs\CuentaCobros\CuentasCobro\resources\views/layouts/app.blade.php ENDPATH**/ ?>