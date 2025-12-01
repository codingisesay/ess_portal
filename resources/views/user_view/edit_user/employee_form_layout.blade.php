
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIL Technologies Employee Portal</title>
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png')}}" />
    <link rel="stylesheet" href="{{ asset('user_end/css/onboarding_form.css') }}">
    <!-- Styles for the user footer component -->
    <link rel="stylesheet" href="{{ asset('user_end/css/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('user_end/js/toastify-notifications.js') }}"></script>
</head>

<!-- just chnaged the class name to give matching css  -->
<body class="has-fixed-footer">
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
            <div class="label">Employee Details</div>
        </div>
        <div class="step" id="step2" data-route="{{ route('user.editcontact',['id' => $permission_array]) }}">
            <div class="circle">2</div>
            <div class="label">Contact Details</div>
        </div>
        <div class="step" id="step3" data-route="{{ route('user.editedu',['id' => $permission_array]) }}">
            <div class="circle">3</div>
            <div class="label">Education Details</div>
        </div>
        <div class="step" id="step4" data-route="{{ route('user.editbank',['id' => $permission_array]) }}">
            <div class="circle">4</div>
            <div class="label">Bank Details</div>
        </div>
        <div class="step" id="step5" data-route="{{ route('user.editfamily',['id' => $permission_array]) }}">
            <div class="circle">5</div>
            <div class="label">Family Details</div>
        </div>
        <div class="step" id="step6" data-route="{{ route('user.editpreemp',['id' => $permission_array]) }}">
            <div class="circle">6</div>
            <div class="label">Previous Employment</div>
        </div>
        <div class="step" id="step7" data-route="{{ route('user.editdocupload',['id' => $permission_array]) }}">
            <div class="circle">7</div>
            <div class="label">Document Upload</div>
        </div>
    </div>

    <!-- Content Area (Where Forms Will Be Loaded Dynamically) -->
    @yield('content')

     <!-- Include the section for the current step -->
     @stack('step')  <!-- Push the current step to be used in JavaScript -->

<!--script start-->
<script> 
document.addEventListener('DOMContentLoaded', function () {
    // Collect all step elements into an array
    const steps = Array.from(document.querySelectorAll('.step'));
    // Get the Next button
    const nextBtn = document.querySelector('.next-btn');
    // Get the Submit button
    const submitBtn = document.getElementById('form-submit');

// normalizeHref() is used to make all URLs consistent so the url can correctly identify,
// the active step and navigate between steps without mistakes

     // Function to Normalize any URL 
    const normalizeHref = (href) => {
        try {
            // Create a URL object from the href
            const url = new URL(href, window.location.origin);
           // Remove trailing slashes from pathname
            const pathname = url.pathname.replace(/\/+$/, '');
            // Keep query string as is
            const search = url.search || '';
             // Rebuild normalized URL
            return url.origin + pathname + search;
        } catch (e) {
            // Fallback when URL() fails
            return (href || '').replace(/\/+$/, '');
        }
    };


    //It converts the data-route into a safe, correct, 
    // normalized URL so step progress bar always works correctly.
    const getStepHref = (step) => {
         // Build full URL relative to current origin
        const route = step.getAttribute('data-route') || '';
        try {
        // Convert the route into a full absolute URL based on the current site origin
        // Normalize the URl
            return normalizeHref(new URL(route, window.location.origin).href);
        } catch (e) {
            // If URL construction fails (bad or incomplete route),
            // simply normalize the route string itself
            return normalizeHref(route);
        }
    };

     // Get the current page URL in normalized form
    const currentHref = normalizeHref(window.location.href);

    // Find active step by matching:
    // 1. Exact URL match
    // 2. Current page starts with step URL 
    // 3. Step URL starts with current page 
    let activeStepIndex = steps.findIndex(step => {
        const sh = getStepHref(step);
        return sh === currentHref || currentHref.startsWith(sh) || sh.startsWith(currentHref);
    });

     // If no match found
    if (activeStepIndex === -1) {
        // Normalize current page's path
        const currentPath = (new URL(window.location.href, window.location.origin)).pathname.replace(/\/+$/, '');
        activeStepIndex = steps.findIndex(step => {
            try {
                 // Extract normalized pathname from each step
                const p = (new URL(step.getAttribute('data-route'), window.location.origin)).pathname.replace(/\/+$/, '');
                return p === currentPath;
            } catch (e) {
                // If URL constructor fails, compare raw strings
                return (step.getAttribute('data-route') || '').replace(/\/+$/, '') === currentPath;
            }
        });
    }

     // Default to the first step 
    if (activeStepIndex === -1) activeStepIndex = 0;
    // Function that apply CSS classes and toggle buttons based on active step
    const renderSteps = () => {
        steps.forEach((s, i) => {
            // Remove previous visual states
            s.classList.remove('active', 'completed');
            // Mark all previous steps as completed
            if (i < activeStepIndex) s.classList.add('completed');
            // Mark the current step as active
            if (i === activeStepIndex) s.classList.add('active', 'completed');
        });
        // Handle the visibility of Next vs Submit buttons
        if (submitBtn) {
            // Show submit button for last step, hide next button
            if (activeStepIndex === steps.length - 1) {
                submitBtn.style.display = 'inline-block';
                if (nextBtn) nextBtn.style.display = 'none';
            } else {
                // Show next button only when not on last step
                submitBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'inline-block';
            }
        }
    };

    renderSteps();

    // Click-to-navigate on steps
    // like to click on any step in the progress bar and jump directly to that page
    steps.forEach((step, index) => {
        step.addEventListener('click', () => {
            activeStepIndex = index;
            renderSteps();
            // Navigate to the selected step's URL
            const route = step.getAttribute('data-route');
            if (route) window.location.href = route;
        });
    });

    // Function executed when the Next button is clicked
    window.updateProgressBar = function () {
        if (activeStepIndex < steps.length - 1) {
            activeStepIndex++;
            renderSteps();
            // Navigate to the next step's route
            const nextRoute = steps[activeStepIndex].getAttribute('data-route');
            if (nextRoute) {
                window.location.href = nextRoute;
                return true;
            }
            return false;
        } else {
             // If already on final step,
            if (submitBtn) {
                submitBtn.click();
                return true;
            }
            return false;
        }
    };
});
</script>  <!--script end-->




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
    
    <!-- Footer Section -->
    <footer class="page-footer">
        <a href="{{ route('privacy_policy_pdf') }}" target="_blank" class="footer-link" title="Open Privacy Policy">
            <div class="footer-content">
                <img src="{{ asset('user_end/images/STPLLogo.png') }}" alt="Logo" class="footer-logo">
                <span class="footer-text">© {{ date('Y') }} Payvance Innovations Pvt Ltd. All rights reserved.</span>
            </div>
        </a>
    </footer>
</body>
</html>
