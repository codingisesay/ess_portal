@extends('user_view.header')
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/user_end/css/employment_data.css') }}"> 
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
   
     <style> 
    .eduction-info-item .info-value {
            font-size: 1.1rem;
            color: #333;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid #8A3366;}
            .eduction-info-item .info-label {
                font-size: 16px;font-weight: 500;
            }
     </style>
</head>
<body>
 
    <div class="row mx-3">
        <!-- <h2> Employee Detailssss</h2> -->
          <!-- comman component below -->
        <div class="col-md-4 my-2">
            <div class="section custom-table h-100">
            @include('user_view.employment_details_top')
            <hr>
            @include('user_view.employment_details_section')
            </div>
        </div>
        <div class="col-md-8  ">
            <div class="row my-auto " >    
                <div class="col-6 my-2">
                    <div class="section custom-table h-100">
                    <h5 class="d-flex align-items-center"><x-icon name="empidoutline"/>&nbsp;Employee Details</h5>
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
                            <tr>
                                <th>Experience In Current Company</th>
                                <td><b>{{ ucfirst($userDetails->total_experience ?? '-') }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-6 my-2">
                    <div class="section custom-table h-100"> 
                    <h5 class="d-flex align-items-center"><x-icon name="bankoutline"/>&nbsp;Salary Bank Details</h5>
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
                <div class="col-6 my-2">
                    <div class="section custom-table h-100">
                        <h5 class="d-flex align-items-center"><x-icon name="personalinfooutline"/>&nbsp;Personal Information</h5>
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
                                <th>Religion</th>
                                <td><b>{{ ucfirst($userDetails->religion ?? '-') }}</b></td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td><b>{{ ucfirst($userDetails->blood_group ?? '-') }}</b></td>
                            </tr>
                            <tr>
                                <th>Marital Status</th>
                                <td><b>{{ ucfirst($userDetails->marital_status ?? '-') }}</b></td>
                            </tr>
                            <tr>
                                <th>Anniversary Date</th>
                                <td><b>{{ $userDetails->anniversary_date ? \Carbon\Carbon::parse($userDetails->anniversary_date)->format('d-m-Y') : '-' }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div> 
                <div class="col-6 my-2">
                    <div class="section custom-table h-100"> 
                    <h5 class="d-flex align-items-center"><x-icon name="passportoutline"/>&nbsp;Passport & Visa Details</h5>
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
                            <th>Visa Applicable</th>
                            <td><b>{{ ucfirst($userDetails->active_visa ?? '-') }}</b></td>
                        </tr>
                        <tr>
                            <th>Visa Expiry Date</th>
                            <td><b>{{ $userDetails->visa_expiry_date ? \Carbon\Carbon::parse($userDetails->visa_expiry_date)->format('d-m-Y') : '-' }}</b></td>
                        </tr>
                    </table>


                    </div>
                </div>
                <div class="col-6 my-2">
                    <div class="section custom-table h-100"> 
                    <h5 class="d-flex align-items-center"><x-icon name="wellfareoutline"/>&nbsp;Welfare Benefits</h5>
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
                <div class="col-6 my-2">
                    <div class="section custom-table h-100"> 
                    <h5 class="d-flex align-items-center"><x-icon name="educationoutline"/>&nbsp;Educational Details</h5>
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
                                            <button class="submit d-flex justify-content-center align-items-center" onclick="openDegreeModal({{ $loop->index }})">
                                                <x-icon name="eyefill" />&nbsp;View
                                            </button>
                                        @elseif($education->course_type == 'certification')
                                            <button class="submit d-flex justify-content-center align-items-center" onclick="openCertificationModal({{ $loop->index }})">
                                                <x-icon name="eyefill" />&nbsp;View
                                            </button>
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
        <!-- comman component above -->
  
        <!-- table section start below -->
        <div class="col-6 my-2 ">
            <div class="section h-100"> 
                <h3 class="d-flex align-items-center"><x-icon name="useroutline" />&nbsp;Family Details</h3>
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
        <div class="col-6 my-2 "> 
            <div class="section h-100">
                <h3 class="d-flex align-items-center"><x-icon name="buildingoutline"/>&nbsp;Previous Employment</h3>
                <div class="table-scroll-container">
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
        <div class="col-12 my-2 "> 
            <div class="section h-100"> 
                <h3 class='d-flex align-items-center'> <x-icon name="openfolder" />&nbsp; Uploaded Documents</h3>                
                <div class="row my-2">  
                    @foreach($documents as $index => $document)
                        <div class="col-6">
                            <div class="border-bottom my-2 pb-2 px-3 d-flex align-items-center">
                                <span class="text-danger me-2"><x-icon name="pdf" /></span> 
                                <!-- <td class="tableh-one">{{ $index + 1 }}</td> -->
                                <span class="me-auto">{{ ucfirst($document->document_type ?? '-') }}</span>
                                <!-- <td class="tableh-three">{{ ucfirst($document->file_path ?? '-') }}</td> --> 
                                    @if($document->file_path)
                                        <a class="ms-auto" style="color:#8A3366" href="{{ asset('storage/' . $document->file_path) }}" download>
                                        <x-icon name="download" />
                                        </a>
                                    @else
                                        <span>No File</span>
                                    @endif
                                </div>
                        </div>
                    @endforeach 
                </div> 
 
            </div>
        </div> 
    </div>
      
    <div id="degreeModal" class="modal">
        <div class="modal-content">  
            <span class="close" onclick="closeModal('degreeModal')">&times;</span>
            <h5>Academic Details</h5> 
            <div id="degree-modal-content-details">
                <!-- Degree details will be displayed here -->
            </div>
        </div>
    </div>

    <div id="certificationModal" class="modal">
        <div class="modal-content">
            <!-- <div class="modal-header">  -->
                <span class="close" onclick="closeModal('certificationModal')">X</span>
                <h5>Academic Details</h5> 
            <!-- </div> -->
            <div id="certification-modal-content-details">
                <!-- Certification details will be displayed here -->
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
                        <div class="row eduction-info-item">
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label >Degree</label>
                                    <input class="input-field" type="text" value=" {{ ucfirst($education->degree ?? '-') }} " />
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label >University</label>
                                    <input class="input-field" type="text" value=" {{ ucfirst($education->university_board ?? '-') }} " />
                                </div>                                
                            </div>
                        </div>
                         
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label >Institution</label>
                                    <input class="input-field" type="text" value=" {{ ucfirst($education->institution ?? '-') }} " />
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label >Passing Year</label>
                                    <input class="input-field" type="text" value=" {{ $education->passing_year ? $education->passing_year : '-' }} " />
                                </div>                                
                            </div>
                        </div>
                         
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label >Percentage</label>
                                    <input class="input-field" type="text" value=" {{ ucfirst($education->percentage_cgpa ?? '-') }} " />
                                </div>                                
                            </div>
                        </div>
                    </div>

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
                    <div class="row eduction-info-item">
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label>Certification Name</label>
                                    <input type="text" class="input-field" {{ ucfirst($education->certification_name ?? '-') }} />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label>Marks Obtained</label>
                                    <input type="text" class="input-field" {{ ucfirst($education->marks_obtained ?? '-') }} />
                                </div>
                            </div>
                        </div>                         
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label>Total Marks</label>
                                    <input type="text" class="input-field" {{ ucfirst($education->out_of_marks_total_marks ?? '-') }} />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="form-group">
                                <div class="floating-label-wrapper">
                                    <label>Certificate Date</label>
                                    <input type="text" class="input-field" {{ $education->date_of_certificate ? \Carbon\Carbon::parse($education->date_of_certificate)->format('d-m-Y') : '-' }} />
                                </div>
                            </div>
                        </div> 
                    </div> 
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
