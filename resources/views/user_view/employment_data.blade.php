@extends('user_view.header')
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}"> 
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
  
        
    <style>
        /* General modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Allow scrolling if the content is too large */
    background-color: rgba(0, 0, 0, 0.4); /* Background overlay */
    padding-top: 50px; /* Space for modal header */
}

/* Modal content box */
.modal-content {
    background-color: #fff;
    margin: 5% auto; /* Center the modal */
    /* padding: 20px; */
    padding: 40px;
    border: 1px solid #888;
    width: 80%; /* Width can be adjusted */
    max-width: 900px; /* Set a max width to prevent it from stretching too much */
    border-radius: 10px; /* Rounded corners for a soft look */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow-y: auto; /* Enable vertical scrolling inside the modal */
    max-height: 80vh; /* Limit height to 80% of the viewport height */ 
}

/* Modal close button */
.close { 
    color: #aaa;
    float: right;
    font-size: 22px;
    font-weight: bold;
    cursor: pointer;
    top: 0px; width: min-content; 
}

/* Close button on hover */
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Content inside the modal */
#degree-modal-content-details, #certification-modal-content-details {
    max-height: 60vh; /* Allow modal content to scroll */
    overflow-y: auto;
}
 .no-table tr, .no-table td{background: white; border:none}

/* Responsive design for small screens */
@media (max-width: 768px) {
    .modal-content {
        width: 90%; /* Increase width for small screens */
        padding: 15px;
    }
 
    .close {
        font-size: 24px;
    }
}

    </style>
     
</head>
<body>
 
    <div class="row m-2">
        <div class="col-md-5 my-3">
            <div class="section custom-table h-100">
            @include('user_view.employment_details_top')
            </div>
        </div>
        <div class="col-md-7 my-3">
            <div class="section custom-table h-100">
            @include('user_view.employment_details_section')
            </div>
        </div>
        <!-- comman component above -->

        <div class="col-6 my-3">
            <div class="section custom-table h-100">
            <h2> Employee Details</h2>
                <table> 
                    
                    <tr>
                        <th>Employment Status</th>
                        <td><b>{{ ucfirst($userDetails->employment_status ?? 'Active') }}</b></td>
                    </tr>
                    <tr>
                        <th>Employment Type</th>
                        <td><b>{{ ucfirst($userDetails->employee_type_name ?? '-') }}</b></td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td><b>{{ $userDetails->Joining_date ? \Carbon\Carbon::parse($userDetails->Joining_date)->format('d-m-Y') : '-' }}</b></td>
                    </tr>
                    <tr>
                        <th>Total Experience</th>
                        <td><b>{{ ucfirst($userDetails->total_experience ?? '-') }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-6 my-3">
            <div class="section custom-table h-100"> 
            <h2>Salary Bank Details</h2>
            <table> 
            
                <tr>
                    <th>Bank Name</th>
                    <td><b>{{ ucfirst($userDetails->bank_name ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>Branch Name</th>
                    <td><b>{{ ucfirst($userDetails->sal_branch_name ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>Account Number</th>
                    <td><b>{{ ucfirst($userDetails->sal_account_number ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>IFSC Code</th>
                    <td><b>{{ ucfirst($userDetails->sal_ifsc_code ?? '-') }}</b></td>
                </tr>
            </table>
            </div>
        </div>
        <div class="col-6 my-3">
            <div class="section custom-table h-100">
                <h2>Personal Information</h2>
                <table>
                    <tr>
                        <th>Date of Birth</th>
                        <td><b>{{ $userDetails->date_of_birth ? \Carbon\Carbon::parse($userDetails->date_of_birth)->format('d-m-Y') : '-' }}</b></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><b>{{ ucfirst($userDetails->gender ?? '-') }}</b></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><b>{{ ucfirst($userDetails->nationality ?? '-') }}</b></td>
                    </tr>
                    <tr>
                        <th>Marital Status</th>
                        <td><b>{{ ucfirst($userDetails->marital_status ?? '-') }}</b></td>
                    </tr>
                    <tr>
                        <th>Anniversary Date</th>
                        <td><b>{{ $userDetails->anniversary_date ? \Carbon\Carbon::parse($userDetails->anniversary_date)->format('d-m-Y') : '-' }}</b></td>
                    </tr>
                    <tr>
                        <th>Blood Group</th>
                        <td><b>{{ ucfirst($userDetails->blood_group ?? '-') }}</b></td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td><b>{{ ucfirst($userDetails->religion ?? '-') }}</b></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-6 my-3">
            <div class="section custom-table h-100"> 
             <h2>Passport & Visa Details</h2>
            <table class="custom-table">             
                <tr>
                    <th>Passport Number</th>
                    <td><b>{{ ucfirst($userDetails->passport_number ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>Issuing Country</th>
                    <td><b>{{ ucfirst($userDetails->issuing_country ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>Issue Date</th>
                    <td><b>{{ $userDetails->passport_issue_date ? \Carbon\Carbon::parse($userDetails->passport_issue_date)->format('d-m-Y') : '-' }}</b></td>
                </tr>
                <tr>
                    <th>Expiry Date</th>
                    <td><b>{{ $userDetails->passport_expiry_date ? \Carbon\Carbon::parse($userDetails->passport_expiry_date)->format('d-m-Y') : '-' }}</b></td>
                </tr>
                <tr>
                    <th>Visa</th>
                    <td><b>{{ ucfirst($userDetails->active_visa ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>Visa Expiry Date</th>
                    <td><b>{{ $userDetails->visa_expiry_date ? \Carbon\Carbon::parse($userDetails->visa_expiry_date)->format('d-m-Y') : '-' }}</b></td>
                </tr>
            </table>


            </div>
        </div>
        <div class="col-6 my-3">
            <div class="section custom-table h-100"> 
            <h2>Welfare Benefits</h2>
            <table>                 
                <tr>
                    <th>UAN</th>
                    <td><b>{{ ucfirst($userDetails->universal_account_number ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>Provident Fund</th>
                    <td><b>{{ ucfirst($userDetails->provident_fund ?? '-') }}</b></td>
                </tr>
                <tr>
                    <th>ESIC NO</th>
                    <td><b>{{ ucfirst($userDetails->esic_no ?? '-') }}</b></td>
                </tr>
            </table> 
            </div>
        </div>
        <div class="col-6 my-3">
            <div class="section custom-table h-100"> 
            <h2>Educational Details</h2>
            <table class="">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empEducation as $education)
                        <tr>
                            <td class="course-name">
                                @if($education->course_type == 'degree')
                                    {{ ucfirst($education->degree ?? '-') }}
                                @elseif($education->course_type == 'certification')
                                    {{ ucfirst($education->certification_name ?? '-') }}
                                @endif
                            </td>
                            <td>
                                @if($education->course_type == 'degree')
                                    <button class="view-btn" onclick="openDegreeModal({{ $loop->index }})">View</button>
                                @elseif($education->course_type == 'certification')
                                    <button class="view-btn" onclick="openCertificationModal({{ $loop->index }})">View</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <!-- table section start below -->
        <div class="col-12 my-3 ">
            <div class="section h-100"> 
                <h3>Family Details</h3>
                <div class="table-scroll-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="tableh-one">Sr. No.</th>
                                <th class="tableh-two">Name</th>
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
                                    <td class="tableh-two">{{ ucfirst($family->name  ?? '-') }}</td>
                                    <td class="tableh-three">{{ ucfirst($family->relation ?? '-') }}</td>
                                    <td class="tableh-four">{{ $family->birth_date ? \Carbon\Carbon::parse($family->birth_date)->format('d-m-Y') : '-' }}</td>
                                    <td class="tableh-five">{{ ucfirst($family->gender ?? '-') }}</td>
                                    <td class="tableh-six">{{ ucfirst($family->age ?? '-') }}</td>
                                    <td class="tableh-seven">{{ ucfirst($family->dependent ?? '-') }}</td>
                                    <td class="tableh-eight">{{ ucfirst($family->phone_number ?? '-') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 my-3 "> 
            <div class="section h-100">
                <h3>Previous Employment</h3>
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
                                    <td>{{ ucfirst($employment->employer_name  ?? '-') }}</td>
                                    <td>{{ ucfirst($employment->country ?? '-') }}</td>
                                    <td>{{ ucfirst($employment->city ?? '-') }}</td>
                                    <td>{{ $employment->from_date ? \Carbon\Carbon::parse($employment->from_date)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $employment->to_date ? \Carbon\Carbon::parse($employment->to_date)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ ucfirst($employment->designation ?? '-') }}</td>
                                    <td class="right-align">{{ number_format($employment->last_drawn_annual_salary ?? 0, 2) }}</td>
                                    <td>{{ ucfirst($employment->relevant_experience ?? '-') }}</td>
                                    <td>{{ ucfirst($employment->reason_for_leaving ?? '-') }}</td>
                                    <td>{{ ucfirst($employment->major_responsibilities ?? '-') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 my-3 "> 
            <div class="section h-100"> 
                <h3>Uploaded Documents</h3>
                <div class="table-scroll-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="tableh-one">Sr. No.</th>
                                <th class="tableh-two">Document Type</th>
                                <!-- <th class="tableh-three">File Path</th> -->
                                <th class="tableh-four">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $index => $document)
                                <tr>
                                    <td class="tableh-one">{{ $index + 1 }}</td>
                                    <td class="tableh-two">{{ ucfirst($document->document_type ?? '-') }}</td>
                                    <!-- <td class="tableh-three">{{ ucfirst($document->file_path ?? '-') }}</td> -->
                                    <td class="tableh-four">
                                        @if($document->file_path)
                                            <a href="{{ asset('storage/' . $document->file_path) }}" download>
                                                <button class="download-btn">Download</button>
                                            </a>
                                        @else
                                            <span>No File</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>



    </div>
     
     
 

            <div id="degreeModal" class="modal">
                <div class="modal-content"> 
                <div class="modal-header pt-0 mb-2">  <h2>Academic Details</h2>
                    <span class="close" onclick="closeModal('degreeModal')">&times;</span>
                </div>
                    <div id="degree-modal-content-details">
                        <!-- Degree details will be displayed here -->
                    </div>
                </div>
            </div>

            <div id="certificationModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header"> 
                        <span class="close" onclick="closeModal('certificationModal')">X</span>
                    </div>
                    <div id="certification-modal-content-details">
                        <!-- Certification details will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-section1">
     

    </div>

    <div class="right-section1">
 
 
    <script>
        // JavaScript to handle modal popup
        function openDegreeModal(serialNo) {
            var modalContent = document.getElementById("degree-modal-content-details");
            modalContent.innerHTML = ''; // Clear previous content

            @foreach($empEducation as $index => $education)
                if (serialNo === {{ $index }}) {
                    modalContent.innerHTML += `
                        <table class="no-table" >
                            <tr>
                                <td>Degree</td>
                                <td>: {{ ucfirst($education->degree ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td>University</td>
                                <td>: {{ ucfirst($education->university_board  ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td>Institution</td>
                                <td>: {{ ucfirst($education->institution ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td>Passing Year</td>
                              <td>: {{ $education->passing_year ? $education->passing_year : '-' }}</td>
                            </tr>
                           
                            <tr>
                                <td>Percentage</td>
                                <td>: {{ ucfirst($education->percentage_cgpa ?? '-') }}</td>
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
                        <table class="custom-table">
                            <tr>
                                <th>Certification Name</th>
                                <td>{{ ucfirst($education->certification_name ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th>Marks Obtained</th>
                                <td>{{ ucfirst($education->marks_obtained ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th>Total Marks</th>
                                <td>{{ ucfirst($education->out_of_marks_total_marks ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th>Certificate Date</th>
                                <td>{{ $education->date_of_certificate ? \Carbon\Carbon::parse($education->date_of_certificate)->format('d-m-Y') : '-' }}</td>
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
   
@endsection
