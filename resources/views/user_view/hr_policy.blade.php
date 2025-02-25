@extends('user_view.header')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Human Resource Policy</title>
    <link rel="stylesheet" href="{{ asset('/user_end/css/hr_policy.css') }}">
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
