@extends('user_view.header')
@section('content')
<?php 
error_reporting(0);

// dd($policies);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- {{-- <title>Human Resource Policy</title> --}} -->
    <link rel="stylesheet" href="{{ asset('/user_end/css/hr_policy.css') }}">
    <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    
    <!-- Header Section -->
    <div class="header mx-4">
        <!-- <h2>Human Resource Policy</h2> -->
        <div class="search-bar">
            <input type="text" placeholder="Search Category..." id="searchInput">
            <div class="search-icon-circle">
                <img src="{{ asset('user_end/images/search (2) 3.png') }}" alt="Search Icon">
            </div>
        </div>
        <div class="categories-container">
            @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
                <div class="category-item" data-category="{{ $categoryId }}">
                    <div class="category-icon">
                        <!-- Fetch icon from storage -->
                        <img src="{{ Storage::url($categoryPolicies->first()->iconLink) }}" alt="Category Icon">
                    </div>
                    <div class="category-text">
                        <span class="">{{ $categoryPolicies->first()->category_name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Main Content Container -->

    <div class="main-container mx-">
        <!-- Content Area -->
        @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
            <div class="content-area  my-2" data-category="{{ $categoryId }}">
                <div class="policy-slider">
                    <div class="policy-track">
                        @foreach($categoryPolicies as $policy)
                            <div class="policy-card">
                                <a href="{{ Storage::url($policy->docLink) }}" class="download-btn" download>
                                <img src="{{ asset('user_end/images/download 1.png') }}" alt="Download Icon"> Download
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
                            </div>
                        @endforeach
                    </div>
                    <div class="slider-nav">
                        <button class="prev" aria-label="Previous">&#10094;</button>
                        <button class="next" aria-label="Next">&#10095;</button>
                    </div>
                </div>
            </div>
        @endforeach
         
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryItems = document.querySelectorAll('.category-item');
            const contentAreas = document.querySelectorAll('.content-area');

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
                });
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliders = document.querySelectorAll('.policy-slider');

        sliders.forEach((slider) => {
            const track = slider.querySelector('.policy-track');
            const slides = slider.querySelectorAll('.policy-card');
            const prevBtn = slider.querySelector('.slider-nav .prev');
            const nextBtn = slider.querySelector('.slider-nav .next');
            let index = 0;

            const update = () => {
                const offset = -index * 100;
                track.style.transform = `translateX(${offset}%)`;
                if (prevBtn) prevBtn.disabled = index <= 0;
                if (nextBtn) nextBtn.disabled = index >= slides.length - 1;
            };

            if (prevBtn) prevBtn.addEventListener('click', () => {
                if (index > 0) { index--; update(); }
            });
            if (nextBtn) nextBtn.addEventListener('click', () => {
                if (index < slides.length - 1) { index++; update(); }
            });

            // Touch swipe support
            let startX = 0;
            let isSwiping = false;
            const threshold = 40; // px

            track.addEventListener('touchstart', (e) => {
                if (!e.touches || e.touches.length === 0) return;
                startX = e.touches[0].clientX;
                isSwiping = true;
            }, { passive: true });

            track.addEventListener('touchmove', (e) => {
                // prevent vertical scroll only if horizontal intent is clear
            }, { passive: true });

            track.addEventListener('touchend', (e) => {
                if (!isSwiping) return;
                const endX = e.changedTouches && e.changedTouches[0] ? e.changedTouches[0].clientX : startX;
                const deltaX = endX - startX;
                if (Math.abs(deltaX) > threshold) {
                    if (deltaX < 0 && index < slides.length - 1) {
                        index++;
                    } else if (deltaX > 0 && index > 0) {
                        index--;
                    }
                    update();
                }
                isSwiping = false;
            });

            update();
        });
    });
</script>


<script>
    // Get references to the search input and category items
    const searchInput = document.getElementById('searchInput');
    const categoryItems = document.querySelectorAll('.category-item');

    // Event listener for input changes
    searchInput.addEventListener('input', function() {
        // Get the search term and convert to lowercase for case-insensitive matching
        const searchTerm = searchInput.value.toLowerCase();

        // Loop through each category item
        categoryItems.forEach(function(item) {
            // Check if the category item contains the search term
            if (item.textContent.toLowerCase().includes(searchTerm)) {
                // Highlight the item by adding a 'highlight' class (you can define the style for this class)
                item.classList.add('highlight');
            } else {
                // Remove the highlight if the item doesn't match
                item.classList.remove('highlight');
            }
        });
    });
</script>
<style>
    /* Define the highlight class for styling */
    .highlight {
        background-color: #E0AFA0;  /* You can customize this style */
        font-weight: bold;         /* Add other styles for highlighting */
    }
</style>


    @endsection
