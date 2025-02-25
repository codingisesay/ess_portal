@extends('user_view.header')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Human Resource Policy</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F6F5F7;
            margin: 0;
            padding: 0;
        }

        /* Container for entire page */
        .container {
            display: flex;
            height: 100vh;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #F6F5F7;
            color: black;
            padding: 20px;
            border-bottom: 2px solid #ddd;
        }

        .header h1 {
            font-size: 32px;
            width: 399px;
            height: 48px;
            top: 148px;
            left: 37px;
            weight: 500;
            Line height: 48px;
            Letter: 3% font: Poppins
        }


        /* Search Bar */
        .search-bar {
            display: flex;
            align-items: center;
            background-color: #F6F5F7;
            border-radius: 50px;
            padding: -1px 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border: solid #FFFFFF 3px;

        }

        .search-bar input {
            border: none;
            outline: none;
            font-size: 16px;
            flex: 1;
            background-color: #F6F5F7;
            margin-left: 10px;

        }

        .search-icon-circle {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #8A3366;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            margin-left: 15px;
            border: solid #FFFFFF 5px;
        }

        .search-icon-circle img {
            width: 20px;
            height: 20px;
        }

        /* Main Container */
        .main-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin-top: 20px;
            height: 100vh;
            margin: 25px;
        }

        /* Sidebar */
        .sidebar {
            background-color: #FFFFFF;
            width: 316px;
            padding: 35px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: 949px;
            Radius: 30px;
            Top: 243px;
            Left: 37px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
        }



        /* Category Item (Separate Icon and Text Aligned Side-by-Side) */
        .category-item {
            display: flex;
            align-items: center;
            padding: 0px;
            border-radius: 12px;
            cursor: pointer;
            margin-bottom: 50px;
            background-color: #D9D9D9;
            transition: background-color 0.3s ease;
            width: 232px;
            height: 28px;

        }

        .category-item.active {
            background-color: #8A3366;
            color: #fff;
        }

        .category-item .category-icon {
            background-color: #D9D9D9;
            /* Light background color for the rectangle */
            padding: 10px 10px;
            /* Add padding to create a rectangle shape */
            border-radius: 8px;
            /* Optional: Adds rounded corners to the rectangle */
            transition: background-color 0.3s ease;
            /* Optional: Smooth transition for hover */
            width: 60px;
            height: 60px
        }

        .category-item .category-icon img {

            width: 35px;
            /* Adjust the icon size */
            height: 35px;
            /* Adjust the icon size */
            top: 286px;
            left: 80px;
        }

        .category-item .category-text {
            font-size: 12px;
            font-weight: 700;
            color: #333;
            width: 485px;
            /* height: 28px; */
            padding: 8px;
        }

        .category-item.active .category-text {
            color: #fff;

        }

        .category-item.active .category-icon img {}



        /* Content Area */
        .content-area {
            flex: 1;
            background-color: #FFFFFF;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: none;
            position: relative;
            margin: 25px;
            width: 1130px;
            height: fit-content;
        }

        .content-area.active {
            display: block;
        }

        .download-btn {
            background-color: #8A3366;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .download-btn img {
            margin-right: 10px;
            width: 20px;
            height: 20px;
        }

        /* Policy content */
        .policy-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .content-text {
            max-width: 60%;
        }

        .content-item h3 {
            background-color: #FFC107;
            font-size: 14px;
            color: #FFFFFF;
            padding: 8px 16px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: inline-block;
            cursor: pointer;
            width: fit-content;
            height: 33px;
            text-align: left;
        }

        .content-item p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            width: 624px;
            height: 90px;
        }

        .content-image {
            margin-left: 20px;
            text-align: center;
            position: relative;
            margin-top: 50px;
        }

        .content-image img {
            width: 425px;
            height: 300px;
        }
        @media (max-width: 1200px) {
        .main-container {
            flex-direction: column;
            width: 100%;
            margin: 0;
            padding: 0 20px;
        }

        .sidebar {
            width: 100%;
            margin-bottom: 20px;
            height: auto;
        }

        .content-area {
            width: 100%;
            margin: 0;
        }

        .policy-content {
            flex-direction: column;
        }

        .content-text {
            max-width: 100%;
        }

        .content-image {
            margin-left: 0;
            margin-top: 20px;
        }
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .search-bar {
            width: 100%;
            margin-top: 10px;
        }

        .main-container {
            padding: 0 10px;
        }

        .sidebar {
            padding: 20px;
        }

        .category-item {
            margin-bottom: 10px;
            width: 100%;
        }

        .content-area {
            padding: 20px;
        }

        .download-btn {
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .download-btn img {
            width: 16px;
            height: 16px;
        }

        .content-item h3 {
            font-size: 12px;
            padding: 6px 12px;
        }

        .content-item p {
            font-size: 14px;
            width: 100%;
        }

        .content-image img {
            width: 100%;
            height: auto;
        }
    }

    @media (max-width: 480px) {
        .header h1 {
            font-size: 20px;
        }

        .search-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-bar input {
            width: 100%;
            margin: 0 0 10px 0;
        }

        .search-icon-circle {
            width: 40px;
            height: 40px;
        }

        .search-icon-circle img {
            width: 16px;
            height: 16px;
        }

        .main-container {
            padding: 0 5px;
        }

        .sidebar {
            padding: 10px;
        }

        .category-item {
            padding: 5px;
        }

        .content-area {
            padding: 10px;
        }

        .download-btn {
            top: 5px;
            right: 5px;
            padding: 5px;
            font-size: 12px;
        }

        .download-btn img {
            width: 12px;
            height: 12px;
        }

        .content-item h3 {
            font-size: 10px;
            padding: 4px 8px;
        }

        .content-item p {
            font-size: 12px;
        }

        .content-image img {
            width: 100%;
            height: auto;
        }
    }
        
    </style>
</head>

<body>
    
    <!-- Header Section -->
    <div class="header">
        <h1>Human Resource Policy</h1>
        <div class="search-bar">
            <input type="text" placeholder="Search here..." id="searchInput">
            <div class="search-icon-circle">
                <img src="../resource/image/hrpolicy/hr_img/search (2) 2.png" alt="Search Icon">
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container">
        <div class="main-container">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="category-item" data-category="Purpose & Scope">
                    <div class="category-icon">
                        <img src="dart-board 1.png">
                    </div>
                    <div class="category-text">
                        <span>Purpose & Scope</span>
                    </div>
                </div>
                <div class="category-item" data-category="Employment Practices">
                    <div class="category-icon">
                        <img src="employment 1.png">
                    </div>
                    <div class="category-text">
                        <span>Employment Practices</span>
                    </div>
                </div>
                <div class="category-item" data-category="Compensation Benefits">
                    <div class="category-icon">
                        <img src="employee-benefit 1.png">
                    </div>
                    <div class="category-text">
                        <span>Compensation Benefits</span>
                    </div>
                </div>
                <div class="category-item" data-category="Work Hours & Attendance">
                    <div class="category-icon">
                        <img src="business (1) 1.png">
                    </div>
                    <div class="category-text">
                        <span>Work Hours & Attendance</span>
                    </div>
                </div>
                <div class="category-item" data-category="Code Of Conduct">
                    <div class="category-icon">
                        <img src="code-of-conduct 1.png">
                    </div>
                    <div class="category-text">
                        <span>Code Of Conduct</span>
                    </div>
                </div>
                <!-- Add more categories as needed -->
            </div>

            <!-- Content Area -->
            <div class="content-area" data-category="Purpose & Scope">
                <a href="path/to/employment-document.pdf" class="download-btn" download>
                    <img src="../resource/image/hrpolicy/hr_img/download 1 (2).png" alt="Download Icon"> Download
                </a>

                <div class="policy-content">
                    <div class="content-text">
                        <div class="content-item">
                            <h3>Objective</h3>
                            <p>This policy outlines the standards and procedures for managing employee relations,
                                benefits and workplace conduct at SIL Technologies.</p>
                        </div>
                        <div class="content-item">
                            <h3>Scope</h3>
                            <p>This policy applies to all employees including full-time, part-time, temporary and
                                contractual staffs</p>
                        </div>
                    </div>
                    <div class="content-image">
                        <img src="purpose.png">
                    </div>
                </div>
            </div>

            <div class="content-area" data-category="Employment Practices">
                <a href="path/to/compensation-document.pdf" class="download-btn" download>
                    <img src="../resource/image/hrpolicy/hr_img/download 1 (2).png" alt="Download Icon"> Download
                </a>

                <div class="policy-content">
                    <div class="content-text">
                        <div class="content-item">
                            <h3>Equal opportunity to employment</h3>
                            <p>SIL Technologies is an equal opportunity employer. We do not discriminate based on race,
                                color, religion, sex, national origin, age, disability, or any other protected category.
                            </p>
                        </div>
                        <div class="content-item">
                            <h3>Recruitment and Hiring</h3>
                            <p>All recruitment and hiring practices will be conducted fairly and in accordance with
                                applicable laws. Job postings, interviewing, and selection will be based on
                                qualifications and experience.
                            </p>
                        </div>
                    </div>
                    <div class="content-image">
                        <img src="4151017 1.png" alt="Compensation Benefits Image">
                    </div>
                </div>
            </div>
            <div class="content-area" data-category="Compensation Benefits">
                <a href="path/to/compensation-document.pdf" class="download-btn" download>
                    <img src="../resource/image/hrpolicy/hr_img/download 1 (2).png" alt="Download Icon"> Download
                </a>

                <div class="policy-content">
                    <div class="content-text">
                        <div class="content-item">
                            <h3>Salary Structure</h3>
                            <p>Salaries will be determined based on job responsibilities, market rates, and individual
                                performance. </p>
                        </div>
                        <div class="content-item">
                            <h3>Benefits</h3>
                            <p>Employees are eligible for [list of benefits, e.g., health insurance, retirement plans,
                                paid leave]. Detailed information about benefits is provided during the onboarding
                                process.

                            </p>
                        </div>
                    </div>
                    <div class="content-image">
                        <img src="leave.jpg" alt="Compensation Benefits Image">
                    </div>
                </div>
            </div>
            <div class="content-area" data-category="Work Hours & Attendance">
                <a href="path/to/compensation-document.pdf" class="download-btn" download>
                    <img src="../resource/image/hrpolicy/hr_img/download 1 (2).png" alt="Download Icon"> Download
                </a>

                <div class="policy-content">
                    <div class="content-text">
                        <div class="content-item">
                            <h3>Work Schedule</h3>
                            <p>Standard working hours are from [start time] to [end time], [days of the week]. Any
                                changes to this schedule will be communicated in advance. </p>
                        </div>
                        <div class="content-item">
                            <h3>Attendance</h3>
                            <p>Employees are expected to be punctual and present during their scheduled work hours.
                                Absences must be reported to [supervisor/HR] as soon as possible.
                            </p>
                        </div>
                        <div class="content-item">
                            <h3>Leave Policies</h3>
                            <p>Employees are entitled to various types of leave, including sick leave, vacation leave,
                                and personal leave. Requests for leave must be submitted in advance and approved by
                                [supervisor/HR].
                            </p>
                        </div>
                    </div>
                    <div class="content-image">
                        <img src="work.jpg" alt="Compensation Benefits Image">
                    </div>
                </div>
            </div>
            <div class="content-area" data-category="Code Of Conduct">
                <a href="path/to/compensation-document.pdf" class="download-btn" download>
                    <img src="../resource/image/hrpolicy/hr_img/download 1 (2).png" alt="Download Icon"> Download
                </a>

                <div class="policy-content">
                    <div class="content-text">
                        <div class="content-item">
                            <h3>Professional Behavior</h3>
                            <p>Employees are expected to conduct themselves in a professional manner that reflects the
                                values and standards of [SIL Technologies]. </p>
                        </div>
                        <div class="content-item">
                            <h3>Harassment and Discrimination</h3>
                            <p> [SIL Technologies] has a zero-tolerance policy for harassment or discrimination. Any
                                incidents should be reported to HR immediately for investigation.
                            </p>
                        </div>
                        <div class="content-item">
                            <h3>Confidentiality</h3>
                            <p> Employees must maintain the confidentiality of sensitive company information and not
                                disclose it to unauthorized individuals.
                            </p>
                        </div>
                    </div>
                    <div class="content-image">
                        <img src="thumb.jpg" alt="Compensation Benefits Image">
                    </div>
                </div>
            </div>
            <!-- Add more content areas as needed -->
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryItems = document.querySelectorAll('.category-item');
            const contentAreas = document.querySelectorAll('.content-area');
            const searchInput = document.getElementById('searchInput');

            // Function to reset all content areas
            const resetContentAreas = () => {
                contentAreas.forEach(area => {
                    area.style.display = 'none'; // Hide all content areas
                    area.classList.remove('active'); // Remove active class
                });
            };

            // Function to show content frames for the selected category
            const showCategoryContent = (categoryId) => {
                contentAreas.forEach(area => {
                    if (area.getAttribute('data-category') === categoryId) {
                        area.style.display = 'block'; // Show the content area
                        area.classList.add('active'); // Mark it as active
                    }
                });
            };

            // Event listener for category selection
            categoryItems.forEach(item => {
                item.addEventListener('click', function () {
                    const categoryId = item.getAttribute('data-category');

                    // Remove 'active' class from all categories
                    categoryItems.forEach(it => it.classList.remove('active'));
                    // Add 'active' class to the selected category
                    item.classList.add('active');

                    // Reset all content areas
                    resetContentAreas();

                    // Show content for the selected category
                    showCategoryContent(categoryId);

                    // Clear the search bar and reset its state
                    searchInput.value = "";
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function () {
                const query = searchInput.value.toLowerCase().trim();

                if (query === "") {
                    // Restore initial state when search input is cleared
                    resetContentAreas();

                    // Activate the first category and its content area by default
                    if (categoryItems.length > 0) {
                        const firstCategory = categoryItems[0];
                        const firstCategoryId = firstCategory.getAttribute('data-category');
                        firstCategory.classList.add('active'); // Mark the first category as active
                        showCategoryContent(firstCategoryId);
                    }
                } else {
                    // Filter content frames based on the search query
                    resetContentAreas();
                    contentAreas.forEach(area => {
                        const titles = area.querySelectorAll('.content-item h3');
                        let matchFound = false;

                        titles.forEach(title => {
                            const titleText = title.textContent.toLowerCase();
                            if (titleText.includes(query)) {
                                matchFound = true;
                            }
                        });

                        // Show content areas with matching titles
                        if (matchFound) {
                            area.style.display = 'block';
                        }
                    });

                    // Remove 'active' class from all categories
                    categoryItems.forEach(item => item.classList.remove('active'));
                }
            });
        });

    </script>
    @endsection
</body>

</html>
