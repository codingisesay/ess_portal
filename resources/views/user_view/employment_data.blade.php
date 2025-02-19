@extends('user_view.header')
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}">
    <title>Employee Details</title>
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
</head>
<body>
    <div class="container">
        <div class="employment-details">
            <h1>Employment Details</h1>
            <div class="employee-info">
                <div class="profile-image">
                    <img src="{{ asset('path/to/profile/picture.jpg') }}" width="80" height="80" alt="Profile Picture">
                </div>
                <h2>{{ $userDetails->name ?? 'N/A' }}</h2>
                <div class="job-title">
                    <p><strong>Designation</strong> <weak>{{ $userDetails->designation ?? 'N/A' }}</weak></p>
                    <p><strong>Department</strong> <weak>{{ $userDetails->department ?? 'N/A' }}</weak></p>
                    <p><strong>Office</strong> <weak>{{ $userDetails->office ?? 'N/A' }}</weak></p>
                    <p><strong>Reporting Manager</strong> <weak>{{ $userDetails->reporting_manager ?? 'N/A' }}</weak></p>
                </div>
                <div class="contact-details">
                    <h3>Contact Details</h3>
                    <p><strong>Phone Number</strong> <weak>{{ $userDetails->offical_phone_number ?? 'N/A' }}</weak></p>
                    <p><strong>Alternate Number</strong> <weak>{{ $userDetails->alternate_phone_number ?? 'N/A' }}</weak></p>
                    <p><strong>Email Address</strong> <weak><a href="mailto:{{ $userDetails->email ?? 'N/A' }}">{{ $userDetails->email ?? 'N/A' }}</a></weak></p>
                    <p><strong>Address</strong> <weak>{{ $userDetails->address ?? 'N/A' }}</weak></p>
                </div>
            </div>
            <div class="emergency-contact">
                <h2>Emergency Contact Details</h2>
                <p><strong>Name</strong> <weak>{{ $userDetails->emergency_contact_person ?? 'N/A' }}</weak></p>
                <p><strong>Contact Number</strong> <weak>{{ $userDetails->emergency_contact_number ?? 'N/A' }}</weak></p>              
            </div>
        </div>

        <div class="right-section">
            <div class="section">
                <h2>Personal Information</h2>
                <div class="left1"><p>Date of Birth</p> <b>{{ $userDetails->date_of_birth ?? 'N/A' }}</b></div>
                <div class="left1"><p>Gender</p> <b>{{ $userDetails->gender ?? 'N/A' }}</b></div>
                <div class="left1"><p>Nationality</p> <b>{{ $userDetails->nationality ?? 'N/A' }}</b></div>
                <div class="left1"><p>Marital Status</p> <b>{{ $userDetails->marital_status ?? 'N/A' }}</b></div>
                <div class="left1"><p>Blood Group</p> <b>{{ $userDetails->blood_group ?? 'N/A' }}</b></div>
                <div class="left1"><p>Religion</p> <b>{{ $userDetails->religion ?? 'N/A' }}</b></div>
                <div class="left1"><p>Annivarsary Date</p> <b>{{ $userDetails->anniversary_date  ?? 'N/A' }}</b></div>
            </div>

            <div class="section">
                <h2>Employee Details</h2>
                <div class="left1"><p>Employment Status</p> <b>{{ $userDetails->employment_status ?? 'N/A' }}</b></div>
                <div class="left1"><p>Employment Type</p> <b>{{ $userDetails->employee_type ?? 'N/A' }}</b></div>
                <div class="left1"><p>Start Date</p> <b>{{ $userDetails->Joining_date ?? 'N/A' }}</b></div>
                <div class="left1"><p>Total Experience</p> <b>{{ $userDetails->total_experience ?? 'N/A' }}</b></div>
            </div>

            <div class="section1">
                <h2>Salary Bank Details</h2>
                <div class="left1"><p>Bank Name</p> <b>{{ $userDetails->sal_bank_name ?? 'N/A' }}</b></div>
                <div class="left1"><p>Branch Name</p> <b>{{ $userDetails->sal_branch_name ?? 'N/A' }}</b></div>
                <div class="left1"><p>Account Number</p> <b>{{ $userDetails->sal_account_number ?? 'N/A' }}</b></div>
                <div class="left1"><p>IFSC Code</p> <b>{{ $userDetails->sal_ifsc_code ?? 'N/A' }}</b></div>

                <!-- <h2>Personal Bank Details</h2>
                <div class="left1"><p>Bank Name</p> <b>{{ $userDetails->bank_name ?? 'N/A' }}</b></div>
                <div class="left1"><p>Branch Name</p> <b>{{ $userDetails->branch_name ?? 'N/A' }}</b></div>
                <div class="left1"><p>Account Number</p> <b>{{ $userDetails->account_number ?? 'N/A' }}</b></div>
                <div class="left1"><p>IFSC Code</p> <b>{{ $userDetails->ifsc_code ?? 'N/A' }}</b></div> -->
            </div>

            <div class="section">
                <h2>Passport & Visa</h2>
                <div class="left1"><p>Passport Number</p> <b>{{ $userDetails->passport_number ?? 'N/A' }}</b></div>
                <div class="left1"><p>Issuing Country</p> <b>{{ $userDetails->issuing_country ?? 'N/A' }}</b></div>
                <div class="left1"><p>Issue Date</p> <b>{{ $userDetails->passport_issue_date ?? 'N/A' }}</b></div>
                <div class="left1"><p>Expiry Date</p> <b>{{ $userDetails->passport_expiry_date ?? 'N/A' }}</b></div>
                <div class="left1"><p>USA Visa</p> <b>{{ $userDetails->active_visa ?? 'N/A' }}</b></div>
                <div class="left1"><p>Visa Expiry Date</p> <b>{{ $userDetails->visa_expiry_date ?? 'N/A' }}</b></div>
            </div>

            <div class="section1">
                <h2>Welfare Benefits</h2>
                <div class="left1"><p>UAN</p> <b>{{ $userDetails->universal_account_number ?? 'N/A' }}</b></div>
                <div class="left1"><p>Provident Fund</p> <b>{{ $userDetails->provident_fund ?? 'N/A' }}</b></div>
                <div class="left1"><p>ESIC NO</p> <b>{{ $userDetails->esic_no ?? 'N/A' }}</b></div>
            </div>

            <div class="section educational-details-section">
                <h2>Educational Details</h2>
                @foreach($empEducation as $education)
                    <div style="display: flex;">
                        <p class="left2">
                            <div style="width: 200px">{{ $education->degree ?? 'N/A' }}</div>
                            <button class="view-btn" onclick="openModal({{ $loop->index }})">View</button>
                        </p>
                    </div>
                @endforeach
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="modal-content-details">
                        <!-- Educational details will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-section">
        <div class="section table-section">
            <h3>Family Details</h3>
            <div class="table-scroll-container">
                <table>
                    <thead>
                        <tr>
                            <th class="tableh-one">Sr. No.</th>
                            <th class="tableh-two">Dependent Name</th>
                            <th class="tableh-three">Relation</th>
                            <th class="tableh-four">Birth Date</th>
                            <th class="tableh-five">Gender</th>
                            <th class="tableh-six">Age</th>
                            <th class="tableh-seven">Dependent</th>
                            <th class="tableh-eight">Contact No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empFamilyDetails as $index => $family)
                            <tr>
                                <td class="tableh-one">{{ $index + 1 }}</td>
                                <td class="tableh-two">{{ $family->name  ?? 'N/A' }}</td>
                                <td class="tableh-three">{{ $family->relation ?? 'N/A' }}</td>
                                <td class="tableh-four">{{ $family->birth_date ?? 'N/A' }}</td>
                                <td class="tableh-five">{{ $family->gender ?? 'N/A' }}</td>
                                <td class="tableh-six">{{ $family->age ?? 'N/A' }}</td>
                                <td class="tableh-seven">{{ $family->dependent ?? 'N/A' }}</td>
                                <td class="tableh-eight">{{ $family->phone_number ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="sectionp">
            <h2>Previous Employment</h2>
            <div class="table-scroll-containerp">
                <table>
                    <thead>
                        <tr>
                            <th class="tablehp">Sr. No.</th>
                            <th class="tablehp">Name</th>
                            <th class="tablehp">Country</th>
                            <th class="tablehp">City</th>
                            <th class="tablehp">Start Date</th>
                            <th class="tablehp">End Date</th>
                            <th class="tablehp">Designation</th>
                            <th class="tablehp">Salary</th>
                            <th class="tablehp">Experience</th>
                            <!-- <th class="tablehp">Designation While Joining</th> -->
                            <th class="tablehp">Reason for Leaving</th>
                            <!-- <th class="tablehp">Role While Leaving</th> -->
                            <!-- <th class="tablehp">Designation While Leaving</th> -->
                            <th class="tablehp">Major Responsibilities Held</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empPreviousEmployments as $index => $employment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $employment->employer_name  ?? 'N/A' }}</td>
                                <td>{{ $employment->country ?? 'N/A' }}</td>
                                <td>{{ $employment->city ?? 'N/A' }}</td>
                                <td>{{ $employment->from_date  ?? 'N/A' }}</td>
                                <td>{{ $employment->to_date ?? 'N/A' }}</td>
                                <td>{{ $employment->designation ?? 'N/A' }}</td>
                                <td>{{ $employment->last_drawn_annual_salary ?? 'N/A' }}</td>
                                <td>{{ $employment->relevant_experience ?? 'N/A' }}</td>
                                <!-- <td>{{ $employment->designation_while_joining ?? 'N/A' }}</td> -->
                                <td>{{ $employment->reason_for_leaving ?? 'N/A' }}</td>
                                <!-- <td>{{ $employment->role_while_leaving ?? 'N/A' }}</td> -->
                                <!-- <td>{{ $employment->designation_while_leaving ?? 'N/A' }}</td> -->
                                <td>{{ $employment->major_responsibilities ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle modal popup
        function openModal(serialNo) {
            var modalContent = document.getElementById("modal-content-details");
            modalContent.innerHTML = ''; // Clear previous content

            @foreach($empEducation as $index => $education)
                if (serialNo === {{ $index }}) {
                    modalContent.innerHTML += `
                        <div>
                            <p class="label">Degree:</p>
                            <p class="value">{{ $education->degree ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">University:</p>
                            <p class="value">{{ $education->university ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Institution:</p>
                            <p class="value">{{ $education->institution ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Passing Year:</p>
                            <p class="value">{{ $education->year_of_passing ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Course Type:</p>
                            <p class="value">{{ $education->course_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Percentage:</p>
                            <p class="value">{{ $education->percentage ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Certification Name:</p>
                            <p class="value">{{ $education->certification_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Marks Obtained:</p>
                            <p class="value">{{ $education->marks_obtained ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="label">Certificate Date:</p>
                            <p class="value">{{ $education->certificate_date ?? 'N/A' }}</p>
                        </div>
                    `;
                }
            @endforeach

            document.getElementById("myModal").style.display = "block";
        }

        // Close the modal when the user clicks on the close button
        document.querySelector('.close').onclick = function() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>
@endsection
</body>
</html>