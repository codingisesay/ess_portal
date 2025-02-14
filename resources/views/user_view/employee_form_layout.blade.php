
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
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{asset('user_end/images/STPL Logo with TagLine HD Transparent.png')}}">
        </div>
    </header>

    <style>
        .logo img {
            height: 50px;
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
    


    <!-- Progress Bar -->
    <div class="step-tabs">
        <div class="step active" id="step1" data-file="employee_details.php">
            <div class="circle">1</div>
            <div class="label">Employee Details</div>
        </div>
        <div class="step" id="step2" data-file="contact_details.php">
            <div class="circle">2</div>
            <div class="label">Contact Details</div>
        </div>
        <div class="step" id="step3" data-file="educational_details.php">
            <div class="circle">3</div>
            <div class="label">Education Details</div>
        </div>
        <div class="step" id="step4" data-file="bank_details.php">
            <div class="circle">4</div>
            <div class="label">Bank Details</div>
        </div>
        <div class="step" id="step5" data-file="family_details.php">
            <div class="circle">5</div>
            <div class="label">Family Details</div>
        </div>
        <div class="step" id="step6" data-file="previous_employment.php">
            <div class="circle">6</div>
            <div class="label">Previous Employment</div>
        </div>
        <div class="step" id="step7" data-file="document_upload.php">
            <div class="circle">7</div>
            <div class="label">Document Upload</div>
        </div>
    </div>

    <!-- Content Area (Where Forms Will Be Loaded Dynamically) -->
    {{-- <div id="content-area">
        <p>Loading Employee Details...</p>
    </div> --}}

    <!-- !PAGE CONTENT! -->

  @yield('content')

    <script>
       $(document).ready(function () {
    // Load the first step by default
    loadStep("employee_details.php");

    // Handle step click
    $(".step").click(function () {
        var file = $(this).data("file");
        var index = $(this).index(); // Get the index of the clicked step

        // Load the content of the clicked step
        loadStep(file);

        // Highlight all previous and current steps as completed
        $(".step").each(function (i) {
            if (i <= index) {
                $(this).addClass("completed"); // Mark as completed
            } else {
                $(this).removeClass("completed"); // Remove completed if it's ahead
            }
        });

        // Mark the current step as active
        $(".step").removeClass("active");
        $(this).addClass("active");
    });

    // Function to load step content dynamically
    function loadStep(file) {
        $("#content-area").html("<p>Loading...</p>");
        $.ajax({
            url: file,
            method: "GET",
            success: function (data) {
                $("#content-area").html(data);
            },
            error: function () {
                $("#content-area").html("<p>Error loading content.</p>");
            }
        });
    }
});

    </script>
    <style>
        .step.completed .circle {
    background-color: #8A3366; /* Gray color for completed steps */
}

.step.completed:not(:last-child)::after {
    background-color: #8A3366; /* Gray line for completed steps */
}

    </style>
</body>
</html>
