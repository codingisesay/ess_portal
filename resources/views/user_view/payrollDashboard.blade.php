@extends('user_view.header')
@section('content')
 
    <!-- <a href="{{ route('claim_form') }}"><button class="w3-button w3-green">Claim</button></a> -->
   <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">  

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      .payrole-dashboard{margin:10px 30px}
        .payslip-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); 
            padding: 25px;
            position: relative;
        }
         
         
        .financial-year {
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .quarter {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }
         
        
        .payment-details {
            margin: 25px 0;
        }
        .payment-details small{font-size:12px; color : #333}
        
        .payment-row1,
        .payment-row2,
        .payment-row3 {
          padding-left:7px;
            border-left: 4px solid #3498db;
            margin-bottom: 12px;
        }
        .payment-row2{border-left: 4px solid #e74c3c;}
        .payment-row3{border-left: 4px solid #2c3e50;}  
        
        .payment-label {
            font-size: 16px;
            color: #555;
        }
        .view-btn i {
            vertical-align:middle
        }
        .payment-amount {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .gross-pay {
            font-weight: 700;
            color: #2c3e50;
        }
        
        .chart-container {
            margin: 20px 0;
            height: 250px;
            position: relative;
        }
        
        .view-btn {
            display: block; 
            padding: 5px 12px;
            background-color: #8A3366;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        
        .view-btn:hover {
            background-color: #2980b9;
        }
        .payslip-card select {
            padding:2px  5px; 
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        
        @media (max-width: 480px) {
            .payslip-card {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .chart-container {
                height: 200px;
            }
        }
    </style>
 

      <div class="payrole-dashboard">
            <div class="col-5">
              <h2>Payrole</h2>
              <div class="payslip-card">
                  <div class="header d-flex">
                    <h4 class="me-auto mb-0">Overview</h4>
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
                  
                          <button class="view-btn "><i class="bi bi-file-earmark-arrow-down"></i> Get Payslips</button>
                        </div>
                      
                    </div>
                  </div>
                  
              </div>
            </div >
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
    
    
    @endsection
