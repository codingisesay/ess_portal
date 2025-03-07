@extends('user_view.header');
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave & Attendance Dashboard</title>
    <link rel="icon" href="{{ asset('user_end/images/STPLLogo butterfly.png') }}" />
    <link rel="stylesheet" href="{{ asset('user_end/css/leave.css') }}">
    <link rel="stylesheet" href="{{ asset('errors/error.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    @if(session('success'))
<div class="alert custom-alert-success">
    <strong>{{ session('success') }}</strong> 
    <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    
</div>
@endif

@if(session('error'))
<div class="alert custom-alert-error">
<strong> {{ session('error') }}</strong>
<button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
</div>
@endif

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
        <button class="apply-leave" onclick="redirectToForm()">Apply Leave</button>
    </div>
    <script>
        // function redirectToForm() {
        //     window.location.href = 'leave_request_app.php'; // Replace with the actual form URL
        // }

        function redirectToForm() {
            window.location.href = '{{route('leave_request')}}'; // Replace with the actual form URL
        }
    </script>

    <div class="main">
        <div class="left-sec">
            <div class="one">
                <div class="attendance-header">
                    <h1>Average Working Hours</h1>
                    <canvas id="attendanceChart" style="width: 500px; height: 400px;"></canvas>
                    <script>
                        const attendanceData = {
                            dates: ['2023-01-01', '2023-01-02', '2023-01-03'],
                            hours: [8, 7.5, 8.5]
                        };

                        const ctx = document.getElementById('attendanceChart').getContext('2d');
                        const attendanceChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: attendanceData.dates,
                                datasets: [{
                                    label: 'Hours Worked',
                                    data: attendanceData.hours,
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
                    </div>
                    <script>
                        const leaveData = [
                            { leave_type: 'Annual Leave', entitled_days: 20, consumed_leaves: 5 },
                            { leave_type: 'Sick Leave', entitled_days: 10, consumed_leaves: 2 }
                        ];

                        const colorPalette = [
                            ['#8a3366', '#ffc107'],
                            ['#2B53C1', '#8A3366']
                        ];

                        const container = $('.leave-summary-container');

                        leaveData.forEach((leave, index) => {
                            const available = leave.entitled_days;
                            const consumed = leave.consumed_leaves || 0;
                            const [availableColor, consumedColor] = colorPalette[index % colorPalette.length];

                            const cardHtml = `
                                <div class="leave-card">
                                    <div class="chart-container-leave">
                                        <canvas id="chart${index}" style="width: 130px; height: 200px;"></canvas>
                                    </div>
                                    <div class="legend">
                                        <h2>${leave.leave_type}</h2>
                                        <div><span class="dot" style="background-color:${availableColor}"></span>${available} Available</div>
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
                                        data: [available, consumed],
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
                                                    const total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                                                    const percentage = Math.round((tooltipItem.raw / total) * 100);
                                                    return `${tooltipItem.label}: ${percentage}%`;
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
                        <div class='status-item'>
                            <div>
                                <span class='date'>01 January, 2023</span><br>
                                <span class='note'>Family emergency</span>
                            </div>
                            <button class='btn pending'>PENDING</button>
                        </div>
                        <div class='status-item'>
                            <div>
                                <span class='date'>15 February, 2023</span><br>
                                <span class='note'>Medical appointment</span>
                            </div>
                            <button class='btn approved'>APPROVED</button>
                        </div>
                    </div>
                </div>

                <div class="attendance">
                    <h1>Attendance Overview</h1>
                    <canvas id="newAttendanceChart" width="900px" height="550px"></canvas>
                    <script>
                        const newCtx = document.getElementById('newAttendanceChart').getContext('2d');

                        const attendanceData = {
                            'April': { on_time: 20, late: 5, absent: 2 },
                            'May': { on_time: 22, late: 3, absent: 1 },
                            'June': { on_time: 18, late: 7, absent: 3 }
                        };

                        const months = ['April', 'May', 'June'];
                        const onTimeData = months.map(month => attendanceData[month]?.on_time || 0);
                        const lateData = months.map(month => attendanceData[month]?.late || 0);
                        const absentData = months.map(month => attendanceData[month]?.absent || 0);

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
                                scales: {
                                    x: { stacked: true },
                                    y: { stacked: true, beginAtZero: true, suggestedMax: maxDays }
                                }
                            }
                        });
                    </script>
                </div>
            </div>

            <div class="three">
                <h1>Absenteeism Rate</h1>
                <div class="container-absent">
                    <div class="controls">
                        <select id="yearSelect">
                            <option value="2023-24">2023-24</option>
                            <option value="2022-23">2022-23</option>
                            <option value="2021-22">2021-22</option>
                        </select>
                        <select id="periodSelect">
                            <option value="yearly">Yearly</option>
                            <option value="monthly">Monthly</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    <canvas id="absenteeismChart1" style="width: 800px; height: 250px;"></canvas>
                    <script>
                        const absenteeismData = {
                            days: ['Monday', 'Tuesday', 'Wednesday'],
                            waveData: [0.1, 0.2, 0.15]
                        };

                        const absenteeismCtx = document.getElementById('absenteeismChart1').getContext('2d');

                        const gradient1 = absenteeismCtx.createLinearGradient(0, 0, 0, 400);
                        gradient1.addColorStop(0, 'rgba(0, 119, 190, 0.8)');
                        gradient1.addColorStop(1, 'rgba(0, 70, 130, 0)');

                        new Chart(absenteeismCtx, {
                            type: 'line',
                            data: {
                                labels: absenteeismData.days,
                                datasets: [{
                                    label: 'Absenteeism Rate (%)',
                                    data: absenteeismData.waveData,
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
                                        max: 1,
                                        ticks: {
                                            callback: function (value) {
                                                return (value * 100).toFixed(2) + '%';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="right-sec">
            <h1>Attendance Rate</h1>
            <div class="chart-container1" style="width: 100%; padding:30px; text-align: center; background-color:white;  border-radius: 30px;">
                <canvas id="chartContainer"></canvas>
            </div>
            <script>
                const attendanceRateData = {
                    present_days: 180,
                    absent_days: 20
                };

                const presentDays = attendanceRateData.present_days;
                const absentDays = attendanceRateData.absent_days;
                const totalDays = presentDays + absentDays;
                const attendanceRate = totalDays ? ((presentDays / totalDays) * 100).toFixed(2) : 0;

                const ctx = document.getElementById('chartContainer').getContext('2d');
                const chartContainer = new Chart(ctx, {
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
                            centerText: {
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
                            }
                        }
                    },
                    plugins: [{
                        id: 'centerText',
                        beforeDraw: function (chart) {
                            const { width, height } = chart;
                            const ctx = chart.ctx;
                            ctx.restore();
                            const fontSize = (height / 130).toFixed(2);
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
                    <button class='button' style='background-color: #8a3366;'>Annual Leave</button>
                    <button class='button' style='background-color: #2B53C1;'>Sick Leave</button>
                </div>
            </div>

            <h1>Upcoming Holidays</h1>
            <div class="holidays">
                <div class="container-holiday">
                    <ul class="holiday-list">
                        <li class='holiday-item highlight'>
                            <span class='date1 yellow-box'>14 JAN</span>
                            <span class='holiday-name'>New Year's Day</span>
                            <span class='day'>Monday</span>
                        </li>
                        <li class='holiday-item'>
                            <span class='date1 yellow-box'>25 DEC</span>
                            <span class='holiday-name'>Christmas Day</span>
                            <span class='day'>Friday</span>
                        </li>
                        <li class='holiday-item hidden'>
                            <span class='date1 gray-box'>01 MAY</span>
                            <span class='holiday-name'>Labor Day</span>
                            <span class='day'>Saturday</span>
                        </li>
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
                    <tr>
                        <td>Annual Leave</td>
                        <td>20 days</td>
                        <td>5 days</td>
                        <td>2 days</td>
                        <td>10 days</td>
                        <td>8 days</td>
                        <td>0 days</td>
                    </tr>
                    <tr>
                        <td>Sick Leave</td>
                        <td>10 days</td>
                        <td>0 days</td>
                        <td>0 days</td>
                        <td>2 days</td>
                        <td>8 days</td>
                        <td>0 days</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
@endsection
</html>