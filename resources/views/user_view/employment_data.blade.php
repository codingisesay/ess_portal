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
                <h2>{{ ucfirst($userDetails->name ?? 'N/A') }}</h2>
                <div class="job-title">
                    <p><strong>Designation</strong> <weak>{{ ucfirst($userDetails->designation_name ?? 'N/A') }}</weak></p>
                    <p><strong>Department</strong> <weak>{{ ucfirst($userDetails->department_name ?? 'N/A') }}</weak></p>
                    <p><strong>Office</strong> <weak>{{ ucfirst($userDetails->office ?? 'N/A') }}</weak></p>
                    <p><strong>Reporting Manager</strong> <weak>{{ ucfirst($userDetails->reporting_manager_name ?? 'N/A') }}</weak></p>
                </div>
                <div class="contact-details">
                    <h3>Contact Details</h3>
                    <p><strong>Phone Number</strong> <weak>{{ ucfirst($userDetails->offical_phone_number ?? 'N/A') }}</weak></p>
                    <p><strong>Alternate Number</strong> <weak>{{ ucfirst($userDetails->alternate_phone_number ?? 'N/A') }}</weak></p>
                    <p><strong>Email Address</strong> <weak><a href="mailto:{{ $userDetails->email ?? 'N/A' }}">{{ ucfirst($userDetails->email ?? 'N/A') }}</a></weak></p>
                    <h3>Address</h3>
                    <p><strong>Permanent</strong> <weak>
                        {{ ucfirst($userDetails->per_building_no ?? '') }},
                        {{ ucfirst($userDetails->per_name_of_premises ?? '') }},
                        {{ ucfirst($userDetails->per_nearby_landmark ?? '') }},
                        {{ ucfirst($userDetails->per_road_street ?? '') }},
                        {{ ucfirst($userDetails->per_city ?? '') }},
                        {{ ucfirst($userDetails->per_district ?? '') }},
                        {{ ucfirst($userDetails->per_state ?? '') }},
                        {{ ucfirst($userDetails->per_country ?? '') }},
                        {{ ucfirst($userDetails->per_pincode ?? '') }}
                    </weak></p>
                    <p><strong>Correspondance</strong> <weak>
                        {{ ucfirst($userDetails->cor_building_no ?? '') }},
                        {{ ucfirst($userDetails->cor_name_of_premises ?? '') }},
                        {{ ucfirst($userDetails->cor_nearby_landmark ?? '') }},
                        {{ ucfirst($userDetails->cor_road_street ?? '') }},
                        {{ ucfirst($userDetails->cor_city ?? '') }},
                        {{ ucfirst($userDetails->cor_district ?? '') }},
                        {{ ucfirst($userDetails->cor_state ?? '') }},
                        {{ ucfirst($userDetails->cor_country ?? '') }},
                        {{ ucfirst($userDetails->cor_pincode ?? '') }}
                    </weak></p>
                </div>
            </div>
            <div class="emergency-contact">
                <h2>Emergency Contact Details</h2>
                <p><strong>Name</strong> <weak>{{ ucfirst($userDetails->emergency_contact_person ?? 'N/A') }}</weak></p>
                <p><strong>Contact Number</strong> <weak>{{ ucfirst($userDetails->emergency_contact_number ?? 'N/A') }}</weak></p>              
            </div>
        </div>

        <div class="right-section">
            <div class="section">
                <h2>Personal Information</h2>
                <div class="left1"><p>Date of Birth</p> <b>{{ $userDetails->date_of_birth ? \Carbon\Carbon::parse($userDetails->date_of_birth)->format('d-m-Y') : 'N/A' }}</b></div>
                <div class="left1"><p>Gender</p> <b>{{ ucfirst($userDetails->gender ?? 'N/A') }}</b></div>
                <div class="left1"><p>Nationality</p> <b>{{ ucfirst($userDetails->nationality ?? 'N/A') }}</b></div>
                <div class="left1"><p>Marital Status</p> <b>{{ ucfirst($userDetails->marital_status ?? 'N/A') }}</b></div>
                <div class="left1"><p>Blood Group</p> <b>{{ ucfirst($userDetails->blood_group ?? 'N/A') }}</b></div>
                <div class="left1"><p>Religion</p> <b>{{ ucfirst($userDetails->religion ?? 'N/A') }}</b></div>
                <div class="left1"><p>Anniversary Date</p> <b>{{ $userDetails->anniversary_date ? \Carbon\Carbon::parse($userDetails->anniversary_date)->format('d-m-Y') : 'N/A' }}</b></div>
            </div>

            <div class="section">
                <h2>Employee Details</h2>
                <div class="left1"><p>Employment Status</p> <b>{{ ucfirst($userDetails->employment_status ?? 'N/A') }}</b></div>
                <div class="left1"><p>Employment Type</p> <b>{{ ucfirst($userDetails->employee_type_name ?? 'N/A') }}</b></div>
                <div class="left1"><p>Start Date</p> <b>{{ $userDetails->Joining_date ? \Carbon\Carbon::parse($userDetails->Joining_date)->format('d-m-Y') : 'N/A' }}</b></div>
                <div class="left1"><p>Total Experience</p> <b>{{ ucfirst($userDetails->total_experience ?? 'N/A') }}</b></div>
            </div>

            <div class="section1">
                <h2>Salary Bank Details</h2>
                <div class="left1"><p>Bank Name</p> <b>{{ ucfirst($userDetails->bank_name ?? 'N/A') }}</b></div>
                <div class="left1"><p>Branch Name</p> <b>{{ ucfirst($userDetails->sal_branch_name ?? 'N/A') }}</b></div>
                <div class="left1"><p>Account Number</p> <b>{{ ucfirst($userDetails->sal_account_number ?? 'N/A') }}</b></div>
                <div class="left1"><p>IFSC Code</p> <b>{{ ucfirst($userDetails->sal_ifsc_code ?? 'N/A') }}</b></div>
            </div>

            <div class="section">
                <h2>Passport & Visa</h2>
                <div class="left1"><p>Passport Number</p> <b>{{ ucfirst($userDetails->passport_number ?? 'N/A') }}</b></div>
                <div class="left1"><p>Issuing Country</p> <b>{{ ucfirst($userDetails->issuing_country ?? 'N/A') }}</b></div>
                <div class="left1"><p>Issue Date</p> <b>{{ $userDetails->passport_issue_date ? \Carbon\Carbon::parse($userDetails->passport_issue_date)->format('d-m-Y') : 'N/A' }}</b></div>
                <div class="left1"><p>Expiry Date</p> <b>{{ $userDetails->passport_expiry_date ? \Carbon\Carbon::parse($userDetails->passport_expiry_date)->format('d-m-Y') : 'N/A' }}</b></div>
                <div class="left1"><p>USA Visa</p> <b>{{ ucfirst($userDetails->active_visa ?? 'N/A') }}</b></div>
                <div class="left1"><p>Visa Expiry Date</p> <b>{{ $userDetails->visa_expiry_date ? \Carbon\Carbon::parse($userDetails->visa_expiry_date)->format('d-m-Y') : 'N/A' }}</b></div>
            </div>

            <div class="section1">
                <h2>Welfare Benefits</h2>
                <div class="left1"><p>UAN</p> <b>{{ ucfirst($userDetails->universal_account_number ?? 'N/A') }}</b></div>
                <div class="left1"><p>Provident Fund</p> <b>{{ ucfirst($userDetails->provident_fund ?? 'N/A') }}</b></div>
                <div class="left1"><p>ESIC NO</p> <b>{{ ucfirst($userDetails->esic_no ?? 'N/A') }}</b></div>
            </div>

            <div class="section educational-details-section">
                <h2>Educational Details</h2>
                @foreach($empEducation as $education)
                    <div style="display: flex;">
                        <p class="left2">
                            <div style="width: 200px">{{ ucfirst($education->course_type ?? '') }}</div>
                            @if($education->course_type == 'degree')
                                <button class="view-btn" onclick="openDegreeModal({{ $loop->index }})">View</button>
                            @elseif($education->course_type == 'certification')
                                <button class="view-btn" onclick="openCertificationModal({{ $loop->index }})">View</button>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>

            <div id="degreeModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('degreeModal')">&times;</span>
                    <div id="degree-modal-content-details">
                        <!-- Degree details will be displayed here -->
                    </div>
                </div>
            </div>

            <div id="certificationModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('certificationModal')">&times;</span>
                    <div id="certification-modal-content-details">
                        <!-- Certification details will be displayed here -->
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
                                <td class="tableh-two">{{ ucfirst($family->name  ?? 'N/A') }}</td>
                                <td class="tableh-three">{{ ucfirst($family->relation ?? 'N/A') }}</td>
                                <td class="tableh-four">{{ $family->birth_date ? \Carbon\Carbon::parse($family->birth_date)->format('d-m-Y') : 'N/A' }}</td>
                                <td class="tableh-five">{{ ucfirst($family->gender ?? 'N/A') }}</td>
                                <td class="tableh-six">{{ ucfirst($family->age ?? 'N/A') }}</td>
                                <td class="tableh-seven">{{ ucfirst($family->dependent ?? 'N/A') }}</td>
                                <td class="tableh-eight">{{ ucfirst($family->phone_number ?? 'N/A') }}</td>
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
                            <th class="tablehp">Reason for Leaving</th>
                            <th class="tablehp">Major Responsibilities Held</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empPreviousEmployments as $index => $employment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucfirst($employment->employer_name  ?? 'N/A') }}</td>
                                <td>{{ ucfirst($employment->country ?? 'N/A') }}</td>
                                <td>{{ ucfirst($employment->city ?? 'N/A') }}</td>
                                <td>{{ $employment->from_date ? \Carbon\Carbon::parse($employment->from_date)->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $employment->to_date ? \Carbon\Carbon::parse($employment->to_date)->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ ucfirst($employment->designation ?? 'N/A') }}</td>
                                <td>{{ ucfirst($employment->last_drawn_annual_salary ?? 'N/A') }}</td>
                                <td>{{ ucfirst($employment->relevant_experience ?? 'N/A') }}</td>
                                <td>{{ ucfirst($employment->reason_for_leaving ?? 'N/A') }}</td>
                                <td>{{ ucfirst($employment->major_responsibilities ?? 'N/A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle modal popup
        function openDegreeModal(serialNo) {
            var modalContent = document.getElementById("degree-modal-content-details");
            modalContent.innerHTML = ''; // Clear previous content

            @foreach($empEducation as $index => $education)
                if (serialNo === {{ $index }}) {
                    modalContent.innerHTML += `
                        <table class="details-table">
                            <tr>
                                <th>Degree</th>
                                <td>{{ ucfirst($education->degree ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>University</th>
                                <td>{{ ucfirst($education->university ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Institution</th>
                                <td>{{ ucfirst($education->institution ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Passing Year</th>
                                <td>{{ $education->year_of_passing ? \Carbon\Carbon::parse($education->year_of_passing)->format('d-m-Y') : 'N/A' }}</td>
                            </tr>
                           
                            <tr>
                                <th>Percentage</th>
                                <td>{{ ucfirst($education->percentage ?? 'N/A') }}</td>
                            </tr>
                        </table>
                    `;
                }
            @endforeach

            document.getElementById("degreeModal").style.display = "block";
        }

        function openCertificationModal(serialNo) {
            var modalContent = document.getElementById("certification-modal-content-details");
            modalContent.innerHTML = ''; // Clear previous content

            @foreach($empEducation as $index => $education)
                if (serialNo === {{ $index }}) {
                    modalContent.innerHTML += `
                        <table class="details-table">
                            <tr>
                                <th>Certification Name</th>
                                <td>{{ ucfirst($education->certification_name ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Marks Obtained</th>
                                <td>{{ ucfirst($education->marks_obtained ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Certificate Date</th>
                                <td>{{ $education->certificate_date ? \Carbon\Carbon::parse($education->certificate_date)->format('d-m-Y') : 'N/A' }}</td>
                            </tr>
                        </table>
                    `;
                }
            @endforeach

            document.getElementById("certificationModal").style.display = "block";
        }

        // Close the modal when the user clicks on the close button
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
    </script>
     <style>
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .details-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .details-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .details-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>

@endsection
</body>
</html>