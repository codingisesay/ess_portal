@extends('user_view.header')
@section('content')
 
   <!-- <a href="{{ route('claim_form') }}"><button class="w3-button w3-green">Claim</button></a> -->
   <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">  
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/payroll.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
      <div class="payrole-dashboard">
      
            <div class="row">
            <!-- graph 1 -->
            <div class="col-5">
                <div class="payslip-card">
                    <div class="header d-flex">
                    <h5 class="me-auto mb-0">Overview</h5>
                    <div> 
                        FY   
                        <select>
                        <option value="2024-25">2024-25</option>
                        <option value="2025-26">2025-26</option>
                        </select>
                        |
                        <select>
                        <option value="q1">Q1(jan-march)</option> 
                        <option value="q2">Q2(Apr-June)</option> 
                        </select>
                        |
                        <select>
                        <option value="q1">January</option> 
                        <option value="q2">February</option> 
                        <option value="q2">March</option> 
                        </select>
                    </div>
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
                            <button class="btn btn-outline-secondary py-0 d-flex justify-centent-center align-items-center"> 
                                <x-icon name="eyefill" />&nbsp; Show/hide details
                            </button>
                            <br> 
                            <div class="payment-row1" >
                                <small class="payment-label" >Take Home</small><br/>
                                <h5 class="payment-amount">80,000.00</h5>
                            </div>
                            <div class="payment-row2">
                                <small class="payment-label">Deductions</small><br/>
                                <h5 class="payment-amount">6,000.00</h5>
                            </div>
                            <div class="payment-row3">
                                <small class="payment-label">Gross Pay</small><br/>
                                <h5 class="payment-amount gross-pay">86,000.00</h5>
                            </div>
                    
                            <button class="view-btn mt-4"><i class="bi bi-file-earmark-arrow-down"></i> Get Payslips</button>
                        </div>
                        
                    </div>
                    </div>
                    
                </div>
            </div >
            <!-- graph 2 -->
            <div class="col-7">
                <div class="tax-trend-card payslip-card">
                <div class="header d-flex">
                    <h5 class="me-auto mb-0">Income Tax Trend</h5> 
                        <div> FY   
                        <select>
                            <option value="2024-25">2024-25</option>
                            <option value="2025-26">2025-26</option>
                        </select>
                        </div>
                </div>
                <hr> 
                <div class="chart-container">
                    <canvas id="taxChart"></canvas>
                </div>
                
                <div class="month-labels mb-2">
                    <div class="month-label">Apr-2022</div>
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
                    <div class="month-label">Mar-2023</div>
                </div>
                
            </div>
            </div>
            <!-- table below -->
            <div class="col-12 my-4">
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
                                    <th>Amount</th>
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
                                        <td class="text-end">₹{{ number_format($claim->total_amount, 2) }}</td>
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
        // Chart.js implementation
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('paymentChart').getContext('2d');            
            const paymentChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Take Home', 'Deductions'],
                    datasets: [{
                        data: [80000, 6000],
                        backgroundColor: [
                            '#61C9A1  ',   // Blue for Take Home
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
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ₹${value.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            
            document.querySelector('.view-btn').addEventListener('click', function() {
                alert('Payslip details would be displayed here');
                // In a real implementation, this would navigate to another page or show more details
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
            // Sample data - you would replace with actual monthly tax values
            const monthlyTaxData = [22000, 24000, 26000, 28000, 27000, 25000, 
                                    23000, 26000, 29000, 31000, 28000, 27000];            
            const taxChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['', '', '', '', '', '', '', '', '', '', '', ''], // Empty labels as we're showing them separately below
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
                            display: false,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: false,
                            min: 20000,
                            max: 35000,
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
    @endsection
