@extends('user_view.header')
@section('content')


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Leave & Attendance Dashboard</title> --}}
    {{-- <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('user_end/css/leave.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.6/dist/sweetalert2.min.css" rel="stylesheet">

   
</head>

<body>


@if($errors->any())
<div class="alert custom-alert-warning">
<ul>
@foreach($errors->all() as $error)
<li style="color: red;">{{ $error }}</li>

@endforeach
</ul>
</div>
@endif
    <div class="request-btn">
        <h1>Leave & Attendance</h1>
        <button class="btn" onclick="redirectToForm()">Apply Leave</button>
    </div>
    <script>


        function redirectToForm() {
            window.location.href = '{{route('leave_request')}}'; // Replace with the actual form URL
        }
    </script>

    <div class="main">
        <div class="left-sec">
            <div class="one">
                
                <div class="attendance-header">
    <h1>Average Working Hours</h1>
    <canvas id="attendanceChart" style="width: 600px; height: 450px;"></canvas>
    <script>
        // Passing PHP variables into JavaScript using Blade
        const attendanceData = {
            dates: @json(array_column($workingHoursData['working_hours'], 'date')),  // Extract dates array
            hours: @json(array_column($workingHoursData['working_hours'], 'worked_hours'))  // Extract hours array
        };

        // console.log(attendanceData);

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: attendanceData.dates,  // Dates array passed from PHP
                datasets: [{
                    label: 'Hours Worked',
                    data: attendanceData.hours,  // Hours array passed from PHP
                    backgroundColor: '#0E8D4A',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Hours Worked'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                },
                barThickness: 'flex',
                categoryPercentage: 0.6,
                barPercentage: 0.6
            }
        });
    </script>
</div>

                

                <div class="summary">
                        <h1>Leave Summary</h1>
        <div class="leave-summary-container">
            <!-- Leave cards will be dynamically inserted here -->
            @foreach($leaveSummary as $index => $leave)
            
            @endforeach
        </div>

        <script>
            const leaveData = @json($leaveSummary);  // Pass the leave summary data to JavaScript

            // console.log(leaveData); // Check the data in the console to ensure no duplicates

            const colorPalette = [
                ['#8a3366', '#ffc107'], // Two colors: Total Leaves and Consumed Leaves
                ['#2B53C1', '#ffc107']
            ];

            const container = $('.leave-summary-container');

            leaveData.forEach((leave, index) => {
                const totalLeaves = leave.total_leaves;
                const consumed = leave.consumed_leaves || 0;
                const [availableColor, consumedColor] = colorPalette[index % colorPalette.length];

                const cardHtml = `
                    <div class="leave-card">
                        <div class="chart-container-leave">
                            <canvas id="chart${index}" style="width: 130px; height: 200px;"></canvas>
                        </div>
                        <div class="legend">
                            <h2>${leave.leave_type}</h2>
                            <div><span class="dot" style="background-color:${availableColor}"></span>${totalLeaves} Total Leaves</div>
                            <div><span class="dot" style="background-color:${consumedColor}"></span>${consumed} Consumed</div>
                        </div>
                    </div>
                `;

                container.append(cardHtml);

                const ctx = document.getElementById(`chart${index}`).getContext('2d');

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [totalLeaves, consumed],
                            backgroundColor: [availableColor, consumedColor],
                            borderColor: [availableColor, consumedColor],
                            borderWidth: 2,
                            offset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '50%',
                        rotation: Math.PI / 2.8,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
    callbacks: {
        label: function (tooltipItem) {
            // tooltipItem.raw gives the value of the current slice
            const total = tooltipItem.dataset.data[0] + tooltipItem.dataset.data[1];  // 24 + 0.5 = 24.5

            // Calculate percentage
            const percentage = Math.round((tooltipItem.raw / total) * 100);  

            // Return both value and percentage
            return `${tooltipItem.raw} (${percentage}%)`;  // Shows value and percentage
        }
    }
}                
                        }
                    }
                });
            });
        </script>

                </div>
            </div>

            <div class="two">
                <div class="applied-leaves">
                    <h1>Applied Leave</h1>
                    <div class="container">
                        @foreach($appliedLeaves as $leave)
                            <div class="status-item">
                                <div>
                                    <span class="date">
                                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d F, Y') }} - 
                                        {{ \Carbon\Carbon::parse($leave->end_date)->format('d F, Y') }}
                                    </span><br>
                                    <span class="note">{{ $leave->description }}</span>
                                </div>
                                <p>Status: {{ $leave->leave_approve_status }}</p>
                
                                @if(($leave->leave_approve_status == 'Pending' || $leave->leave_approve_status == 'Approved') && \Carbon\Carbon::parse($leave->start_date) > today())
                                    <!-- Form to cancel the leave -->
                                    <form id="cancelForm" action="{{ route('update_leave_status_by_user',['id' => $leave->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')  <!-- Use DELETE HTTP method for cancellation -->
                                        <!-- <button class="cancel-btn" type="submit">Cancel</button> -->
                                        <button class="cancel-btn" type="button" onclick="showConfirmPopup()">
                                        <i class="fas fa-times"></i> <!-- fa-times is the cancel icon -->
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <script>
    function showConfirmPopup() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you really want to cancel the operation?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel it!',
            cancelButtonText: 'No, Keep it',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if the user confirms the cancel action
                document.getElementById('cancelForm').submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // If the user clicks 'No', do nothing and keep the form intact
                Swal.fire(
                    'Cancelled',
                    'Your operation is safe.',
                    'info'
                );
            }
        });
    }
</script>

                
                <div class="attendance">
                <h1>Attendance Overview</h1>
                    <canvas id="newAttendanceChart" width="900px" height="550px"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const newCtx = document.getElementById('newAttendanceChart').getContext('2d');

                            // Fetch the attendance data from the Blade variable
                            const attendanceData = @json($attendanceOverview);

                            // Extract month labels
                            const months = Object.keys(attendanceData).map(month => {
                                return new Date(2025, month - 1, 1).toLocaleString('en-US', { month: 'long' });
                            });

                            // Extract on-time, late, and absent data
                            const onTimeData = Object.values(attendanceData).map(data => data.on_time || 0);
                            const lateData = Object.values(attendanceData).map(data => data.late || 0);
                            const absentData = Object.values(attendanceData).map(data => data.absent || 0);

                            // Determine the max y-axis value for better scaling
                            const maxDays = Math.max(...Object.values(attendanceData).flatMap(obj =>
                                [obj.on_time || 0, obj.late || 0, obj.absent || 0]
                            ));

                            new Chart(newCtx, {
                                type: 'bar',
                                data: {
                                    labels: months,
                                    datasets: [
                                        { label: 'On Time', data: onTimeData, backgroundColor: '#8A3366' },
                                        { label: 'Late', data: lateData, backgroundColor: '#E0AFA0' },
                                        { label: 'Absent', data: absentData, backgroundColor: '#D9D9D9' }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    let datasetLabel = tooltipItem.dataset.label || '';
                                                    let value = tooltipItem.raw;
                                                    return `${datasetLabel}: ${value} days`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: { stacked: true },
                                        y: { stacked: true, beginAtZero: true, suggestedMax: maxDays }
                                    }
                                }
                            });
                        });
                    </script>

                </div>
            </div>

            <div class="three">
            <h1>Absenteeism Rate</h1>
<div class="container-absent">
    <div class="controls">
        <select id="yearSelect"></select>
        <!-- <select id="periodSelect">
            <option value="yearly" selected>Yearly</option>
            <option value="monthly">Monthly</option>
            <option value="weekly">Weekly</option>
        </select> -->
    </div>
    <canvas id="absenteeismChart1" style="width: 800px; height: 250px;"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const absenteeismCtx = document.getElementById('absenteeismChart1').getContext('2d');

        // Dynamically populate the year dropdown (Last 5 years)
        const yearSelect = document.getElementById("yearSelect");
        const currentYear = new Date().getFullYear();
        for (let i = 0; i < 5; i++) {
            let startYear = currentYear - i - 1;
            let endYear = currentYear - i;
            let option = document.createElement("option");
            option.value = `${startYear}-${endYear}`;
            option.textContent = `${startYear}-${endYear}`;
            yearSelect.appendChild(option);
        }

        // Fetch absenteeism data from Laravel
        const attendanceData = @json($attendanceOverview);

        // Function to filter data for a selected year and update the chart
        function updateChartData(yearRange) {
            // Extract start and end years from the selected year range
            const [startYear, endYear] = yearRange.split('-').map(Number);
            
            // Filter months and absenteeism rates based on the selected year
            const months = Object.keys(attendanceData).map(month => {
                return new Date(startYear, month - 1, 1).toLocaleString('en-US', { month: 'long' });
            });

            const absenteeismRates = Object.values(attendanceData).map(data => {
                let totalDays = (data.on_time || 0) + (data.late || 0) + (data.absent || 0);
                return totalDays > 0 ? (data.absent / totalDays) : 0;
            });

            // Create chart gradient
            const gradient1 = absenteeismCtx.createLinearGradient(0, 0, 0, 400);
            gradient1.addColorStop(0, 'rgba(0, 119, 190, 0.8)');
            gradient1.addColorStop(1, 'rgba(0, 70, 130, 0)');

            // Create the chart
            new Chart(absenteeismCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Absenteeism Rate (%)',
                        data: absenteeismRates,
                        borderColor: '#0077be',
                        backgroundColor: gradient1,
                        borderWidth: 4,
                        fill: true,
                        pointBackgroundColor: '#006699',
                        pointBorderColor: '#006699',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.5,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: 'Absenteeism Rate' },
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return (context.raw * 100).toFixed(2) + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            max: Math.max(...absenteeismRates) + 0.05,  // Adjust max dynamically
                            ticks: {
                                callback: function (value) {
                                    return (value * 100).toFixed(2) + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Update chart on year selection change
        yearSelect.addEventListener('change', function () {
            const selectedYear = yearSelect.value;
            updateChartData(selectedYear);
        });

        // Initialize with the first option (default)
        updateChartData(yearSelect.value);
    });
</script>


                </div>
            </div>
        </div>

        <div class="right-sec">
        <h1>Attendance Rate</h1>
<div class="chart-container1" style="width: 100%; padding:30px; text-align: center; background-color:white; border-radius: 30px;">
    <canvas id="chartContainer"></canvas>
</div>
<script>
    // The data passed from the Laravel controller
    const attendanceRateData = {
        present_days: {{ $presentDays }},
        absent_days: {{ $absentDays }}
    };

    const presentDays = attendanceRateData.present_days;
    const absentDays = attendanceRateData.absent_days;
    const totalDays = presentDays + absentDays;

    // Calculate the attendance rate
    const attendanceRate = totalDays ? ((presentDays / totalDays) * 100).toFixed(2) : 0;

    // Initialize the chart
    const ctxs = document.getElementById('chartContainer').getContext('2d');
    const chartContainer = new Chart(ctxs, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [presentDays, absentDays],
                backgroundColor: ['#3086FF', '#2B53C1BF'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { size: 14 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            const label = tooltipItem.label || '';
                            const value = tooltipItem.raw;
                            const percentage = ((value / totalDays) * 100).toFixed(2);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                },
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDraw: function (chart) {
                const { width, height } = chart;
                const ctx = chart.ctx;
                ctx.restore();
                const fontSize = (height / 150).toFixed(2);
                ctx.font = `${fontSize}em sans-serif`;
                ctx.textBaseline = 'middle';
                ctx.textAlign = 'center';

                const text = `${attendanceRate}%`;
                const textX = width / 2;
                const textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    });
</script>


<div class="leave-type">
    <h1>Leave Type</h1>
    <div class="container-type">
        @foreach($leaveSummary as $leave)
            <button class="button" style="background-color: {{ $loop->index % 2 == 0 ? '#8a3366' : '#2B53C1' }};">
                {{ $leave['leave_type'] }}
            </button>
        @endforeach
    </div>
</div>


            <h1>Upcoming Holidays</h1>
            <div class="holidays">
                <div class="container-holiday">
                    <ul class="holiday-list">
                        @foreach ($holidays_upcoming as $holiday)

                        <li class='holiday-item highlight'>
                        <span class="date1 yellow-box">{{ \Carbon\Carbon::parse($holiday->formatted_date)->format('d M') }}</span>
                            <span class="holiday-name">
                                <strong>{{ $holiday->holiday_name }}</strong>
                                <p>{{ $holiday->day }}</p> 
                            </span>
                        </li>  
                            
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom">
    <div class="leave-details">
        <h1>Leave Balance Summary</h1>
        <table>
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>Entitled Days</th>
                    <th>Carry Forward</th>
                    <th>Encash</th>
                    <th>Taken Leaves</th>
                    <th>Remaining Leave</th>
                    <th>Loss of Pay</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($leaveSummary as $leave)
                <tr>
                    <td>{{ $leave['leave_type'] }}</td>
                    <td>{{ rtrim(rtrim(number_format($leave['total_leaves'], 2, '.', ''), '0'), '.') }} days</td>
                    <td>{{ rtrim(rtrim(number_format($leave['no_carry_forward'], 2, '.', ''), '0'), '.') }} days</td>
                    <td>{{ rtrim(rtrim(number_format($leave['no_leave_encash'], 2, '.', ''), '0'), '.') }} days</td>
                    <td>{{ rtrim(rtrim(number_format($leave['consumed_leaves'], 2, '.', ''), '0'), '.') }} days</td>
                    <td>{{ rtrim(rtrim(number_format($leave['remaining_leaves'], 2, '.', ''), '0'), '.') }} days</td>
                    <td>0 days</td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>
@endsection