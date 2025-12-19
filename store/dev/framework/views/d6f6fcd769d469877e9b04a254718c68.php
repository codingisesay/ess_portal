<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Updated title and favicon for PayVance - Start -->
    <title>PayVance Innovations Pvt. Ltd.</title>
    <link rel="icon" href="<?php echo e(asset('user_end/images/STPLLogo.png')); ?>" type="image/png">
    <!-- Updated title and favicon for PayVance - End -->

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('user_end/css/login.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('errors/error.css')); ?>">

</head>
<body>
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <div class="alert alert-danger"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <div class="container">
        <div class="left-container">

            
        <img src="<?php echo e(asset('user_end/images/Vector 58.jpg')); ?>" alt="Login Image"> 
          </div>
        <div class="right-container">

            <?php if(session('success')): ?>
            <div class="alert custom-alert-success">
                <strong><?php echo e(session('success')); ?></strong> 
                <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
        <div class="alert custom-alert-error">
            <strong> <?php echo e(session('error')); ?></strong>
            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        <?php endif; ?>
            <div class="logo">
                <img src="<?php echo e(asset('user_end/images/STPL Logo with TagLine HD Transparent.png')); ?>" alt="SIL Logo" class="img-fluid" width="180">
            </div>
            <form class="signup-form " method="POST" action="<?php echo e(route('user.login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input type="text" name="email" id="username" placeholder=" " oninput="this.value = this.value.toUpperCase(); validateUsername()" required>
                    <label for="username">Username</label>
                    <span class="eye-icon">
                        <!-- <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'userfill']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?> -->
                        <img src="<?php echo e(asset('user_end/images/user.png')); ?>" alt="Username Icon" width="24" height="24">
                    </span>
                    <div class="text-danger small"></div>
                </div>

                <div class="form-group password-container">
                    <input type="password" name="password" id="password" placeholder=" "  oninput="validatePassword()" required>
                    <label for="password">Password</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                        <img src="<?php echo e(asset('user_end/images/hidden.png')); ?>" alt="Show Password" width="24" height="24" id="password-icon">
                        <!-- <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'eyefill']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?> -->
                    </span>
                    <div class="text-danger small"></div>
                </div>
                <!-- value="akash@1234" -->
                <!-- value="akash.tech.0394@gmail.com"  -->
                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember-me">
                    <label class="form-check-label" for="remember-me">Remember me</label>
                </div>

                <!-- Login Button -->
                <button type="submit" name="login" class="signup-button">Login</button>

                <!-- Forgot Password -->
                <div class="text-center mt-3">
                    <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none">Forgot Password?</a>
                </div>

                <!-- OR Separator -->
                <!-- <div class="text-center my-3">
                    <span class="text-muted">OR</span>
                </div> -->

                <!-- Microsoft Login -->
                <!-- <button type="button" class="btn btn-outline-secondary" onclick="window.location.href=''">
                    <img src="<?php echo e(asset('user_end/images/windows.png')); ?>" alt="Microsoft Icon" width="18" height="18" class="me-2">
                    Continue with Microsoft
                </button> -->

                <!-- Register Link -->
                <!-- <div class="text-center mt-3">
                    <p class="mb-1">Don’t have an account?</p>
                    <a href="onboarding_form.php" class="btn btn-outline-secondary">Register</a>
                </div> -->
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconImg = document.getElementById(fieldId + '-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                iconImg.src = "<?php echo e(asset('user_end/images/eye.png')); ?>"; // Open eye icon
                iconImg.alt = "Hide Password";
            } else {
                passwordField.type = 'password';
                iconImg.src = "<?php echo e(asset('user_end/images/hidden.png')); ?>"; // Closed eye icon
                iconImg.alt = "Show Password";
            }
        }
    </script>
</body>
</html>

<?php /**PATH /var/www/html/resources/views/auth/user-login.blade.php ENDPATH**/ ?>