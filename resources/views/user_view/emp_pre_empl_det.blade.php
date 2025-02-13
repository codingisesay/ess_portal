<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Experience Form</title>
    <style>
        .form-container {
            margin-top: 20px;
        }
        .form-entry {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin: 10px;
        }
    </style>
</head>
<body>

    <h1>Work Experience Form</h1>
    
    <!-- Button to add new work experience -->
    <button id="addWorkExperienceBtn">Add Work Experience</button>
    
    <!-- Container where work experience entries will be added -->
    <div id="workExperienceEntries" class="form-container"></div>
    <a href="{{ route('user.dashboard') }}" class="btn btn-success">dashboard</a>
    <script>
        const addWorkExperienceBtn = document.getElementById("addWorkExperienceBtn");
        const workExperienceEntries = document.getElementById("workExperienceEntries");

        // Function to add a new work experience entry
        function addWorkExperienceForm() {
            const workExperienceEntry = document.createElement("div");
            workExperienceEntry.classList.add("form-entry");
            workExperienceEntry.innerHTML = `
                <label>Employer Name:</label>
                <input type="text" class="employer-name" placeholder="Enter Employer Name" required><br>
                
                <label>Country:</label>
                <select class="country" required>
                    <option value="">Select Country</option>
                    <option value="USA">USA</option>
                    <option value="India">India</option>
                    <option value="Canada">Canada</option>
                    <!-- Add more countries as needed -->
                </select><br>

                <label>City:</label>
                <input type="text" class="city" placeholder="Enter City" required><br>

                <label>From Date:</label>
                <input type="date" class="from-date" required><br>

                <label>To Date:</label>
                <input type="date" class="to-date" required><br>

                <label>Designation:</label>
                <input type="text" class="designation" placeholder="Enter Designation" required><br>

                <label>Last Drawn Annual Salary:</label>
                <input type="number" class="salary" placeholder="Enter Salary" required><br>

                <label>Relevant Experience:</label>
                <input type="text" class="relevant-experience" disabled><br>

                <label>Reason for Leaving:</label>
                <input type="text" class="reason-for-leaving" placeholder="Enter Reason for Leaving" required><br>

                <label>Major Responsibilities:</label>
                <textarea class="major-responsibilities" placeholder="Enter Major Responsibilities" required></textarea><br>
            `;
            workExperienceEntries.appendChild(workExperienceEntry);

            // Validate City field for alphabets only
            const cityInput = workExperienceEntry.querySelector(".city");
            cityInput.addEventListener("input", function() {
                if (!/^[a-zA-Z\s]*$/.test(cityInput.value)) {
                    alert("City should only contain alphabets.");
                    cityInput.setCustomValidity("City should only contain alphabets.");
                } else {
                    cityInput.setCustomValidity("");
                }
            });

            // Ensure From Date is earlier than To Date
            const fromDateInput = workExperienceEntry.querySelector(".from-date");
            const toDateInput = workExperienceEntry.querySelector(".to-date");
            toDateInput.addEventListener("change", function() {
                if (new Date(fromDateInput.value) > new Date(toDateInput.value)) {
                    alert("From Date must be earlier than To Date.");
                    toDateInput.setCustomValidity("From Date must be earlier than To Date.");
                } else {
                    toDateInput.setCustomValidity("");
                }
            });

            // Calculate Relevant Experience based on From Date and To Date
            fromDateInput.addEventListener("change", calculateRelevantExperience);
            toDateInput.addEventListener("change", calculateRelevantExperience);

            function calculateRelevantExperience() {
                const relevantExperienceField = workExperienceEntry.querySelector(".relevant-experience");
                const fromDate = new Date(fromDateInput.value);
                const toDate = new Date(toDateInput.value);
                if (fromDate && toDate && fromDate <= toDate) {
                    const diffTime = toDate - fromDate;
                    const diffYears = diffTime / (1000 * 60 * 60 * 24 * 365);
                    relevantExperienceField.value = diffYears.toFixed(1) + " years";
                } else {
                    relevantExperienceField.value = "";
                }
            }

            // Handle the salary input (ensure right-to-left input for numeric fields)
            const salaryInput = workExperienceEntry.querySelector(".salary");
            salaryInput.style.direction = "rtl";
        }

        // Event listener to add work experience on button click
        addWorkExperienceBtn.addEventListener("click", addWorkExperienceForm);
    </script>

</body>
</html>
