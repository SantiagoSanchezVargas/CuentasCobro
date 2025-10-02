

<?php $__env->startSection('title', 'Iniciar Sesión - CuentasCobro'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card p-4" style="border: 2px solid var(--uc-verde);">
                    <div class="text-center mb-4">
                        <i class="fas fa-file-invoice-dollar fa-3x mb-3" style="color: var(--uc-verde);"></i>
                        <h3 class="fw-bold" style="color: var(--uc-gris);">CuentasCobro</h3>
                        <p style="color: var(--uc-verde);">Inicia sesión en tu cuenta</p>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: var(--uc-gris);">
                                <i class="fas fa-envelope me-1"></i>Correo electrónico
                            </label>
                            <input type="email" 
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo e(old('email')); ?>" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="Ingresa tu correo"
                                   style="border-color: var(--uc-verde);">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label" style="color: var(--uc-gris);">
                                <i class="fas fa-lock me-1"></i>Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Ingresa tu contraseña"
                                   style="border-color: var(--uc-verde);">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember" style="color: var(--uc-gris);">
                                Recordarme
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background: var(--uc-verde); color: var(--uc-blanco); border: none;">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small style="color: var(--uc-gris);">
                            ¿No tienes una cuenta? 
                            <a href="<?php echo e(route('register')); ?>" class="text-decoration-none" style="color: var(--uc-verde); font-weight: bold;">Regístrate aquí</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp2\htdocs\CuentaCobros\CuentasCobro\resources\views/auth/login.blade.php ENDPATH**/ ?>