<?php 

// // dd($userData);
// echo $userData->imagelink;
// exit();

$profileimahe = session('profile_image');
$userDetails = app('App\Http\Controllers\headerController')->getUserDetails();


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo e(asset('user_end/images/STPLLogo.png')); ?>" type="image/png">
    <title><?php if(isset($title)): ?><?php echo e($title); ?><?php else: ?><?php echo e('ESS Portal'); ?><?php endif; ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('/user_end/css/header.css')); ?>">
    <link href="<?php echo e(asset('bootstrapcss/bootstrap.min.css')); ?>" rel="stylesheet"> 
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="<?php echo e(asset('user_end/js/toastify-notifications.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <script>
        var successMessage = <?php echo json_encode(session('success'), 15, 512) ?>;
        var errorMessage = <?php echo json_encode(session('error'), 15, 512) ?>;
    </script>
    <header>
        <div class="logo">
            <img class="px-1" src="<?php echo e(asset('user_end/images/STPL Logo with TagLine HD Transparent.png')); ?>" alt="STPL Logo">
        </div>
        <!-- 🔹 MENU BUTTON -->
        <button class="menu-btn"><?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'menu']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?></button>
        <nav>
            <ul>
                <li><a href="<?php echo e(route('user.homepage')); ?>" class="active"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'dashboard']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>Dashboard</a></li>
                <li><a href="<?php echo e(route('user.employment.data')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'userdetails']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>Employee Details</a></li>
                <li><a href="<?php echo e(route('PayRollDashboard')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pay']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>Payroll</a></li>
                <li><a href="<?php echo e(route('leave_dashboard')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'attendance']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>Leave & Attendance</a></li> 
                <li><a href="<?php echo e(route('user.view_organisation')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chart']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>Orgnizations Chart</a></li> 
                <li><a href="<?php echo e(route('user.hr.policy')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'policyfill']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>HR Policy</a></li>
                 <li><a href="<?php echo e(route('pms_dashboard')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chart']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>PMS Dashboard</a></li> 
                <li><a href="<?php echo e(route('user.setting')); ?>"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'settingfill']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>Settings</a></li>
            </ul>
        </nav>
        <script>
            // 🔹 Toggle Navbar on Click
            document.querySelector(".menu-btn").addEventListener("click", function () {
                document.querySelector("nav").classList.toggle("active");
            });
        </script>
        <div class="header-icons">
            <div class="searchcircle">
                <a href="search.html" class="text-dark mx-2">
                   <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'search']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
                </a>
            </div>
            <div class="bellcircle"> 
                <!-- Notification dropdown toggled on bell click -->
                <a href="javascript:void(0)" id="notificationIcon" class="text-dark mx-2">
                  <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notification']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
                </a>
                <div id="notificationDropdown" class="dropdown-content-notifications" style="display:none; min-width:260px;">
                    <div class="px-2 py-2"><strong>Notifications</strong></div>
                    <hr class="my-1"/>
                    <div class="px-2 pb-2 text-muted"><small>No notifications yet.</small></div>
                </div>
            </div>
            <div class="profilecircle profile-dropdown">
                <a href="javascript:void(0)" id="profileIcon" class="mx-2" > 
                    <img src="<?php echo e(asset('storage/'.$profileimahe)); ?>" alt="Profile Picture" class="header-profile">
                </a>
                <div class="profile-dropdown-content"> 
                    <div class="d-flex"> 
                    <img src="<?php echo e(asset('storage/'.$profileimahe)); ?>" alt="Profile Picture" class="profile-in-dd" >                   
                 
                    <div >
                        <p class="mb-0"><?php echo e($userDetails->name); ?></p>
                        <small class="text-muted"><small>
                            Emp. Code: <?php echo e($userDetails->employeeID); ?>

                        </small></small>
                    </div>
                    </div>
                    <hr class="my-2"/>                         
                    <div class="profile-links">
                    <p class="mb-0 py-1 px-2 " onclick="openModall()" >   
                    <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'camera']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>&nbsp; <small> Change Avatar  </small> 
                    </p> 
                    <p class="mb-0 py-1 px-2"> <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'lock','class' => 'text-muted']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>&nbsp; <small> Change Password </small> </p>                 
                    <hr class="my-2" /> 
                    <form action="<?php echo e(route('user.logout')); ?>" method="POST" ><?php echo csrf_field(); ?>
                        <button type="submit" class="logout-icon">
                        <?php if (isset($component)) { $__componentOriginald88937ee957874c050ccbc67a5e19575 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald88937ee957874c050ccbc67a5e19575 = $attributes; } ?>
<?php $component = App\View\Components\Icon::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'logout']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $attributes = $__attributesOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__attributesOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald88937ee957874c050ccbc67a5e19575)): ?>
<?php $component = $__componentOriginald88937ee957874c050ccbc67a5e19575; ?>
<?php unset($__componentOriginald88937ee957874c050ccbc67a5e19575); ?>
<?php endif; ?> <small> Logout </small> 
                        </button>
                     </form>

                    </div>
                </div>
            </div>  
        </div>
    </header>

<!-- Image Upload Modal -->
<div id="myModall" class="modall">
    <div class="modal-content8">
        <div class="modal-header">
            <h2>Upload your image</h2>
            <span class="close1" onclick="closeModall()">&times;</span>
        </div>
        
        <!-- Image Preview Container -->
        <div class="image-container8" id="imageContainer">
            <img id="imagePreview" class="image-preview"
                 src="<?php echo e($profileimahe ? asset('storage/'.$profileimahe) : asset('user_end/images/default-avatar.png')); ?>"
                 >
            <div class="camera-overlay">
                <i class="fas fa-camera"></i>
                <span>Click to select image</span>
            </div>
        </div>
        
        <!-- Hidden File Input -->
        <form id="profile-upload-form" action="<?php echo e(route('user.uploadProfilePhoto')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="file" id="fileInput" name="profile_image" accept="image/*" class="d-none" required>
            <button type="submit" class="buttonn mt-3" id="uploadBtn" disabled>Upload</button>
        </form>
    </div>
</div>

<script>
// Open the modal
function openModall() {
    document.getElementById("myModall").style.display = "block";
    // Reset form and preview when modal is opened
    document.getElementById('profile-upload-form').reset();
    document.getElementById('imagePreview').src = '<?php echo e($profileimahe ? asset("storage/".$profileimahe) : asset("user_end/images/default-avatar.png")); ?>';
    document.getElementById('uploadBtn').disabled = true;
}

// Close the modal
function closeModall() {
    document.getElementById("myModall").style.display = "none";
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('myModall');
    if (event.target == modal) {
        closeModall();
    }
}

// Handle file selection
const fileInput = document.getElementById('fileInput');
const imageContainer = document.getElementById('imageContainer');
const imagePreview = document.getElementById('imagePreview');
const uploadBtn = document.getElementById('uploadBtn');

// Open file dialog when clicking on the image container
imageContainer.addEventListener('click', function() {
    fileInput.click();
});

// Handle file selection
fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check if file is an image
        if (!file.type.match('image.*')) {
            alert('Please select an image file (JPEG, PNG, etc.)');
            return;
        }
        
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size should be less than 2MB');
            return;
        }
        
        // Create a preview of the selected image
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            uploadBtn.disabled = false;
        }
        reader.readAsDataURL(file);
    }
});

// Handle form submission
const form = document.getElementById('profile-upload-form');
form.addEventListener('submit', function(e) {
    if (!fileInput.files.length) {
        e.preventDefault();
        alert('Please select an image to upload');
        return false;
    }
    // Show loading state
    uploadBtn.disabled = true;
    uploadBtn.innerHTML = 'Uploading...';
});
</script>



    <?php echo $__env->yieldContent('content'); ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get all navigation links
            var navLinks = document.querySelectorAll('nav ul li a');

            // Initially remove the active class from all links
            navLinks.forEach(function (link) {
                link.classList.remove('active');
            });

            // Get the current page's filename
            var currentPage = window.location.pathname.split('/').pop();

            // Loop through each link and check if its href matches the current page
            navLinks.forEach(function (link) {
                var linkPath = link.getAttribute('href').split('/').pop();

                // If the current page matches the link's href, add the 'active' class
                if (linkPath === currentPage) {
                    link.classList.add('active');
                }
            });

        


        });

        
                    // Open the modal
function openModall() {
    document.getElementById("myModall").style.display = "block";
}

// Close the modal
function closeModall() {
    document.getElementById("myModall").style.display = "none";
}

// Preview the selected image
function previewImage() {
    const file = document.getElementById("fileInput").files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        document.getElementById("imagePreview").src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Upload the image (you can add actual upload logic here)
// function uploadImage() {
//     alert('Image uploaded successfully!');
//     closeModal();
// }
    </script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const bellIcon = document.getElementById('notificationIcon');
    const dropdown = document.getElementById('notificationDropdown');

    let autoRefreshInterval = null;

    // ✅ Function to fetch and render notifications
    async function loadNotifications(showDropdown = false) {
        try {
            const response = await fetch("<?php echo e(route('notifications.fetch')); ?>");
            const data = await response.json();

            dropdown.innerHTML = '';

            let headerHTML = `
                <div class="px-2 py-2 d-flex justify-content-between align-items-center">
                    <strong>Notifications</strong>
                    <div class="d-flex align-items-center gap-2">
                        <a href="#" id="markAllRead" class="text-decoration-none"><small>Mark all read</small></a> |
                        <a href="#" id="clearAll" class="text-danger text-decoration-none"><small>Clear all</small></a>
                    </div>
                </div>
                <hr class="my-1"/>
            `;
            dropdown.insertAdjacentHTML('beforeend', headerHTML);

            if (!data.notifications.length) {
                dropdown.insertAdjacentHTML('beforeend', `
                    <div class="px-2 pb-2 text-muted"><small>No notifications.</small></div>
                `);
                return;
            }

            data.notifications.forEach(n => {
                dropdown.insertAdjacentHTML('beforeend', `
                    <div class="px-2 py-2 border-bottom d-flex justify-content-between align-items-start ${n.read_at ? 'bg-light' : 'bg-white'}">
                        <div class="notification-item flex-grow-1" 
                             data-id="${n.id}" 
                             data-link="${n.link || ''}" 
                             style="cursor:pointer;">
                            <strong>${n.title}</strong><br>
                            <small class="text-muted">${n.message}</small><br>
                            <small class="text-secondary">${n.created_at}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger ms-2 clear-btn" data-id="${n.id}" title="Clear this notification">×</button>
                    </div>
                `);
            });

            // ✅ Mark all as read
            document.getElementById('markAllRead')?.addEventListener('click', async function (e) {
                e.preventDefault();
                await fetch("<?php echo e(route('notifications.readAll')); ?>");
                loadNotifications();
            });

            // ✅ Clear all
            document.getElementById('clearAll')?.addEventListener('click', async function (e) {
                e.preventDefault();
                Swal.fire({
                title: 'Are you sure?',
                text: "This will delete all notifications permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, clear all!',
                cancelButtonText: 'Cancel'
                }).then(async (result) => {
                 if (result.isConfirmed) {
                 
                 await fetch("<?php echo e(route('notifications.clearAll')); ?>");
                 loadNotifications();
                
                Swal.fire({
                    title: 'Cleared!',
                    text: 'All notifications have been cleared.',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                });
         }
        });
            });

            // ✅ Handle individual notification click
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const link = this.dataset.link;
                    markNotificationAsRead(id, link);
                });
            });

            // ✅ Handle clear button click
            document.querySelectorAll('.clear-btn').forEach(btn => {
                btn.addEventListener('click', async function (e) {
                    e.stopPropagation();
                    const id = this.dataset.id;
                    await clearNotification(id);
                });
            });

            if (showDropdown) {
                dropdown.style.display = 'block';
            }

        } catch (error) {
            console.error("Error fetching notifications:", error);
        }
    }

    // ✅ Mark single notification as read
    async function markNotificationAsRead(id, link) {
        try {
            await fetch(`/notifications/read/${id}`);
            if (link) {
                window.location.href = link;
            } else {
                loadNotifications();
            }
        } catch (error) {
            console.error("Error marking notification as read:", error);
        }
    }

    // ✅ Clear (delete) single notification
    async function clearNotification(id) {
        try {
            await fetch(`/notifications/clear/${id}`);
            loadNotifications();
        } catch (error) {
            console.error("Error clearing notification:", error);
        }
    }

    // 🔔 Toggle dropdown on click
    bellIcon.addEventListener('click', async function (e) {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = dropdown.style.display === 'block';
        dropdown.style.display = isOpen ? 'none' : 'block';
        if (!isOpen) {
            await loadNotifications(true);
        }
    });

    // 🕒 Auto-refresh every 30 seconds
    autoRefreshInterval = setInterval(() => loadNotifications(), 30000);

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
        dropdown.style.display = 'none';
    });
});
</script>


    
    <!-- Global footer included for non-edit pages 
     removed the footer whixh is in employee_form_layout.blade.php on the top-->
     
    <?php
        $currentRoute = request()->route()->getName();
        $isEditPage = str_contains($currentRoute, 'edit') || str_contains($currentRoute, 'update');
    ?>
    <?php if(!$isEditPage): ?>
        <?php echo $__env->make('user_view.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</body>
<?php /**PATH /var/www/html/resources/views/user_view/header.blade.php ENDPATH**/ ?>