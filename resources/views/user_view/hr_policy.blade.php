@extends('user_view.header')
@section('content')
<?php 
error_reporting(0);
?>
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
                <img src="{{ asset('resource/image/hrpolicy/hr_img/search (2) 2.png') }}" alt="Search Icon">
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container">
        <div class="main-container">
            <!-- Sidebar -->
            <div class="sidebar">
                @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
                    <div class="category-item" data-category="{{ $categoryId }}">
                        <div class="category-icon">
                            <!-- Fetch icon from storage -->
                            <img src="{{ Storage::url($categoryPolicies->first()->iconLink) }}" alt="Category Icon">
                        </div>
                        <div class="category-text">
                            <span>{{ $categoryPolicies->first()->category_name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Content Area -->
            @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
                <div class="content-area" data-category="{{ $categoryId }}">
                    @foreach($categoryPolicies as $policy)
                        <a href="{{ Storage::url($policy->docLink) }}" class="download-btn" download>
                            <img src="{{ asset('resource/image/hrpolicy/hr_img/download 1 (2).png') }}" alt="Download Icon"> Download
                        </a>

                        <div class="policy-content">
                            <div class="content-text">
                                <div class="content-item">
                                    <h3>{{ $policy->policy_title }}</h3>
                                    <p>{{ $policy->policy_content }}</p>
                                </div>
                            </div>
                            <div class="content-image">
                                <!-- Fetch content image from storage -->
                                <img src="{{ Storage::url($policy->imgLink) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
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

            // Activate the first category and its content area by default
            if (categoryItems.length > 0) {
                const firstCategory = categoryItems[0];
                const firstCategoryId = firstCategory.getAttribute('data-category');
                firstCategory.classList.add('active'); // Mark the first category as active
                showCategoryContent(firstCategoryId);
            }
        });
    </script>
    @endsection
</body>

</html>
