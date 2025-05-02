
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIL Technologies Employee Portal</title>
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png')}} " />
    <link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
</head>

<body>
    {{-- <header>
        <div class="logo">
            <img src="{{asset('user_end/images/STPL Logo with TagLine HD Transparent.png')}}">
        </div>
    </header> --}}

    <style>
        .logo img {
            /* height: 50px; */
            margin: 5px;
        }

        .logo {
            border-radius: 60px;
            background-color: white;
            width: 120px;
        }

        #content-area {
            border: 1px solid #ccc;
            padding: 20px;
            min-height: 300px;
        }
    </style>
<?php
$permission_array = session('id');



?>
    
    <!-- Progress Bar -->
    <div class="step-tabs">
        <div class="step" id="step1" data-route="{{ route('user.editdashboard',['id' => $permission_array]) }}">
            <div class="circle">1</div>
            <div class="label">Employee&nbsp;Details</div>
        </div>
        <div class="step" id="step2" data-route="{{ route('user.editcontact',['id' => $permission_array]) }}">
            <div class="circle">2</div>
            <div class="label">Contact&nbsp;Details</div>
        </div>
        <div class="step" id="step3" data-route="{{ route('user.editedu',['id' => $permission_array]) }}">
            <div class="circle">3</div>
            <div class="label">Education&nbsp;Details</div>
        </div>
        <div class="step" id="step4" data-route="{{ route('user.editbank',['id' => $permission_array]) }}">
            <div class="circle">4</div>
            <div class="label">Bank&nbsp;Details</div>
        </div>
        <div class="step" id="step5" data-route="{{ route('user.editfamily',['id' => $permission_array]) }}">
            <div class="circle">5</div>
            <div class="label">Family&nbsp;Details</div>
        </div>
        <div class="step" id="step6" data-route="{{ route('user.editpreemp',['id' => $permission_array]) }}">
            <div class="circle">6</div>
            <div class="label">Work&nbsp;History</div>
        </div>
        <div class="step" id="step7" data-route="{{ route('user.editdocupload',['id' => $permission_array]) }}">
            <div class="circle">7</div>
            <div class="label">Document&nbsp;Upload</div>
        </div>
    </div>

    <!-- Content Area (Where Forms Will Be Loaded Dynamically) -->
    @yield('content')

     <!-- Include the section for the current step -->
     @stack('step')  <!-- Push the current step to be used in JavaScript -->

 
 
<script>
document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step');
    
    // Get the current route (current page URL)
    const currentRoute = window.location.pathname;

    // Initialize stepper state
    function initializeStepper() {
        let foundActive = false;
        
        steps.forEach((step, index) => {
            const route = step.getAttribute('data-route');
            const routePath = new URL(route, window.location.origin).pathname;
            
            // Reset classes
            step.classList.remove('active', 'completed');
            
            // Mark as active if matches current route
            if (currentRoute === routePath && !foundActive) {
                step.classList.add('active');
                foundActive = true;
                
                // Mark all previous steps as completed
                for (let i = 0; i < index; i++) {
                    steps[i].classList.add('completed');
                }
            } 
            // Mark as completed if we've passed the active step
            else if (foundActive) {
                step.classList.remove('completed');
            }
            // Mark as completed if before active step
            else {
                step.classList.add('completed');
            }
        });
    }

    // Initialize on page load
    initializeStepper();

    // Handle step clicks
    steps.forEach(step => {
        step.addEventListener('click', function() {
            const route = step.getAttribute('data-route');
            window.location.href = route;
        });
    });

    // Handle next button navigation if exists
    const nextButton = document.querySelector('.next-btn');
    if (nextButton) {
        nextButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Find current active step
            let currentActiveIndex = -1;
            steps.forEach((step, index) => {
                if (step.classList.contains('active')) {
                    currentActiveIndex = index;
                }
            });
            
            // If found and not last step, go to next
            if (currentActiveIndex >= 0 && currentActiveIndex < steps.length - 1) {
                const nextStep = steps[currentActiveIndex + 1];
                const nextRoute = nextStep.getAttribute('data-route');
                window.location.href = nextRoute;
            }
        });
    }
});
</script>

<style>
    /* Improved stepper styling */
    .step-tabs {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        cursor: pointer;
        flex: 1;
    }
    
    .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 15px;
        left: 60%;
        width: 80%;
        height: 2px;
        background-color: #e0e0e0;
        z-index: -1;
    }
    
    .step.completed:not(:last-child)::after {
        background-color: #8A3366;
    }
    
    .circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    
    .step.active .circle {
        background-color: #8A3366;
    }
    
    .step.completed .circle {
        background-color: #8A3366;
    }
    
    .label {
        text-align: center;
        font-size: 0.9rem;
        color: #666;
    }
    
    .step.active .label {
        color: #8A3366;
        font-weight: bold;
    }
    
    .step.completed .label {
        color: #8A3366;
    }
</style>
</body>
</html>


