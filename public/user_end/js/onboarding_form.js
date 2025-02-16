
const anniversaryDateErrorSpan = document.getElementById('anniversaryDateError');

maritalStatusSelect.addEventListener('change', function () {
    const anniversaryDate = document.getElementById('anniversaryDate');
    if (this.value === 'Married') {
        anniversaryDate.style.pointerEvents = 'auto'; // Allow interaction
        anniversaryDate.setAttribute('max', new Date().toISOString().split('T')[0]); // Set max to today
        anniversaryDateErrorSpan.textContent = ''; // Clear any error
    } else {
        anniversaryDate.style.pointerEvents = 'none'; // Prevent interaction
        anniversaryDate.value = '';       // Clear the value
        anniversaryDateErrorSpan.textContent = '';       // Clear any error
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

function toggleAnniversaryDate() {
    const maritalStatus = document.getElementById('maritalStatus').value;
    const anniversaryDate = document.getElementById('anniversaryDate');
    const errorSpan = document.getElementById('anniversaryDateError');
    const requiredMark = document.getElementById('anniversaryRequiredMark');

    if (maritalStatus === 'Married') {
        // Enable the anniversary date field
        anniversaryDate.style.pointerEvents = 'auto'; // Allow interaction
        anniversaryDate.style.opacity = '1'; // Set opacity to visible
        anniversaryDate.setAttribute('required', 'true'); // Make it required
        anniversaryDate.setAttribute('max', new Date().toISOString().split('T')[0]); // Set max to today
        errorSpan.textContent = ''; // Clear any error
        requiredMark.style.display = 'inline'; // Show the red asterisk
    } else {
        // Disable the anniversary date field
        anniversaryDate.style.pointerEvents = 'none'; // Prevent interaction
        anniversaryDate.style.opacity = '0.6'; // Set opacity to visually indicate it's disabled
        anniversaryDate.value = ''; // Clear the value
        anniversaryDate.removeAttribute('required'); // Remove the required attribute
        errorSpan.textContent = ''; // Clear any error
        requiredMark.style.display = 'none'; // Hide the red asterisk
    }
}

function validateAnniversaryDate() {
    const anniversaryDate = document.getElementById('anniversaryDate').value;
    const errorSpan = document.getElementById('anniversaryDateError');
    const today = new Date().toISOString().split('T')[0];

    if (new Date(anniversaryDate) > new Date(today)) {
        errorSpan.textContent = 'Anniversary date cannot be in the future.';
    } else {
        errorSpan.textContent = ''; // Clear any error
    }
}


document.getElementById("totalExperience").addEventListener("input", function (e) {
    let input = e.target.value;

    // Allow only numbers and one optional decimal
    const regex = /^\d+(\.\d{0,2})?$/;

    // Validate against the regex
    if (!regex.test(input)) {
        e.target.value = input.slice(0, -1); // Remove invalid characters
        return;
    }

    // Check if a decimal is present
    const hasDecimal = input.includes(".");

    // Enforce max length based on decimal presence
    if ((!hasDecimal && input.length > 2) || (hasDecimal && input.replace('.', '').length > 4)) {
        e.target.value = input.slice(0, -1);
        return;
    }

    // Split into years and months
    const parts = input.split(".");
    if (parts.length === 2) {
        let months = parseInt(parts[1], 10);

        // Auto-correct months if they exceed 11
        if (months > 11) {
            e.target.value = parts[0] + ".11";
        }

        // Limit months to 2 digits
        if (parts[1].length > 2) {
            e.target.value = parts[0] + "." + parts[1].slice(0, 2);
        }
    }
});

document.getElementById("totalExperience").addEventListener("blur", function (e) {
    const input = e.target.value;

    // Remove trailing decimal if left incomplete
    if (input.includes('.') && input.split('.')[1] === '') {
        e.target.value = input.slice(0, -1);
    }
});


// Today's date
// const today = new Date(); // This line is commented out to avoid redeclaration

// Set minimum age limit (e.g., 18 years ago)
const minAgeDate = new Date(today);
minAgeDate.setFullYear(today.getFullYear() - 18);

// Set maximum age limit (e.g., 100 years ago)
const maxAgeDate = new Date(today);
maxAgeDate.setFullYear(today.getFullYear() - 100);

// Format dates as yyyy-mm-dd
// Format dates as yyyy-mm-dd
const minDate = minAgeDate.toISOString().split('T')[0];
const maxDate = maxAgeDate.toISOString().split('T')[0];

// Apply the min and max attributes
const dobInput = document.getElementById('dateOfBirth');
dobInput.setAttribute('min', maxDate); // At most 100 years old
dobInput.setAttribute('max', minDate); // At least 18 years old

// Optional: Show an error message if the date is out of range
dobInput.addEventListener('input', function () {
    const selectedDate = new Date(dobInput.value);
    if (selectedDate > minAgeDate || selectedDate < maxAgeDate) {
        document.getElementById('dateOfBirthError').textContent = 'Please select a valid date of birth.';
    } else {
        document.getElementById('dateOfBirthError').textContent = '';
    }
});

const maritalStatusSelect = document.getElementById('maritalStatus');
const anniversaryDate = document.getElementById('anniversaryDate');
const errorSpan = document.getElementById('anniversaryDateError');

maritalStatusSelect.addEventListener('change', function () {
    if (this.value === 'Married') {
        anniversaryDate.style.pointerEvents = 'auto'; // Allow interaction
        anniversaryDate.setAttribute('max', new Date().toISOString().split('T')[0]); // Set max to today
        errorSpan.textContent = ''; // Clear any error
    } else {
        anniversaryDate.style.pointerEvents = 'none'; // Prevent interaction
        anniversaryDate.value = '';       // Clear the value
        errorSpan.textContent = '';       // Clear any error
    }
});


function togglePincodeAsterisk1() {
    const countryInput = document.getElementById('correspondence_country').value;
    const pincodeAsterisk = document.getElementById('pincode-asterisk');

    if (countryInput.trim().toLowerCase() === 'india') {
        pincodeAsterisk.style.display = 'inline'; // Show the asterisk
    } else {
        pincodeAsterisk.style.display = 'none'; // Hide the asterisk
    }
}

// Initialize the pincode asterisk display based on the default country value
document.addEventListener('DOMContentLoaded', togglePincodeAsterisk1);


// Function to fetch country data from the API
async function fetchCountries() {
    try {
        const response = await fetch('https://restcountries.com/v3.1/all?fields=name');
        const countries = await response.json();

        const correspondenceDatalist = document.getElementById('correspondence_countries');
        const permanentDatalist = document.getElementById('permanent_countries');

        // Populate datalist options
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name.common; // Use common name as the value
            correspondenceDatalist.appendChild(option.cloneNode(true)); // Add to correspondence datalist
            permanentDatalist.appendChild(option); // Add to permanent datalist
        });
    } catch (error) {
        console.error('Error fetching countries:', error);
    }
}

// Call the function to fetch countries when the page loads
document.addEventListener('DOMContentLoaded', fetchCountries);

// Function to handle country validation and toggle PIN code
function checkCountryAndTogglePincode() {
    const countryInput = document.getElementById('permanent_country').value;
    const countryRequiredSpan = document.getElementById('country-required');

    // Example logic: Show a warning if the country is not in the list (you can modify this)
    if (!countryInput) {
        countryRequiredSpan.style.display = 'inline';
    } else {
        countryRequiredSpan.style.display = 'none';
    }
}


function checkCountryAndTogglePincode() {
    const countryField = document.getElementById("permanent_country");
    const pincodeField = document.getElementById("permanent_pincode");
    const pincodeRequiredSpan = document.getElementById("pincode-required");
    const countryRequiredSpan = document.getElementById("country-required");

    if (countryField.value.trim().toLowerCase() === "india") {
        // Make pincode mandatory
        pincodeField.setAttribute("required", "required");
        pincodeRequiredSpan.style.display = "inline";
    } else {
        // Remove mandatory requirement
        pincodeField.removeAttribute("required");
        pincodeRequiredSpan.style.display = "none";
    }
}

// Initialize on page load to handle pre-filled values
document.addEventListener("DOMContentLoaded", checkCountryAndTogglePincode);

function clearForm() {
    // Permanent Address fields
    document.getElementById('permanent_building_no').value = '';
    document.getElementById('permanent_premises_name').value = '';
    document.getElementById('permanent_landmark').value = '';
    document.getElementById('permanent_road_street').value = '';
    document.getElementById('permanent_pincode').value = '';
    document.getElementById('permanent_city').value = '';
    document.getElementById('permanent_district').value = '';
    document.getElementById('permanent_state').value = '';
    document.getElementById('permanent_country').value = 'India';  // Default value

    // Correspondence Address fields
    document.getElementById('correspondence_building_no').value = '';
    document.getElementById('correspondence_premises_name').value = '';
    document.getElementById('correspondence_landmark').value = '';
    document.getElementById('correspondence_road_street').value = '';
    document.getElementById('correspondence_pincode').value = '';
    document.getElementById('correspondence_city').value = '';
    document.getElementById('correspondence_district').value = '';
    document.getElementById('correspondence_state').value = '';
    document.getElementById('correspondence_country').value = 'India';  // Default value

    // Uncheck the "Same as Permanent Address" checkbox
    document.getElementById('same_as_permanent').checked = false;
}


function validateEmergencyContactName() {
    const input = document.getElementById("emergency_contact_name");
    const errorSpan = document.getElementById("emergencyContactNameError");

    // Remove invalid characters
    const validValue = input.value.replace(/[^a-zA-Z\s]/g, '');
    if (input.value !== validValue) {
        errorSpan.textContent = "Only alphabets and spaces are allowed.";
    } else {
        errorSpan.textContent = "";
    }

    input.value = validValue; // Update the input value
}

function validatePhoneNumbers() {
    const phoneNumber = document.getElementById('phoneNumber').value;
    const emergencyContactNumber = document.getElementById('emergency_contact_number').value;
    const alternatePhoneNumber = document.getElementById('alternate_phone_number').value;

    const phoneNumberError = document.getElementById('phoneNumberError');
    const emergencyContactNumberError = document.getElementById('emergencyContactNumberError');
    const alternatePhoneNumberError = document.getElementById('alternatePhoneNumberError');

    // Clear previous errors
    phoneNumberError.textContent = '';
    emergencyContactNumberError.textContent = '';
    alternatePhoneNumberError.textContent = '';

    // Ensure that only numbers are entered and limit to 10 digits
    document.getElementById('phoneNumber').value = phoneNumber.replace(/[^0-9]/g, '').slice(0, 10);
    document.getElementById('emergency_contact_number').value = emergencyContactNumber.replace(/[^0-9]/g, '').slice(0, 10);
    document.getElementById('alternate_phone_number').value = alternatePhoneNumber.replace(/[^0-9]/g, '').slice(0, 10);

    // Check if the phone number and alternate phone number are the same
    if (phoneNumber && alternatePhoneNumber && phoneNumber === alternatePhoneNumber) {
        phoneNumberError.textContent = 'Phone Number and Alternate Phone Number cannot be the same.';
        alternatePhoneNumberError.textContent = 'Phone Number and Alternate Phone Number cannot be the same.';
    }

    // Check if the phone number and emergency contact number are the same
    if (phoneNumber && emergencyContactNumber && phoneNumber === emergencyContactNumber) {
        phoneNumberError.textContent = 'Phone Number and Emergency Contact Number cannot be the same.';
        emergencyContactNumberError.textContent = 'Phone Number and Emergency Contact Number cannot be the same.';
    }

    // Check if the emergency contact number and alternate phone number are the same
    if (emergencyContactNumber && alternatePhoneNumber && emergencyContactNumber === alternatePhoneNumber) {
        emergencyContactNumberError.textContent = 'Emergency Contact and Alternate Phone Number cannot be the same.';
        alternatePhoneNumberError.textContent = 'Emergency Contact and Alternate Phone Number cannot be the same.';
    }
}

function copyPermanentAddress() {
    const isChecked = document.getElementById('same_as_permanent').checked;

    // Get all Permanent Address fields
    const permanentFields = {
        building_no: document.getElementById('permanent_building_no').value,
        premises_name: document.getElementById('permanent_premises_name').value,
        landmark: document.getElementById('permanent_landmark').value,
        road_street: document.getElementById('permanent_road_street').value,
        city: document.getElementById('permanent_city').value,
        state: document.getElementById('permanent_state').value,
        pincode: document.getElementById('permanent_pincode').value,
        district: document.getElementById('permanent_district').value,
        country: document.getElementById('permanent_country').value
    };

    // Set values for Correspondence Address fields if checked
    document.getElementById('correspondence_building_no').value = isChecked ? permanentFields.building_no : '';
    document.getElementById('correspondence_premises_name').value = isChecked ? permanentFields.premises_name : '';
    document.getElementById('correspondence_landmark').value = isChecked ? permanentFields.landmark : '';
    document.getElementById('correspondence_road_street').value = isChecked ? permanentFields.road_street : '';
    document.getElementById('correspondence_city').value = isChecked ? permanentFields.city : '';
    document.getElementById('correspondence_state').value = isChecked ? permanentFields.state : '';
    document.getElementById('correspondence_pincode').value = isChecked ? permanentFields.pincode : '';
    document.getElementById('correspondence_district').value = isChecked ? permanentFields.district : '';
    document.getElementById('correspondence_country').value = isChecked ? permanentFields.country : '';
}







// Initialize the country code picker for phone number fields
var phoneInput = document.querySelector("#phoneNumber");
var alternatePhoneInput = document.querySelector("#alternate_phone_number");
var emergencyPhoneInput = document.querySelector("#emergency_contact_number");

var phoneNumberInput = window.intlTelInput(phoneInput, {
    initialCountry: "IN",  // Default country set to India
    separateDialCode: true,
    geoIpLookup: function (callback) {
        fetch('https://ipinfo.io/json?token=YOUR_API_KEY') // Optional: add an API key for location-based country code
            .then(response => response.json())
            .then(data => callback(data.country))
            .catch(() => callback("IN")); // Fallback to India if there's an error
    }
});

var alternatePhoneNumberInput = window.intlTelInput(alternatePhoneInput, {
    initialCountry: "IN",  // Default country set to India
    separateDialCode: true
});

var emergencyPhoneNumberInput = window.intlTelInput(emergencyPhoneInput, {
    initialCountry: "IN",  // Default country set to India
    separateDialCode: true
});





function validatePhoneNumber(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}

function fetchCityAndState(pincodeId, cityId, stateId, districtId) {
    const pincodeField = document.getElementById(pincodeId);
    const cityField = document.getElementById(cityId);
    const stateField = document.getElementById(stateId);
    const districtField = document.getElementById(districtId);

    const pincode = pincodeField.value;

    // If the pincode field is empty, clear city, state, and district fields
    if (!pincode) {
        cityField.value = '';
        stateField.value = '';
        districtField.value = '';
        return;
    }

    // Ensure the pin code has 6 digits before making the request
    if (pincode.length !== 6) return;

    fetch('fetch_city_state.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            pinCode: pincode,
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                cityField.value = data.city;
                stateField.value = data.statecode;
                districtField.value = data.district; // Update district value
            } else {
                alert('No matching records found for the entered pincode.');
                // Clear values if no matching records are found
                cityField.value = '';
                stateField.value = '';
                districtField.value = '';
            }
        })
        .catch(error => {
            console.error('Error fetching city, state, and district:', error);
            // Clear fields in case of an error
            cityField.value = '';
            stateField.value = '';
            districtField.value = '';
        });
}

function validatePercentageInput(input) {
    // Replace all non-numeric and non-decimal characters
    input.value = input.value.replace(/[^0-9.]/g, '');

    // Split the input into integer and decimal parts
    const parts = input.value.split('.');

    // Ensure only one decimal point is allowed
    if (parts.length > 2) {
        input.value = parts[0] + '.' + parts[1];
        return;
    }

    // Restrict the integer part to 2 characters
    if (parts[0].length > 2) {
        parts[0] = parts[0].slice(0, 2);
    }

    // Restrict the decimal part to 2 characters
    if (parts[1] && parts[1].length > 2) {
        parts[1] = parts[1].slice(0, 2);
    }

    // Rejoin the parts and set the value
    input.value = parts.join('.');

    // Check if the total length excluding the decimal is greater than 4
    const totalLength = parts[0].length + (parts[1] ? parts[1].length : 0);
    if (totalLength > 4) {
        if (parts[1]) {
            parts[1] = parts[1].slice(0, Math.max(0, 4 - parts[0].length));
        }
        input.value = parts.join('.');
    }
}

function blockNumbers(event) {
    const key = event.keyCode || event.which;
    // Allow Backspace, Delete, Tab, Escape, Enter, and Arrow keys
    if ([8, 9, 27, 13, 37, 38, 39, 40].includes(key)) {
        return true;
    }
    // Block number keys (0-9) and Numpad keys (0-9)
    if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
        return false;
    }
    return true;
}


function toggleDateOfCertificate(inputField) {
    const certificationName = inputField.value.trim();
    const row = inputField.closest('tr'); // Find the closest table row
    if (!row) return; // If no row is found, stop execution

    const dateInput = row.querySelector('.date-input');
    if (!dateInput) return; // If no date-input is found, stop execution

    if (certificationName !== "") {
        // Enable the date field
        dateInput.style.pointerEvents = 'auto'; // Allow interaction
        dateInput.style.opacity = '1'; // Set opacity to visible
        dateInput.setAttribute('required', 'true'); // Make it required
    } else {
        // Disable the date field
        dateInput.style.pointerEvents = 'none'; // Prevent interaction
        dateInput.style.opacity = '0.6'; // Set opacity to visually indicate it's disabled
        dateInput.value = ''; // Clear the value
        dateInput.removeAttribute('required'); // Remove the required attribute
    }
}



// Embed Employee_NO from PHP session into a JavaScript variable
const employeeNo = "<?php echo $_SESSION['employee_no']; ?>";  // Assuming Employee_NO is stored in session

// Check if the employeeNo is correctly set
console.log("Employee_NO from PHP session:", employeeNo);

function removeEducationRow(button) {
    const row = button.closest('tr');
    const serialNo = row.querySelector('input[name="serial_no[]"]').value; // Get the Serial_No value

    // Log the serialNo to check if it's being correctly retrieved
    console.log("Serial_No to delete:", serialNo);

    if (confirm("Are you sure you want to delete this entry?")) {
        // Send the AJAX request to delete the entry
        fetch('delete_educations.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                serial_no: serialNo,
                employee_no: employeeNo  // Pass Employee_NO along with Serial_No
            }),
        })
            .then(response => response.json())
            .then(data => {
                // Check the response from the server
                if (data.success) {
                    console.log(`Employee_NO: ${data.employee_no}, Serial_No: ${data.serial_no}`);
                    alert('Entry deleted successfully.');

                    // Remove the row from the table after successful deletion
                    row.remove(); // This removes the row from the UI

                    // Update the serial numbers of the remaining rows
                    updateSerialNumbers();
                } else {
                    alert(`Failed to delete entry: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the entry. Please try again.');
            });
    }
}

// Function to update serial numbers of the remaining rows
function updateSerialNumbers() {
    const rows = document.querySelectorAll('table tbody tr');  // Select all rows in the table body
    let counter = 1;  // Start with 1

    rows.forEach(row => {
        const serialCell = row.querySelector('td:first-child');  // Select the first column where serial number is displayed
        const serialInput = row.querySelector('input[name="serial_no[]"]');  // Select the hidden serial number input

        // Update the displayed serial number and the hidden input value
        if (serialCell) serialCell.textContent = counter;
        if (serialInput) serialInput.value = counter;

        counter++;  // Increment the counter for the next row
    });
}


function copyBankDetails() {


    // Checkbox to copy details from Bank 1 to Bank 2
    const isChecked = document.getElementById('copyBankDetails1').checked;

    if (isChecked) {
        document.getElementById('bankName2').value = document.getElementById('bankName1').value;
        document.getElementById('branchName2').value = document.getElementById('branchName1').value;
        document.getElementById('accountNumber2').value = document.getElementById('accountNumber1').value;
        document.getElementById('ifscCode2').value = document.getElementById('ifscCode1').value;
    } else {
        document.getElementById('bankName2').value = '';
        document.getElementById('branchName2').value = '';
        document.getElementById('accountNumber2').value = '';
        document.getElementById('ifscCode2').value = '';
    }
}


// function calculateExpiryDate() {
//     const issueDateField = document.getElementById("passportIssueDate");
//     const expiryDateField = document.getElementById("passportExpiryDate");

//     const issueDateValue = issueDateField.value;

//     // Ensure an issue date is selected
//     if (!issueDateValue) {
//         expiryDateField.value = ""; // Clear expiry date if issue date is empty
//         return;
//     }

//     const issueDate = new Date(issueDateValue);

//     // Add 10 years to the issue date
//     const expiryDate = new Date(issueDate);
//     expiryDate.setFullYear(issueDate.getFullYear() + 10);

//     // Format the expiry date as dd-mm-yyyy
//     const day = String(expiryDate.getDate()).padStart(2, '0');
//     const month = String(expiryDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
//     const year = expiryDate.getFullYear();
//     const formattedExpiryDate = `${day}-${month}-${year}`;

//     // Set the expiry date field value
//     expiryDateField.value = formattedExpiryDate;
// }

// // Optional: Format the expiry date field value to dd-mm-yyyy when the user changes it manually
// document.getElementById("passportExpiryDate").addEventListener("input", function () {
//     const expiryDateField = this;

//     // Parse and reformat the value as dd-mm-yyyy
//     const parts = expiryDateField.value.split("-");
//     if (parts.length === 3) {
//         const day = parts[0].padStart(2, '0');
//         const month = parts[1].padStart(2, '0');
//         const year = parts[2];
//         expiryDateField.value = `${day}-${month}-${year}`;
//     }
// });

function validateYear(input) {
    const year = input.value.split('-')[0];
    if (year.length > 4) {
        input.value = '';
        alert('Year should only be four digits.');
    }
}

document.getElementById('bankName2').addEventListener('change', function () {
    const selectedBank = this.value.trim();

    // Get all dependent fields
    const branchName2 = document.getElementById('branchName2');
    const accountNumber2 = document.getElementById('accountNumber2');
    const ifscCode2 = document.getElementById('ifscCode2');

    // Get asterisk spans
    const branchNameRequired = document.querySelector('.branch-name-required');
    const accountNumberRequired = document.querySelector('.account-number-required');
    const ifscCodeRequired = document.querySelector('.ifsc-code-required');

    if (selectedBank !== "") {
        // Make fields required and show asterisks
        branchName2.setAttribute('required', 'true');
        accountNumber2.setAttribute('required', 'true');
        ifscCode2.setAttribute('required', 'true');

        branchNameRequired.style.display = 'inline';
        accountNumberRequired.style.display = 'inline';
        ifscCodeRequired.style.display = 'inline';
    } else {
        // Remove required attribute and hide asterisks
        branchName2.removeAttribute('required');
        accountNumber2.removeAttribute('required');
        ifscCode2.removeAttribute('required');

        branchNameRequired.style.display = 'none';
        accountNumberRequired.style.display = 'none';
        ifscCodeRequired.style.display = 'none';
    }
});


function setMinDate() {
    const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
    document.getElementById('visaExpiryDate').setAttribute('min', today);
}

function togglePassportFields() {
    const passportNumber = document.getElementById('passportNumber').value.trim();
    const passportIssueDate = document.getElementById('passportIssueDate');
    const passportExpiryDate = document.getElementById('passportExpiryDate');
    const usaVisa = document.getElementById('usaVisa');
    const requiredSpans = document.querySelectorAll('.passport-required');

    if (passportNumber !== "") {
        // Enable and make all related fields required
        passportIssueDate.style.pointerEvents = 'auto';
        passportExpiryDate.style.pointerEvents = 'auto';
        usaVisa.style.pointerEvents = 'auto';

        passportIssueDate.style.opacity = '1';
        passportExpiryDate.style.opacity = '1';
        usaVisa.style.opacity = '1';

        passportIssueDate.setAttribute('required', 'true');
        passportExpiryDate.setAttribute('required', 'true');
        usaVisa.setAttribute('required', 'true');

        // Show asterisks for related fields
        requiredSpans.forEach(span => span.style.display = 'inline');
    } else {
        // Disable and make all related fields optional
        passportIssueDate.style.pointerEvents = 'none';
        passportExpiryDate.style.pointerEvents = 'none';
        usaVisa.style.pointerEvents = 'none';

        passportIssueDate.style.opacity = '0.6';
        passportExpiryDate.style.opacity = '0.6';
        usaVisa.style.opacity = '0.6';

        passportIssueDate.value = "";
        passportExpiryDate.value = "";
        usaVisa.value = "";

        passportIssueDate.removeAttribute('required');
        passportExpiryDate.removeAttribute('required');
        usaVisa.removeAttribute('required');

        // Hide asterisks if the passport number is empty
        requiredSpans.forEach(span => span.style.display = 'none');
    }
}


document.getElementById('vehicleType').addEventListener('change', function () {
    // Get the fields
    const vehicleModel = document.getElementById('vehicleModel');
    const vehicleOwner = document.getElementById('vehicleOwner');
    const registrationNumber = document.getElementById('registrationNumber');
    const insuranceProvider = document.getElementById('insuranceProvider');

    // Get the asterisk spans
    const vehicleModelRequired = document.querySelector('.vehicle-model-required');
    const vehicleOwnerRequired = document.querySelector('.vehicle-owner-required');
    const registrationNumberRequired = document.querySelector('.registration-number-required');
    const insuranceProviderRequired = document.querySelector('.insurance-provider-required');

    if (this.value !== "") {
        // Enable fields and make required
        vehicleModel.removeAttribute('disabled');
        vehicleOwner.removeAttribute('disabled');
        registrationNumber.removeAttribute('disabled');
        insuranceProvider.removeAttribute('disabled');

        vehicleModel.setAttribute('required', 'true');
        vehicleOwner.setAttribute('required', 'true');
        registrationNumber.setAttribute('required', 'true');
        insuranceProvider.setAttribute('required', 'true');

        vehicleModelRequired.style.display = 'inline';
        vehicleOwnerRequired.style.display = 'inline';
        registrationNumberRequired.style.display = 'inline';
        insuranceProviderRequired.style.display = 'inline';
    } else {
        // Disable fields and remove required attribute
        vehicleModel.setAttribute('disabled', 'true');
        vehicleOwner.setAttribute('disabled', 'true');
        registrationNumber.setAttribute('disabled', 'true');
        insuranceProvider.setAttribute('disabled', 'true');

        vehicleModel.removeAttribute('required');
        vehicleOwner.removeAttribute('required');
        registrationNumber.removeAttribute('required');
        insuranceProvider.removeAttribute('required');

        vehicleModelRequired.style.display = 'none';
        vehicleOwnerRequired.style.display = 'none';
        registrationNumberRequired.style.display = 'none';
        insuranceProviderRequired.style.display = 'none';

        // Clear values when disabled
        vehicleModel.value = '';
        vehicleOwner.value = '';
        registrationNumber.value = '';
        insuranceProvider.value = '';
    }
});

// On page load, ensure fields are disabled
window.onload = function () {
    document.getElementById('vehicleModel').setAttribute('disabled', 'true');
    document.getElementById('vehicleOwner').setAttribute('disabled', 'true');
    document.getElementById('registrationNumber').setAttribute('disabled', 'true');
    document.getElementById('insuranceProvider').setAttribute('disabled', 'true');
};


function toggleVisaExpiryDate() {
    const usaVisa = document.getElementById("usaVisa").value;
    const visaExpiryDate = document.getElementById("visaExpiryDate");
    const visaRequiredSpan = document.querySelector('.visa-required'); // Select the asterisk span for visa expiry

    if (usaVisa === "Yes") {
        // Enable the visa expiry date field
        visaExpiryDate.style.pointerEvents = 'auto'; // Allow interaction
        visaExpiryDate.style.opacity = '1'; // Set opacity to visible
        visaExpiryDate.setAttribute('required', 'true'); // Make it required

        // Show the asterisk for visa expiry date
        visaRequiredSpan.style.display = 'inline';
    } else {
        // Disable the visa expiry date field
        visaExpiryDate.style.pointerEvents = 'none'; // Prevent interaction
        visaExpiryDate.style.opacity = '0.6'; // Set opacity to visually indicate it's disabled
        visaExpiryDate.value = ""; // Clear the value
        visaExpiryDate.removeAttribute('required'); // Remove the required attribute

        // Hide the asterisk for visa expiry date
        visaRequiredSpan.style.display = 'none';
    }
}


function toggleInsuranceFields() {
    const insuranceProvider = document.getElementById('insuranceProvider').value.trim();
    const insuranceExpiry = document.getElementById('insuranceExpiry');
    const insuranceExpiryRequired = document.querySelector('.insurance-expiry-required');

    if (insuranceProvider !== "") {
        // Enable the expiry date field
        insuranceExpiry.style.pointerEvents = 'auto';
        insuranceExpiry.style.opacity = '1'; // Highlight the field
        insuranceExpiry.setAttribute('required', 'true'); // Make it required
        insuranceExpiryRequired.style.display = 'inline'; // Show the asterisk
    } else {
        // Disable the expiry date field
        insuranceExpiry.style.pointerEvents = 'none';
        insuranceExpiry.style.opacity = '0.6'; // Dim the field
        insuranceExpiry.value = ""; // Clear any existing value
        insuranceExpiry.removeAttribute('required'); // Remove the required attribute
        insuranceExpiryRequired.style.display = 'none'; // Hide the asterisk
    }
}




function calculateExpiryDate() {
    // Get the issue date input value
    const issueDateInput = document.getElementById('passportIssueDate');
    const expiryDateInput = document.getElementById('passportExpiryDate');

    // Parse the issue date
    const issueDate = new Date(issueDateInput.value);

    // Check if the issue date is valid
    if (issueDate && !isNaN(issueDate)) {
        // Set the expiry date to 10 years from the issue date
        const expiryDate = new Date(issueDate);
        expiryDate.setFullYear(expiryDate.getFullYear() + 10);

        // Format the date to YYYY-MM-DD for the input field
        const year = expiryDate.getFullYear();
        const month = String(expiryDate.getMonth() + 1).padStart(2, '0');
        const day = String(expiryDate.getDate()).padStart(2, '0');

        // Update the expiry date input
        expiryDateInput.value = `${year}-${month}-${day}`;
    } else {
        // If the issue date is invalid, clear the expiry date
        expiryDateInput.value = '';
    }
}


// function convertToUppercase(inputFieldId) {
//     const inputField = document.getElementById(inputFieldId);
//     inputField.value = inputField.value.toUpperCase();
// }

function validateAccountNumber(input) {
    input.value = input.value.replace(/[^A-Za-z0-9]/g, '');
    if (input.value.length > 18) {
        input.value = input.value.slice(0, 18);
    }
}

function validateIFSC(input) {
    input.value = input.value.toUpperCase();
    input.value = input.value.replace(/[^A-Z0-9]/g, '');
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const vehicleModelInput = document.getElementById("vehicleModel");
    const vehicleModelError = document.getElementById("vehicleModelError");

    vehicleModelInput.addEventListener("input", function () {
        validateVehicleModel(vehicleModelInput);
    });

    function validateVehicleModel(input) {
        if (input.value.trim() === "") {
            vehicleModelError.textContent = "Vehicle Model cannot be empty.";
            input.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            vehicleModelError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const employeeNo = "<?php echo $_SESSION['employee_no']; ?>";
    console.log("Employee_NO from session:", employeeNo);

    // Function to remove family row
    function removeFamilyRow(button) {
        const row = button.closest('tr');
        const serialNoElement = row.querySelector('input[name="serial_no[]"]');

        // Validate row and serialNo
        if (!row || !serialNoElement) {
            console.error("Row or Serial_No element not found.");
            return;
        }

        const serialNo = serialNoElement.value;
        console.log("Serial_No to delete:", serialNo);
        console.log("Employee_No:", employeeNo);

        if (confirm("Are you sure you want to delete this entry?")) {
            // Send AJAX request
            fetch('delete_family.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    serial_no: serialNo,
                    employee_no: employeeNo
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`Employee_NO: ${data.employee_no}, Serial_No: ${data.serial_no}`);
                        alert('Family entry deleted successfully.');

                        // Remove the row and update serial numbers
                        row.remove();
                        updateFamilySerialNumbers();
                    } else {
                        alert(`Failed to delete entry: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the entry. Please try again.');
                });
        }
    }

    // // Update serial numbers
    // function updateFamilySerialNumbers() {
    //     const rows = document.querySelectorAll('#familyTableBody tr');
    //     let counter = 1;

    //     rows.forEach((row) => {
    //         row.querySelector('td:first-child').innerText = counter;
    //         row.querySelector('input[name="serial_no[]"]').value = counter;
    //         counter++;
    //     });
    // }

    // Expose the function globally
    window.removeFamilyRow = removeFamilyRow;
});


function limitSalaryInput(input) {
    // Allow only numbers in the input
    input.value = input.value.replace(/[^0-9]/g, '');
}

function formatSalary(input) {
    // Format the input as a currency-like value
    if (input.value) {
        input.value = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 0,
        }).format(input.value);
    }
}

function alignSalary(input) {
    // Keep the cursor aligned to the right while typing
    const value = input.value;
    input.value = ''; // Clear the input temporarily
    input.value = value; // Reassign the value to keep the cursor at the end
}


function limitSalaryInput(input) {
    // Allow only numbers and the decimal point while typing.
    let cursorPosition = input.selectionStart;
    let value = input.value.replace(/[^0-9.]/g, '');

    // Restrict only one decimal point
    if (value.split('.').length > 2) {
        value = value.slice(0, value.lastIndexOf('.'));
    }

    // Update the input with the limited value while keeping cursor position
    input.value = value;
    input.selectionStart = cursorPosition;
    input.selectionEnd = cursorPosition;
}

function formatSalary(input) {
    let value = input.value;

    // If there is a value, ensure it has two decimal places
    if (value) {
        if (!value.includes('.')) {
            value += '.00'; // Add .00 if no decimal exists
        } else {
            let parts = value.split('.');
            if (parts[1].length === 1) {
                value += '0'; // If only one decimal place, add another zero
            }
        }
    } else {
        value = '0.00'; // If empty, set the default value
    }

    // Update the input with the formatted value
    input.value = value;
}




function calculateExperience(input) {
    // Get the row where the change occurred
    const row = input.closest('tr');

    // Get the from_date and to_date fields in the row
    const fromDateField = row.querySelector('input[name="from_date[]"]');
    const toDateField = row.querySelector('input[name="to_date[]"]');
    const experienceField = row.querySelector('input[name="relevant_experience[]"]');

    // Ensure both fields are filled and valid before processing
    if (fromDateField.value && toDateField.value) {
        const fromDate = new Date(fromDateField.value);
        const toDate = new Date(toDateField.value);

        // Check if the date is valid by checking the full year length and if both dates are correctly entered
        if (isValidDate(fromDate) && isValidDate(toDate)) {
            // Validate that 'from_date' is before 'to_date'
            if (fromDate <= toDate) {
                let years = toDate.getFullYear() - fromDate.getFullYear();
                let months = toDate.getMonth() - fromDate.getMonth();
                let days = toDate.getDate() - fromDate.getDate();

                // Adjust for negative days
                if (days < 0) {
                    months -= 1;
                    const lastDayOfPreviousMonth = new Date(toDate.getFullYear(), toDate.getMonth(), 0).getDate();
                    days += lastDayOfPreviousMonth;
                }

                // Adjust for negative months
                if (months < 0) {
                    years -= 1;
                    months += 12;
                }

                // Format the result
                experienceField.value = `${years} years, ${months} months, and ${days} days`;
            } else {
                experienceField.value = ''; // Clear the field if the dates are invalid
                alert("'From Date' must be earlier than 'To Date'. Please correct the dates.");
            }
        } else {
            experienceField.value = ''; // Clear the field if the dates are invalid
            alert("Please enter valid dates for both 'From Date' and 'To Date' in the format YYYY-MM-DD.");
        }
    }
}

// Helper function to check if the date is valid (checks if year is four digits)
function isValidDate(date) {
    return date instanceof Date && !isNaN(date);
}


document.addEventListener("DOMContentLoaded", () => {
    // Assuming employee_no is already set from PHP session
    const employeeNo = "<?php echo $_SESSION['employee_no']; ?>";
    console.log("Employee_NO from session:", employeeNo);

    // Function to remove employment row from the table and delete from the database
    function removeEmploymentRow(button) {
        const row = button.closest('tr'); // Get the row of the button clicked
        const serialNoElement = row.querySelector('input[name="serial_no[]"]'); // Find the Serial_No input field

        // Validate row and serialNo
        if (!row || !serialNoElement) {
            console.error("Row or Serial_No element not found.");
            return;
        }

        const serialNo = serialNoElement.value; // Get the Serial_No value
        console.log("Serial_No to delete:", serialNo);
        console.log("Employee_No:", employeeNo);

        if (confirm("Are you sure you want to delete this employment entry?")) {
            // Send the AJAX request to delete the entry
            fetch('delete_employment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    serial_no: serialNo,
                    employee_no: employeeNo
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`Employee_NO: ${data.employee_no}, Serial_No: ${data.serial_no}`);
                        alert('Employment entry deleted successfully.');

                        // Remove the row from the table
                        row.remove();

                        // Update the serial numbers of the remaining rows
                        updateEmploymentSerialNumbers();
                    } else {
                        alert(`Failed to delete employment entry: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the employment entry. Please try again.');
                });
        }
    }

    // Update serial numbers after row deletion
    function updateEmploymentSerialNumbers() {
        const rows = document.querySelectorAll('#employmentTableBody tr'); // Select all rows in the employment table body
        let counter = 1;

        rows.forEach((row) => {
            row.querySelector('td:first-child').innerText = counter; // Update the visible serial number
            row.querySelector('input[name="serial_no[]"]').value = counter; // Update the hidden serial number
            counter++;
        });

        // Reset counter for the next addition
        employmentCounter = counter;
    }

    // Expose the function globally so it can be used with onclick
    window.removeEmploymentRow = removeEmploymentRow;
});

function validatePassportNumber(input) {
    // Remove any non-alphanumeric characters
    input.value = input.value.replace(/[^A-Za-z0-9]/g, '');

    // Limit the input to the maximum length (e.g., 9 characters)
    if (input.value.length > 9) {
        input.value = input.value.slice(0, 9);
    }
}

// Function to fetch countries and populate the dropdown
async function populateCountries() {
    const countryDropdown = document.getElementById('country');
    try {
        const response = await fetch('https://restcountries.com/v3.1/all');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const countries = await response.json();

        // Sort countries alphabetically by name
        countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

        // Populate dropdown
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.cca2; // Use country code as the value
            option.textContent = country.name.common; // Display country name
            countryDropdown.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching countries:', error);
    }
}

// Call the function to populate the dropdown on page load
document.addEventListener('DOMContentLoaded', populateCountries);







function calculateExpiryDate() {
    // Get the issue date input value
    const issueDateInput = document.getElementById('passportIssueDate');
    const expiryDateInput = document.getElementById('passportExpiryDate');

    // Parse the issue date
    const issueDate = new Date(issueDateInput.value);

    // Check if the issue date is valid
    if (issueDate && !isNaN(issueDate)) {
        // Set the expiry date to 10 years from the issue date
        const expiryDate = new Date(issueDate);
        expiryDate.setFullYear(expiryDate.getFullYear() + 10);

        // Subtract one day
        expiryDate.setDate(expiryDate.getDate() - 1);

        // Format the date to YYYY-MM-DD for the input field
        const year = expiryDate.getFullYear();
        const month = String(expiryDate.getMonth() + 1).padStart(2, '0');
        const day = String(expiryDate.getDate()).padStart(2, '0');

        // Update the expiry date input
        expiryDateInput.value = `${year}-${month}-${day}`;

        // Display output in the console
        console.log(`Issue Date: ${issueDateInput.value}`);
        console.log(`Expiry Date (10 years - 1 day): ${expiryDateInput.value}`);
    } else {
        // If the issue date is invalid, clear the expiry date
        expiryDateInput.value = '';
    }
}







// Get today's date
const today = new Date();
// Subtract one day to set the max date to yesterday
const yesterday = new Date(today);
yesterday.setDate(today.getDate() - 1);

// Format yesterday's date to yyyy-mm-dd
const maxDateYesterday = yesterday.toISOString().split('T')[0];

// Set the max attribute of the date input
document.getElementById('insuranceExpiry').setAttribute('max', maxDate);




function handleFileUpload(input) {
    // Dynamically find the correct file preview container
    const filePreviewContainer = input.nextElementSibling;
    filePreviewContainer.innerHTML = ''; // Clear any existing previews
    const files = input.files;

    if (files.length === 0) {
        filePreviewContainer.innerHTML = '<p>No files selected.</p>';
        return;
    }

    Array.from(files).forEach((file) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const docType = file.type.split('/')[0];
            const fileSize = Math.round(file.size / 1024); // Size in KB

            // Create a clickable file name
            const fileEntry = document.createElement('div');
            fileEntry.innerHTML = `
                <span style="cursor: pointer; color: blue; text-decoration: underline;" 
                      onclick="previewFile('${e.target.result}', '${file.name}', '${docType}', '${filePreviewContainer.className}')">
                    ${file.name} (Size: ${fileSize} KB)
                </span>`;
            filePreviewContainer.appendChild(fileEntry);
        };

        reader.readAsDataURL(file);
    });
}

function previewFile(fileSrc, fileName, docType, previewContainerClass) {
    const previewContainer = document.querySelector(`.${previewContainerClass}`);
    previewContainer.innerHTML = ''; // Clear previous previews

    if (docType === 'image') {
        // Display the image
        previewContainer.innerHTML = `
            <img src="${fileSrc}" alt="${fileName}" 
                 style="max-width: 300px; max-height: 300px; margin-top: 10px;" />
        `;
    } else {
        // Display a message for non-image files
        previewContainer.innerHTML = `
            <p>This file (${fileName}) is not an image and cannot be previewed.</p>
        `;
    }
}

function handleSubmit() {
    alert("Form submitted!"); // Demonstration alert
    // Implement form data collection and submission logic here
}

// JavaScript for tab functionality
const tabElements = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab-content');

tabElements.forEach(tab => {
    tab.addEventListener('click', () => {
        const activeTab = document.querySelector('.tab.active');
        const activeContent = document.querySelector('.tab-content.active');

        activeTab.classList.remove('active');
        activeContent.classList.remove('active');

        tab.classList.add('active');
        const contentId = tab.getAttribute('data-tab');
        document.getElementById(contentId).classList.add('active');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Get today's date
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start from 0
    let dd = today.getDate();

    // Format the date to YYYY-MM-DD
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    const todayFormatted = yyyy + '-' + mm + '-' + dd;

    // Set the max attribute of the date picker to today's date
    const joiningDateField = document.getElementById("joiningDate");
    joiningDateField.max = todayFormatted; // Restrict selection to today's date or earlier
});


document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("emailID");
    const emailError = document.getElementById("emailIDError");

    emailInput.addEventListener("input", function () {
        // Validate input
        validateEmail();
    });

    function validateEmail() {
        const pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Regex for valid email

        if (!pattern.test(emailInput.value)) {
            emailError.textContent = "Please enter a valid email address. Format: example@domain.com";
            emailInput.setCustomValidity("Invalid"); // Set custom validity for form submission
        } else {
            emailError.textContent = ""; // Clear error message
            emailInput.setCustomValidity(""); // Clear custom validity
        }
    }

    // Optionally, validate when the user leaves the input field (on blur)
    emailInput.addEventListener("blur", function () {
        validateEmail();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const vehicleOwnerInput = document.getElementById("vehicleOwner");
    const vehicleOwnerError = document.getElementById("vehicleOwnerError");

    vehicleOwnerInput.addEventListener("input", function () {
        validateVehicleOwner(vehicleOwnerInput);
    });

    function validateVehicleOwner(input) {
        if (input.value.trim() === "") {
            vehicleOwnerError.textContent = "Vehicle Owner cannot be empty.";
            input.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            vehicleOwnerError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const insuranceProviderInput = document.getElementById("insuranceProvider");
    const insuranceProviderError = document.getElementById("insuranceProviderError");

    insuranceProviderInput.addEventListener("input", function () {
        validateInsuranceProvider(insuranceProviderInput);
    });

    function validateInsuranceProvider(input) {
        const pattern = /^[a-zA-Z0-9 ]*$/; // Alphanumeric characters and spaces allowed
        if (!pattern.test(input.value)) {
            insuranceProviderError.textContent = "Only letters, numbers, and spaces are allowed.";
            input.value = input.value.replace(/[^a-zA-Z0-9 ]/g, ""); // Remove invalid characters
        } else {
            insuranceProviderError.textContent = ""; // Clear error message
        }
    }
});

// Function to fetch country data from the API
async function fetchCountries() {
    try {
        const response = await fetch('https://restcountries.com/v3.1/all?fields=name,flags');
        const countries = await response.json();
        const issuingCountrySelect = document.getElementById('issuingCountry');

        // Populate dropdown options
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name.common; // Use common name as the value
            option.textContent = country.name.common; // Display country name

            // Set "India" as the default selected option
            if (country.name.common === 'India') {
                option.selected = true;
            }

            issuingCountrySelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching countries:', error);
    }
}

// Call the function to fetch countries when the page loads
document.addEventListener('DOMContentLoaded', fetchCountries);

function calculateExpiryDate() {
    const issueDateInput = document.getElementById("passportIssueDate");
    const expiryDateInput = document.getElementById("passportExpiryDate");
    const issueDateError = document.getElementById("passportIssueDateError");
    const expiryDateError = document.getElementById("passportExpiryDateError");

    // Clear previous error messages
    issueDateError.textContent = '';
    expiryDateError.textContent = '';

    const issueDate = new Date(issueDateInput.value);

    if (issueDate) {
        // Calculate expiry date (10 years later)
        const expiryDate = new Date(issueDate);
        expiryDate.setFullYear(issueDate.getFullYear() + 10);

        // Set the calculated expiry date to the input
        expiryDateInput.value = expiryDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
    }
}

let currentTab = 0; // Index of the current tab
const tabs = document.querySelectorAll('.tab-button');
const tabPanes = document.querySelectorAll('.tab-pane');

function showTab(index) {
    // Hide all tab panes and remove 'active' class from buttons
    tabPanes.forEach((pane) => pane.classList.remove('active'));
    tabs.forEach((tab) => tab.classList.remove('active'));

    // Show the current tab and add 'active' class to the corresponding button
    tabPanes[index].classList.add('active');
    tabs[index].classList.add('active');
}

function showNextTab() {
    if (currentTab < tabs.length - 1) {
        currentTab++;
        showTab(currentTab);
    }
}

function showPreviousTab() {
    if (currentTab > 0) {
        currentTab--;
        showTab(currentTab);
    }
}

// Initialize the first tab
showTab(currentTab);



// Function to fetch bank names and populate a dropdown
function populateBankDropdown(dropdownId) {
    fetch('fetch_bank_names.php')
        .then(response => response.json())
        .then(data => {
            const bankDropdown = document.getElementById(dropdownId);
            data.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank;
                option.textContent = bank;
                bankDropdown.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching bank names:', error);
        });
}

// Populate both dropdowns on window load
window.onload = function () {
    populateBankDropdown('bankName1');
    populateBankDropdown('bankName2');
}

document.addEventListener("DOMContentLoaded", function () {
    const passportNumberInput = document.getElementById("passportNumber");
    const passportNumberError = document.getElementById("passportNumberError");

    // Validate Passport Number
    passportNumberInput.addEventListener("input", function () {
        validatePassportNumber(passportNumberInput);
    });

    // Passport Number Validation Function
    function validatePassportNumber(input) {
        const pattern = /^[A-Za-z0-9]{1,9}$/; // Passport number pattern (alphanumeric, 1-9 characters)
        if (!pattern.test(input.value)) {
            passportNumberError.textContent = "Please enter a valid Passport Number (alphanumeric, 1-9 characters).";
            input.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            passportNumberError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }

    // Optionally, validate when the user leaves the input field (on blur)
    passportNumberInput.addEventListener("blur", function () {
        validatePassportNumber(passportNumberInput);
    });
});


// Function to validate uppercase requirement and convert input to uppercase
function validateUppercaseInput(inputFieldId, errorFieldId) {
    const inputField = document.getElementById(inputFieldId);
    const errorMessage = document.getElementById(errorFieldId);

    // Convert input to uppercase
    inputField.value = inputField.value.toUpperCase();

    // Check if the value matches the pattern
    const hasUppercase = /[A-Z]/.test(inputField.value);

    if (!hasUppercase) {
        errorMessage.textContent = `${inputFieldId.replace(/([A-Z])/g, ' $1')} must contain at least one uppercase letter.`;
        inputField.setCustomValidity('Invalid'); // Set custom validity to prevent form submission
    } else {
        errorMessage.textContent = ''; // Clear error message
        inputField.setCustomValidity(''); // Clear custom validity
    }
}

// Attach input event listeners to both address fields
document.getElementById('permanentAddress').addEventListener('input', function () {
    validateUppercaseInput('permanentAddress', 'permanentAddressError');
});

document.getElementById('correspondenceAddress').addEventListener('input', function () {
    validateUppercaseInput('correspondenceAddress', 'correspondenceAddressError');
});

// Function to convert input to uppercase
function convertToUppercase(inputFieldId) {
    const inputField = document.getElementById(inputFieldId);
    // Convert input to uppercase
    inputField.value = inputField.value.toUpperCase();
}

// Attach input event listener to the emergency contact name field
document.getElementById('emergencyContactName').addEventListener('input', function () {
    convertToUppercase('emergencyContactName');
});

document.addEventListener("DOMContentLoaded", function () {
    const accountNumberInput = document.getElementById("accountNumber2");
    const accountNumberError = document.getElementById("accountNumber2Error");

    const ifscCodeInput = document.getElementById("ifscCode2");
    const ifscCodeError = document.getElementById("ifscCode2Error");

    // Validate Account Number
    accountNumberInput.addEventListener("input", function () {
        validateAccountNumber(accountNumberInput);
    });

    // Account Number Validation Function
    function validateAccountNumber(input) {
        const isValid = input.value.length >= 9 && input.value.length <= 18; // Alphanumeric, 9-18 characters
        if (!isValid) {
            accountNumberError.textContent = "Please enter a valid Account Number (9-18 characters).";
            input.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            accountNumberError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }

    // Validate IFSC Code
    ifscCodeInput.addEventListener("input", function () {
        validateIFSC(ifscCodeInput);
    });

    // IFSC Code Validation Function
    function validateIFSC(input) {
        const isValid = input.value.length === 11; // Max length is 11 characters
        if (!isValid) {
            ifscCodeError.textContent = "Enter a valid IFSC Code (11 characters)."; // Updated error message
            input.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            ifscCodeError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }

    // Enforce max length for IFSC Code
    ifscCodeInput.addEventListener("input", function () {
        if (ifscCodeInput.value.length > 11) {
            ifscCodeInput.value = ifscCodeInput.value.slice(0, 11); // Trim to max length
        }
    });

    // Optionally, validate when the user leaves the input field (on blur)
    accountNumberInput.addEventListener("blur", function () {
        validateAccountNumber(accountNumberInput);
    });

    ifscCodeInput.addEventListener("blur", function () {
        validateIFSC(ifscCodeInput);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const accountNumberInput = document.getElementById("accountNumber1");
    const accountNumberError = document.getElementById("accountNumber1Error");

    const ifscCodeInput = document.getElementById("ifscCode1");
    const ifscCodeError = document.getElementById("ifscCode1Error");

    // Validate Account Number on input
    accountNumberInput.addEventListener("input", function () {
        validateAccountNumber(accountNumberInput);
    });

    // Validate IFSC Code on input
    ifscCodeInput.addEventListener("input", function () {
        validateIFSC(ifscCodeInput);
    });

    // Account Number Validation (length between 9 and 18 characters)
    function validateAccountNumber(input) {
        const isValid = input.value.length >= 9 && input.value.length <= 18; // Alphanumeric, 9-18 characters
        if (!isValid) {
            accountNumberError.textContent = "Please enter a valid Account Number (9-18 characters).";
            input.setCustomValidity("Invalid");
        } else {
            accountNumberError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }

    // IFSC Code Validation (length of 11 characters)
    function validateIFSC(input) {
        const isValid = input.value.length === 11; // IFSC Code must be 11 characters long
        if (!isValid) {
            ifscCodeError.textContent = "Enter a valid IFSC Code (11 characters).";
            input.setCustomValidity("Invalid");
        } else {
            ifscCodeError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }

    // Enforce max length for IFSC Code
    ifscCodeInput.addEventListener("input", function () {
        if (ifscCodeInput.value.length > 11) {
            ifscCodeInput.value = ifscCodeInput.value.slice(0, 11); // Trim to max length
        }
    });

    // Optionally, validate when the user leaves the input field (on blur)
    accountNumberInput.addEventListener("blur", function () {
        validateAccountNumber(accountNumberInput);
    });

    ifscCodeInput.addEventListener("blur", function () {
        validateIFSC(ifscCodeInput);
    });
});

// Function to validate the vehicle registration number
function validateRegistrationNumber() {
    const registrationNumberField = document.getElementById('registrationNumber');
    const errorField = document.getElementById('registrationNumberError');

    // Clear previous error message
    errorField.textContent = '';

    // Check if the registration number is valid
    const isValid = /^[A-Z0-9]{1, 7}$/.test(registrationNumberField.value);
    if (!isValid) {
        errorField.textContent = 'Invalid vehicle registration number. Use 1-7 alphanumeric characters.';
    }
}

// Attach input event listener for validation
document.getElementById('registrationNumber').addEventListener('input', validateRegistrationNumber);

document.addEventListener("DOMContentLoaded", function () {
    const registrationNumberInput = document.getElementById("registrationNumber");
    const registrationNumberError = document.getElementById("registrationNumberError");

    // Validate the Vehicle Number
    registrationNumberInput.addEventListener("input", function () {
        validateRegistrationNumber(registrationNumberInput);
    });

    // Registration Number Validation Function
    function validateRegistrationNumber(input) {
        const pattern = /^[A-Z]{2}[0-9]{2}\s?[A-Z]{2}\s?[0-9]{4}$/; // Vehicle number format
        if (!pattern.test(input.value)) {
            registrationNumberError.textContent = "Please enter a valid Vehicle Number (e.g., KA01 AB 1234).";
            input.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            registrationNumberError.textContent = ""; // Clear error message
            input.setCustomValidity(""); // Clear custom validity
        }
    }

    // Optionally, validate when the user leaves the input field (on blur)
    registrationNumberInput.addEventListener("blur", function () {
        validateRegistrationNumber(registrationNumberInput);
    });
});


function validateUAN(input) {
    const uanError = document.getElementById('uanError');
    const uanPattern = /^\d{16}$/; // Regex for exactly 16 digits

    // Clear previous error message
    uanError.innerText = '';

    // Validate UAN only if input is provided
    if (input.value.length > 16) {
        uanError.innerText = 'UAN cannot exceed 16 digits.';
    } else if (input.value && !uanPattern.test(input.value)) {
        uanError.innerText = 'UAN must be numeric and 16 digits long.';
    }
}

function isNumberKey(evt) {
    const charCode = evt.which ? evt.which : evt.keyCode;
    // Allow only numbers
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault(); // Prevent non-numeric input
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const providentFundInput = document.getElementById("providentFund");
    const providentFundError = document.getElementById("providentFundError");

    providentFundInput.addEventListener("input", function () {
        // Convert input to uppercase
        this.value = this.value.toUpperCase();

        // Validate input only if input is provided
        if (this.value) {
            validateProvidentFund();
        } else {
            providentFundError.textContent = ""; // Clear error if input is empty
            providentFundInput.setCustomValidity(""); // Clear custom validity
        }
    });

    function validateProvidentFund() {
        const pattern = /^[A-Z0-9]{1,18}$/; // Regex for alphanumeric, max 18 characters
        if (!pattern.test(providentFundInput.value)) {
            // If the value is invalid, show error message
            providentFundError.textContent = "Please enter a valid Provident Fund (alphanumeric, max 18 characters).";
            providentFundInput.setCustomValidity("Invalid"); // Set custom validity for form submission
        } else {
            // If the value is valid, clear the error message
            providentFundError.textContent = "";
            providentFundInput.setCustomValidity(""); // Clear custom validity
        }
    }

    providentFundInput.addEventListener("blur", function () {
        // Trigger validation on blur (only if input is provided)
        if (this.value) {
            validateProvidentFund();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const esicInput = document.getElementById("esicNo");
    const esicError = document.getElementById("esicNoError");

    esicInput.addEventListener("input", function () {
        // Validate input only if input is provided
        if (this.value) {
            validateEsic();
        } else {
            esicError.textContent = ""; // Clear error if input is empty
            esicInput.setCustomValidity(""); // Clear custom validity
        }
    });

    function validateEsic() {
        const pattern = /^[a-zA-Z0-9]{1,18}$/; // Regex for alphanumeric input, max 18 characters
        if (!pattern.test(esicInput.value)) {
            esicError.textContent = "Please enter a valid ESIC Number (alphanumeric, max 18 characters).";
            esicInput.setCustomValidity("Invalid"); // Custom validity for form submission
        } else {
            esicError.textContent = ""; // Clear error message
            esicInput.setCustomValidity(""); // Clear custom validity
        }
    }

    esicInput.addEventListener("blur", function () {
        // Trigger validation when user leaves the input field (only if input is provided)
        if (this.value) {
            validateEsic();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll('.step'); // Steps in the header
    const tabContents = document.querySelectorAll('.tab-content'); // Tab contents for each step
    let currentStepIndex = 0; // Start with the first step

    // Function to display a specific step
    function showStep(index) {
        // Update active tab content
        tabContents.forEach((content, i) => {
            content.classList.toggle('active', i === index);
        });

        // Update active steps in the header
        steps.forEach((step, i) => {
            step.classList.toggle('active', i <= index);
        });

        currentStepIndex = index; // Update current step index
    }

    // Initialize by showing the first step
    showStep(currentStepIndex);

    // Add event listeners to each step for direct navigation
    steps.forEach((step, index) => {
        step.addEventListener('click', function () {
            showStep(index); // Navigate directly to the clicked step
        });
    });

    // Add event listeners for Previous and Next buttons
    document.querySelectorAll('.previous-btn').forEach((btn) => {
        btn.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent form submission
            if (currentStepIndex > 0) {
                currentStepIndex--; // Move to the previous step
                showStep(currentStepIndex);
            }
        });
    });

    document.querySelectorAll('.next-btn').forEach((btn) => {
        btn.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent form submission
            const currentForm = tabContents[currentStepIndex]?.querySelector('form');

            if (currentForm && currentForm.checkValidity()) {
                const formData = new FormData(currentForm); // Serialize form data

                fetch('submit_step.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then((data) => {
                        console.log('Server response:', data);
                        if (currentStepIndex < steps.length - 1) {
                            currentStepIndex++; // Move to the next step
                            showStep(currentStepIndex);
                        } else {
                            window.location.href = '../login/login.php'; // Redirect after final step
                        }
                    })
                    .catch((error) => {
                        console.error('Error submitting form:', error);
                    });
            } else {
                console.log('Invalid form fields detected.');
                currentForm.querySelectorAll(':invalid').forEach((input) => {
                    // input.style.border = '2px solid red'; // Highlight invalid inputs
                });
                currentForm.reportValidity(); // Show validation error messages
            }
        });
    });
});


