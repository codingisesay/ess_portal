@extends('user_view.header')
@section('content')
 
   <!-- <a href="{{ route('claim_form') }}"><button class="w3-button w3-green">Claim</button></a> -->
   <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">  
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/payroll.css') }}">
    <link href="{{ asset('bootstrapcss/bootstrap.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('bootstrapjs/bootstrap.js') }}" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
      <div class="payrole-dashboard">
      
            <div class="row">
            <!-- graph 1 -->
            <div class="col-md-5 my-2">
                <div class="payslip-card">
                    <div class="header d-flex ">
                        <h5 class="mb-0">Overview</h5>
                        <span class="ms-auto d-flex flex-wrap  justify-content-end"> 
                            <span class="d-flex justify-content-end"> 
                            <select class="border-bottom">
                            <option value="2024-25">FY2025-26</option>
                            <option value="2025-26">FY2026-27</option>
                            </select>
                            |</span>
                            <span class="d-flex justify-content-end">
                                <select class="border-bottom">
                                <option value="q1">Q1(jan-march)</option> 
                                <option value="q2">Q2(Apr-June)</option> 
                                </select>
                            |</span>
                            <span>
                                <select class="border-bottom">
                                <option value="q1">January</option> 
                                <option value="q2">February</option> 
                                <option value="q2">March</option> 
                                </select>
                            </span>
                        </span>
                    </div> 
                    <hr cass="my-0">
                    
                    <div class="row">
                    <div class="col-6">
                        <div class="chart-container">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="payment-details">
                            <button id="toggleButton"  class="btn btn-outline-secondary py-1 d-flex justify-centent-center align-items-center"> 
                                Salary Brief Show
                            </button>
                            <br> 
                                <!-- Payment Info -->
                                <div class="payment-row1">
                                    <small class="payment-label">Take Home</small><br/>
                                    <h6 class="payment-amount" data-amount="{{ number_format($payrollData->net_amount ?? 0, 2) }}">₹ *****</h6>
                                </div>
                                <div class="payment-row2">
                                    <small class="payment-label">Deductions</small><br/>
                                    <h6 class="payment-amount" data-amount="{{ number_format($payrollData->total_dedcutions ?? 0, 2) }}">₹ *****</h6>
                                </div>
                                <div class="payment-row3">
                                    <small class="payment-label">Gross Pay</small><br/>
                                    <h6 class="payment-amount gross-pay" data-amount="{{ number_format($payrollData->total_earnings ?? 0, 2) }}">₹ *****</h6>
                                </div>
                              
                            <button class="submit d-flex jusify-content-center align-items-center mt-3 px-3 py-1"  onclick="openSalaryModal()">
                                <i class="bi bi-file-earmark-arrow-down"></i>&nbsp;Get&nbsp;Payslips
                            </button>
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div >
            <!-- graph 2 -->
            <div class="col-md-7 my-2">
                <div class="tax-trend-card payslip-card">
                <div class="header d-flex">
                    <h5 class="me-auto mb-0">Income Tax Trend</h5> 
                     <div>
                    "Financial Year"
               <select id="financialYearSelect" onchange="updateTaxChart()">
                
            </select>
                </div>
                </div>
                <hr>  
                <div class="chart-container">
                    <canvas id="taxChart"></canvas>
                </div>
                
                <div class="month-labels mb-2">
                    <!-- <div class="month-label">Apr-2022</div>
                    <div class="month-label">May-2022</div>
                    <div class="month-label">Jun-2022</div>
                    <div class="month-label">Jul-2022</div>
                    <div class="month-label">Aug-2022</div>
                    <div class="month-label">Sep-2022</div>
                    <div class="month-label">Oct-2022</div>
                    <div class="month-label">Nov-2022</div>
                    <div class="month-label">Dec-2022</div>
                    <div class="month-label">Jan-2023</div>
                    <div class="month-label">Feb-2023</div>
                    <div class="month-label">Mar-2023</div> -->
                </div>
                
            </div>
            </div>
            <!-- table below -->
            <div class="col-12 my-2">
                <div class="payslip-card"> 
                <div class="header d-flex justify-content-between align-items-center ">
                    <h5 class=" mb-0">Reimbursement Claims List</h5> 
                    <button class=" px-3 py-1 "> 
                        <a href="{{ route('claim_form') }}" class="text-decoration-none text-white">Claim Reimbursement</a>
                    </button>
                </div>
                <hr class="my-2">       
                <div class=" reimbursment-filter-button-collection mb-2">
                    <button class="me-3 py-1 btn border-0 btn-outline-primary filter-btn filter-btn active" data-status="ALL">All</button>
                    <button class="me-3 py-1 btn border-0 btn-outline-success filter-btn " data-status="APPROVED">Approved</button>
                    <button class="me-3 py-1 btn border-0 btn-outline-warning filter-btn " data-status="PENDING">Pending</button>
                    <button class="me-3 py-1 btn border-0 btn-outline-danger filter-btn " data-status="REJECTED">Rejected</button>
                    <button class="me-3 py-1 btn border-0 btn-outline-info filter-btn " data-status="REVERT">Revert</button>
                </div> 
                    <div class="tbl-container reimbursment-tbl-height p-0">
                        <table>
                            <thead class="position-sticky " style="margin-top:-1px">
                                <tr>
                                    <th>Claim ID</th>
                                    <th>Date</th>
                                    <th>Amount(₹)</th>
                                    <th>Purpose of Claim</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reimbursementClaims as $claim)
                                    <!-- <tr> --><tr data-status="{{ $claim->status }}">

                                        <td>{{ $claim->token_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($claim->claim_date)->format('d/m/Y') }}</td>
                                        <td class="text-end">{{ number_format($claim->total_amount, 2) }}</td>
                                        <td>{{ $claim->purpose }}</td>
                                        <td> 
                                            @php
                                                $statusClass = match($claim->status) {
                                                    'PENDING' => 'badge-warning',
                                                    'APPROVED BY MANAGER' => 'badge-approved',
                                                    'APPROVED' => 'badge-approved',
                                                    'REJECTED' => 'badge-danger',
                                                    'CANCELLED' => 'badge-danger',
                                                    'REVERT' => 'badge-info',
                                                    'INREVIEW' => 'review',
                                                    default => ''
                                                };
                                            @endphp

                                            <small class="{{ $statusClass }} status-badge">
                                                {{ $claim->status }}
                                            </small>

                                        </td>
                                        <td>
                                            <button>
                                            <a href="{{ route('review_claim_form', ['reimbursement_traking_id' => $claim->tracking_id]) }}" class="text-raspberry ">
                                                <x-icon name="eyefill" />
                                            </a></button>
                                            @if ($claim->status == 'REVERT')
                                            <button>
                                                <a href="{{ route('edit_claim_form', ['reimbursement_traking_id' => $claim->tracking_id]) }}" class="text-raspberry">
                                                    <x-icon name="edit" />
                                                </a></button>
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
    


    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('paymentChart').getContext('2d');            
    const paymentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Take Home', 'Deductions'],
            datasets: [{
                data: [{{ $payrollData->net_amount ?? 0 }}, {{ $payrollData->total_dedcutions ?? 0 }}],
                backgroundColor: [
                    '#3498DB',   // Blue for Take Home
                    '#e74c3c'    // Red for Deductions
                ],
                borderColor: [
                    '#fff',
                    '#fff'
                ],
                borderWidth: 2
            }]
        },
        options: {
            interaction: {
                mode: 'nearest',
                intersect: false
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: false
            }
        }
    });
});
    </script>
    
    <script>
        // filter for reimbursment table
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const rows = document.querySelectorAll('tbody tr');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active'); 

                    const status = button.getAttribute('data-status');

                    rows.forEach(row => {
                        const rowStatus = row.getAttribute('data-status');

                        if (status === 'ALL' || rowStatus === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('taxChart').getContext('2d');  
    
    // **1. Use the data from the server directly**
    const monthlyTaxData = @json($fullYearData);
    
    // **2. Create the Chart**
    window.taxChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Monthly Tax',
                data: monthlyTaxData,
                backgroundColor: '#8A3366',
                borderColor: '#8A3366',
                borderWidth: 3,
                tension: 0.3,
                pointBackgroundColor: '#8A3366',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true
            }]
        },
        options: {
            interaction: {
                mode: 'nearest',
                intersect: false
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Tax: ₹' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: '#eee'
                    }
                }
            }
        }
    });
});
</script>



    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const amounts = document.querySelectorAll(".payment-amount");
        const toggleButton = document.getElementById("toggleButton");
        let isMasked = true; // start with masked values

        toggleButton.addEventListener("click", function () {
            amounts.forEach(el => {
                if (isMasked) {
                    el.textContent = '₹ ' + el.getAttribute("data-amount"); // show amount
                } else {
                    el.textContent = "₹ *****"; // mask amount
                }
            });

            // Toggle button text
            toggleButton.textContent = isMasked ? "Salary Brief Hide" : "Salary Brief Show";
            isMasked = !isMasked;
        });
    });
</script>

<script>

// Leave Model script below
function openSalaryModal() {
    document.getElementById('leaveModal').style.display = 'block';  // Show the modal
}

// Close the leave modal
function closeSalaryModal() {
    document.getElementById('leaveModal').style.display = 'none';  // Hide the modal
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var taskModal = document.getElementById('taskModal');
    var leaveModal = document.getElementById('leaveModal');

    // Close task modal if clicked outside
    if (event.target === taskModal) {
        closeTaskModal();
    }

    // Close leave modal if clicked outside
    if (event.target === leaveModal) {
        closeSalaryModal();
    }
}
// Leave Model script above
  
</script>
  
    <!-- salary model  -->
    <div id="leaveModal" class="modal"  >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <h4>  Salary Slips</h4>
                <span class="close" onclick="closeSalaryModal()">×</span>
                <!-- <h5>Salary Details For : EMP001 </h5> -->
                <div class="tbl-container">
                <table>
                    <thead>
                        <tr>
                            <th>Salary Month</th>
                            @foreach ($payrollDeductions->groupBy('component_name') as $componentName => $deductions)
                                <th>{{ $componentName }}</th>
                            @endforeach
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payrollDeductions->groupBy('salary_month') as $month => $deductionsByMonth)
                            <tr>
                                <td>{{ $month }}</td>
                                @foreach ($payrollDeductions->groupBy('component_name') as $componentName => $deductions)
                                    <td>
                                        ₹{{ number_format($deductionsByMonth->where('component_name', $componentName)->sum('amount'), 2) }}
                                    </td>
                                @endforeach
                                <td>
                                <a href="{{ route('download_payslip', ['payroll_id' => $deductionsByMonth->first()->payroll_id]) }}" class="me-4 text-decoration-none" download>
                                        <x-icon name="pdf" />
                                    </a> 
                                    <a href="{{ route('load_payslip', ['payroll_id' => $deductionsByMonth->first()->payroll_id]) }}" class="me-4 text-decoration-none" target="_blank">
                                        <x-icon name="eyefill" /> 
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
 
    @endsection
