
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

        // Track the index of the active step
        let activeStepIndex = -1;

        // Loop through the steps to initialize them based on the current route
        steps.forEach((step, index) => {
            const route = step.getAttribute('data-route');

            // If the current route matches the step's route, mark it as active
            if (currentRoute === new URL(route, window.location.origin).pathname) {
                step.classList.add('active');
                activeStepIndex = index; // Track the index of the active step
            } else if (index < activeStepIndex) {
                // If the step is before the active one, mark it as completed
                step.classList.add('completed');
            }
        });

        // Update the progress when a step is clicked
        steps.forEach((step, index) => {
            step.addEventListener('click', function() {
                const route = step.getAttribute('data-route');

                // Remove 'active' class from all steps
                steps.forEach(s => {
                    s.classList.remove('active');
                    s.classList.remove('completed');
                });

                // Add 'active' class to the clicked step
                step.classList.add('active');

                // Mark the clicked step and all previous steps as completed
                steps.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('completed');
                    }
                });

                // Update the activeStepIndex to the clicked step's index
                activeStepIndex = index;

                // Redirect to the corresponding route (page)
                window.location.href = route;
            });
        });

        // // Handle programmatic next step navigation when the next button is clicked
        // const nextButton = document.querySelector('.next-btn'); // Your "next" button

        // if (nextButton) {
        //     nextButton.addEventListener('click', function(event) {
        //         event.preventDefault(); // Prevent form submission (if it's inside a form)

        //         // Move to the next step if possible
        //         if (activeStepIndex >= 0 && activeStepIndex < steps.length - 1) {
        //             const nextStep = steps[activeStepIndex + 1];
        //             const nextStepRoute = nextStep.getAttribute('data-route');

        //             // Remove the 'active' class from all steps
        //             steps.forEach(s => s.classList.remove('active'));

        //             // Add the 'active' class to the next step
        //             nextStep.classList.add('active');

        //             // Mark the previous steps as completed
        //             steps.forEach((s, i) => {
        //                 if (i <= activeStepIndex + 1) {
        //                     s.classList.add('completed');
        //                 }
        //             });

        //             // Update the activeStepIndex
        //             activeStepIndex++;

        //             // Redirect to the next step route
        //             window.location.href = nextStepRoute;
        //         }
        //     });
        // }

        // Ensure the previous steps are marked as completed when navigating programmatically
        if (activeStepIndex > -1) {
            for (let i = 0; i < activeStepIndex; i++) {
                steps[i].classList.add('completed');
            }
        }
    });
</script>




    <style>
        /* Style for active step */
        .step.active .circle {
            background-color: #8A3366; /* Blue color for active step */
        }

        /* Style for completed step */
        .step.completed .circle {
            background-color: #8A3366; /* Gray color for completed steps */
        }

        .step.completed:not(:last-child)::after {
            background-color: #8A3366; /* Gray line for completed steps */
        }

        /* Optional: Style for active step's label */
        .step.active .label {
            font-weight: bold;
        }

        /* Add transitions for smooth color change */
        .step .circle {
            transition: background-color 0.3s ease;
        }
    </style>
</body>
</html>
