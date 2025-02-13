<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Member Form</title>
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

    <h1>Family Member Form</h1>
    
    <!-- Button to add new family member -->
    <button id="addFamilyMemberBtn">Add Family Member</button>
    
    <!-- Container where family member entries will be added -->
    <div id="familyMemberEntries" class="form-container"></div>
    <a href="{{ route('user.bank') }}" class="btn btn-success">back</a>
    <a href="{{ route('user.preemp') }}" class="btn btn-success">next</a>

    <script>
        const addFamilyMemberBtn = document.getElementById("addFamilyMemberBtn");
        const familyMemberEntries = document.getElementById("familyMemberEntries");

        // Function to add a new family member entry
        function addFamilyMemberForm() {
            const familyMemberEntry = document.createElement("div");
            familyMemberEntry.classList.add("form-entry");
            familyMemberEntry.innerHTML = `
                <label>Name:</label>
                <input type="text" placeholder="Enter Name" class="family-name" required><br>
                
                <label>Relation:</label>
                <select class="family-relation" required>
                    <option value="">Select Relation</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Child">Child</option>
                    <option value="Parent">Parent</option>
                    <option value="Sibling">Sibling</option>
                    <option value="Other">Other</option>
                </select><br>

                <label>Birth Date:</label>
                <input type="date" class="family-birthdate" required><br>

                <label>Gender:</label>
                <select class="family-gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select><br>

                <label>Age:</label>
                <input type="text" class="family-age" disabled><br>

                <label>Dependent:</label>
                <select class="family-dependent" required>
                    <option value="">Select Dependent</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Phone Number:</label>
                <input type="text" class="family-phone" maxlength="10"><br>
            `;
            familyMemberEntries.appendChild(familyMemberEntry);

            // Add event listeners to recalculate age and validate inputs
            const birthdateInput = familyMemberEntry.querySelector(".family-birthdate");
            birthdateInput.addEventListener("change", function() {
                const birthDate = new Date(birthdateInput.value);
                const ageField = familyMemberEntry.querySelector(".family-age");
                if (birthDate) {
                    const age = new Date().getFullYear() - birthDate.getFullYear();
                    ageField.value = age;
                }
            });

            // Validate the Name field for alphabets only
            const nameInput = familyMemberEntry.querySelector(".family-name");
            nameInput.addEventListener("input", function() {
                if (!/^[a-zA-Z\s]*$/.test(nameInput.value)) {
                    alert("Name should only contain alphabets.");
                    nameInput.setCustomValidity("Name should only contain alphabets.");
                } else {
                    nameInput.setCustomValidity("");
                }
            });

            // Validate Phone Number field to accept only numbers and max 10 digits
            const phoneInput = familyMemberEntry.querySelector(".family-phone");
            phoneInput.addEventListener("input", function() {
                if (!/^\d{0,10}$/.test(phoneInput.value)) {
                    alert("Phone number should be only numbers and max 10 digits.");
                    phoneInput.setCustomValidity("Phone number should be only numbers and max 10 digits.");
                } else {
                    phoneInput.setCustomValidity("");
                }
            });
        }

        // Event listener to add family member on button click
        addFamilyMemberBtn.addEventListener("click", addFamilyMemberForm);
    </script>

</body>
</html>
