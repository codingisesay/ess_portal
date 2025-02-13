<?php 
$id = Auth::guard('web')->user()->id;

?>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">TESTING</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><form method="POST" action="{{ route('user.logout') }}">
    @csrf
    <button type="submit" class="btn-primary" style="position:relative; top:10%;">Logout</button>
</form></li>
      <!-- <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li> -->
    </ul>
  </div>
</nav>

<div class="container-fluid">
<h3>Personal A/C Details </h3>
  <form>
  <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Bank_Name</label>
        <select class="form-control" required>
            <option value="">Select any one</option>
            <option value=""></option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Branch_Name</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Account_Number</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">IFSC_Code</label>
        <select class="form-control" required>
            <option value="">Select any one</option>
            <option value=""></option>
        </select>
      </div>
</div>

<h3>Salary A/C Details </h3>
  <form>
  <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Bank_Name</label>
        <select class="form-control" required>
            <option value="">Select any one</option>
            <option value=""></option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Branch_Name</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Account_Number</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">IFSC_Code</label>
        <select class="form-control" required>
            <option value="">Select any one</option>
            <option value=""></option>
        </select>
      </div>
</div>

    <h3>Passport and Visa</h3>

    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Passport_Number</label>
        <select class="form-control" required>
            <option value="">Select any one</option>
            <option value=""></option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Issuing_Country</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Passport_issue_date</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Passport_expiry_date</label>
        <select class="form-control" required>
            <option value="">Select any one</option>
            <option value=""></option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Active_Visa</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Visa_expiry_date</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>
     
    </div>
 
    
    <a href="{{ route('user.edu') }}" class="btn btn-success">back</a>
    <a href="{{ route('user.family') }}" class="btn btn-success">next</a>
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
</div>
<script>

const today = new Date().toISOString().split('T')[0];  // Format YYYY-MM-DD

// Select all date input fields with the class 'Joining_Date'
const dateFields = document.getElementsByClassName("Joining_Date");

// Loop through each date input field and set the 'max' attribute
for (let i = 0; i < dateFields.length; i++) {
    dateFields[i].setAttribute("max", today);
}


// Select the elements
const maritalStatusSelect = document.getElementById("marital_status");
const anniversaryDateInput = document.getElementById("anv");

// Add an event listener to the marital status select dropdown
maritalStatusSelect.addEventListener("change", function() {
    // Enable Anniversary_Date input for "Married" or "Divorced" options
    if (maritalStatusSelect.value === "Married" || maritalStatusSelect.value === "Divorced") {
        anniversaryDateInput.disabled = false;  // Enable the date input
    } else {
        anniversaryDateInput.disabled = true;   // Disable the date input
        anniversaryDateInput.value = "";        // Clear the value when disabled
    }
});


    /**
                                 * Function to fetch nationalities from an API with retry logic.
                                 */
                                async function fetchNationalities(retries = 3) {
                                    const selectElement = document.getElementById('nationality');

                                    const fetchWithRetries = async () => {
                                        try {
                                            const response = await fetch('https://restcountries.com/v3.1/all', {
                                                headers: { "Content-Type": "application/json" },
                                            });

                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }

                                            const data = await response.json();
                                            populateDropdown(data);
                                        } catch (error) {
                                            console.error("Error fetching nationalities: ", error);

                                            if (retries > 0) {
                                                console.log('Retrying fetch...');
                                                setTimeout(() => fetchWithRetries(retries - 1), 1000);
                                            } else {
                                                alert("Unable to load nationalities after multiple attempts.");
                                            }
                                        }
                                    };

                                    const populateDropdown = (countries) => {
                                        const sortedCountries = countries.sort((a, b) =>
                                            a.name?.common?.localeCompare(b.name?.common)
                                        );

                                        selectElement.innerHTML = ""; // Clear dropdown before appending data
                                        sortedCountries.forEach(country => {
                                            const option = document.createElement('option');
                                            option.value = country.name?.common?.toLowerCase() || '';
                                            option.textContent = country.name?.common || 'Unknown';
                                            selectElement.appendChild(option);
                                        });

                                        // Set default nationality to India if available
                                        const indiaOption = Array.from(selectElement.options).find(option => option.value === "india");
                                        if (indiaOption) {
                                            indiaOption.selected = true;
                                        }
                                    };

                                    // Call the fetch with retry
                                    fetchWithRetries();
                                }

                                // Wait for DOM to load and execute the function
                                document.addEventListener("DOMContentLoaded", function () {
                                    fetchNationalities();
                                });

    </script>
</body>
