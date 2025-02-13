<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Degree and Certification Forms</title>
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
    
    <!-- Buttons to toggle between Degree and Certification forms -->

    
    <!-- Degree Form Section -->
    <div id="degreeFormSection" class="form-container">
        <h3>Degree Form</h3>
        <button id="addDegreeBtn">Add Degree</button>
        <div id="degreeFormEntries"></div>
       
    </div>

    <!-- Certification Form Section -->
    <div id="certificationFormSection" class="form-container">
        <h3>Certification Form</h3>
        <button id="addCertificationBtn">Add Certification</button>
        <div id="certificationFormEntries"></div>
    </div>
    <button type="submit">Submit</button>
    <a href="{{ route('user.contact') }}" class="btn btn-success">back</a>
    <a href="{{ route('user.bank') }}" class="btn btn-success">next</a>
    <script>
        // Buttons to trigger the form adding
        const addDegreeBtn = document.getElementById("addDegreeBtn");
        const addCertificationBtn = document.getElementById("addCertificationBtn");

        // Divs where form entries will be appended
        const degreeFormEntries = document.getElementById("degreeFormEntries");
        const certificationFormEntries = document.getElementById("certificationFormEntries");

        // Function to add Degree form entry
        function addDegreeForm() {
            const degreeEntry = document.createElement("div");
            degreeEntry.classList.add("form-entry");
            degreeEntry.innerHTML = `

            <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Type Degree:</label>
        <select class="form-control" required>
            <option>Choose Type</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Degree:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">University/Board:</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>

      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Institution:</label>
        <select class="form-control" required>
            <option>Choose Type</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Passing Year:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Percentage/CGPA:</label>
        <input type="number" max="4" step="0.1" placeholder="Enter Percentage/CGPA">
      </div>
    </div> `;
            degreeFormEntries.appendChild(degreeEntry);
        }

        // Function to add Certification form entry
        function addCertificationForm() {
            const certificationEntry = document.createElement("div");
            certificationEntry.classList.add("form-entry");
            certificationEntry.innerHTML = `

            
            <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Type_Certification:</label>
        <select class="form-control" required>
            <option>Choose Type</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Certification_Name:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Marks_Obtained:</label>
        <input class="form-control" id="ex3" type="text" required>
      </div>
    </div>

      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex1">Out of Marks (Total Marks):</label>
        <select class="form-control" required>
            <option>Choose Type</option>
                    <option>Undergraduate</option>
                    <option>Postgraduate</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="ex2">Date_Of_Certificate:</label>
        <input class="form-control" id="ex2" type="text" maxlength="20" required>
      </div>
  
    </div>
               
            `;
            certificationFormEntries.appendChild(certificationEntry);
        }

        // Event listeners for adding forms
        addDegreeBtn.addEventListener("click", addDegreeForm);
        addCertificationBtn.addEventListener("click", addCertificationForm);

        // You can add additional functionality here for form validation, submitting, etc.
    </script>

</body>
</html>
