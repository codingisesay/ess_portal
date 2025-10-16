@extends('user_view.header')
@section('content')
<?php
error_reporting(0);
?>

@php
    $policyCollection = collect($policies ?? []);
    $policiesByCategory = $policyCollection->groupBy('policy_categorie_id')->map(function ($items) {
        return $items->map(function ($policy) {
            return [
                'id' => $policy->id,
                'title' => $policy->policy_title,
                'category_id' => $policy->policy_categorie_id,
            ];
        })->values();
    });
@endphp

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Human Resource Policy</title>
     <link rel="stylesheet" href="{{ asset('/user_end/css/hr_policy.css') }}">
     <link rel="stylesheet" href="{{ asset('/user_end/css/homepage.css') }}">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 </head>
 <body>
     <!-- Header Section -->
     <!-- <div class="header mx-4"> -->
         <div class="header-content">
             <div class="search-bar">
                 <input type="text" placeholder="Search Category..." id="searchInput">
                 <div class="search-icon-circle">
                     <img src="{{ asset('user_end/images/search (2) 3.png') }}" alt="Search Icon">
                 </div>
             </div>

             <div class="subpolicies-container" id="subpoliciesContainer" hidden>
                 <div class="subpolicies-scroll" id="subpoliciesScroll"></div>
             </div>
         </div>
     <!-- </div> -->

     <!-- Main Content Container -->
     <div class="main-container mx-">
         <!-- Sidebar with Categories -->
         <div class="sidebar">
             <div class="categories-container">
                 @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
                     <div class="category-item" data-category="{{ $categoryId }}">
                         <div class="category-icon">
                             <img src="{{ Storage::url($categoryPolicies->first()->iconLink) }}" alt="Category Icon">
                         </div>
                         <div class="category-text">
                             <span class="">{{ $categoryPolicies->first()->category_name }}</span>
                         </div>
                     </div>
                 @endforeach
             </div>
         </div>
         <!-- Content Area -->
         @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
            <div class="content-area  my-2" data-category="{{ $categoryId }}">
                <div class="policy-slider">
                    <div class="policy-track">
                        @foreach($categoryPolicies as $policy)
                            <div class="policy-card" data-policy-id="{{ $policy->id }}" data-category-id="{{ $categoryId }}">
                                <div class="policy-folder">
                                    <div class="folder-header">
                                        <h5 class="folder-title">{{ $policy->policy_title }}</h5>
                                        <a href="{{ Storage::url($policy->docLink) }}" class="download-btn" download>
                                            <img src="{{ asset('user_end/images/download 1.png') }}" alt="Download Icon"> Download
                                        </a>
                                    </div>
                                    <div class="folder-content">
                                        <div class="content-text">
                                            <p>{{ $policy->policy_content }}</p>
                                        </div>
                                        <div class="content-image">
                                            <img src="{{ Storage::url($policy->imgLink) }}" alt="Policy Image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
         
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categoryItems = document.querySelectorAll('.category-item');
            const contentAreas = document.querySelectorAll('.content-area');
            const subpoliciesContainer = document.getElementById('subpoliciesContainer');
            const subpoliciesScroll = document.getElementById('subpoliciesScroll');
            const policiesByCategory = @json($policiesByCategory);

            // Search elements
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.querySelector('.search-icon-circle');

            // Reset to default (first category active, others hidden)
            const resetToDefault = () => {
                categoryItems.forEach(it => it.classList.remove('highlight', 'active'));
                contentAreas.forEach(area => { area.style.display = 'none'; area.classList.remove('active'); });
                if (categoryItems.length > 0) {
                    const firstCategory = categoryItems[0];
                    const firstCategoryId = firstCategory.getAttribute('data-category');
                    firstCategory.classList.add('active');
                    contentAreas.forEach(area => {
                        if (area.getAttribute('data-category') === firstCategoryId) {
                            area.style.display = 'block';
                            area.classList.add('active');
                        }
                    });
                    // Render subpolicies for default category
                    if (typeof renderSubpolicies === 'function') {
                        renderSubpolicies(firstCategoryId);
                    }
                }
            };

            // Perform search across category names and policy text
            const performSearch = () => {
                const term = (searchInput?.value || '').trim().toLowerCase();
                if (!term) {
                    resetToDefault();
                    return;
                }

                let firstMatch = null;

                // Match on category labels
                categoryItems.forEach(item => {
                    const matches = item.textContent.toLowerCase().includes(term);
                    if (matches) {
                        item.classList.add('highlight');
                        if (!firstMatch) firstMatch = item;
                    } else {
                        item.classList.remove('highlight');
                    }
                });

                // Fallback: search inside policy titles/content
                if (!firstMatch) {
                    contentAreas.forEach(area => {
                        if (!firstMatch && area.textContent.toLowerCase().includes(term)) {
                            const catId = area.getAttribute('data-category');
                            const catHeader = Array.from(categoryItems).find(ci => ci.getAttribute('data-category') === catId);
                            if (catHeader) firstMatch = catHeader;
                        }
                    });
                }

                // Activate the matched category
                if (firstMatch) {
                    const catId = firstMatch.getAttribute('data-category');
                    categoryItems.forEach(it => it.classList.remove('active'));
                    firstMatch.classList.add('active');
                    contentAreas.forEach(area => { area.style.display = 'none'; area.classList.remove('active'); });
                    contentAreas.forEach(area => {
                        if (area.getAttribute('data-category') === catId) {
                            area.style.display = 'block';
                            area.classList.add('active');
                        }
                    });
                    if (typeof renderSubpolicies === 'function') {
                        renderSubpolicies(catId);
                    }
                }
            };

            // Bind search interactions
            if (searchBtn) {
                searchBtn.addEventListener('click', performSearch);
            }
            if (searchInput) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        performSearch();
                    }
                });
                // Live highlight of categories while typing
                searchInput.addEventListener('input', function() {
                    const term = (searchInput.value || '').trim().toLowerCase();
                    categoryItems.forEach(function(item) {
                        if (term && item.textContent.toLowerCase().includes(term)) {
                            item.classList.add('highlight');
                        } else {
                            item.classList.remove('highlight');
                        }
                    });
                });
            }

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

            const showPolicyCard = (policyId) => {
                const activeArea = document.querySelector('.content-area.active');
                if (!activeArea) return;

                const cards = activeArea.querySelectorAll('.policy-card');
                cards.forEach(card => {
                    const isMatch = card.getAttribute('data-policy-id') === String(policyId);

                    if (isMatch) {
                        card.classList.remove('policy-card-hidden');
                        // Do not open dropdown: avoid adding 'folder-open' or rotating icons
                        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        card.classList.add('policy-card-hidden');
                    }
                });
            };

            const renderSubpolicies = (categoryId) => {
                if (!subpoliciesContainer || !subpoliciesScroll) {
                    return;
                }

                const items = policiesByCategory[categoryId] || [];
                const targetArea = document.querySelector(`.content-area[data-category="${categoryId}"]`);
                const areaCards = targetArea ? targetArea.querySelectorAll('.policy-card') : [];

                areaCards.forEach(card => {
                    // Reset visibility without opening dropdowns
                    card.classList.remove('policy-card-hidden');
                    card.classList.remove('folder-open');
                });

                if (!items.length) {
                    subpoliciesScroll.innerHTML = '';
                    subpoliciesContainer.setAttribute('hidden', '');
                    return;
                }

                subpoliciesScroll.innerHTML = items.map(item => `
                    <div class="subpolicy-item" data-policy-id="${item.id}" data-category-id="${item.category_id}">
                        <div class="subpolicy-text">${item.title}</div>
                    </div>
                `).join('');

                subpoliciesContainer.removeAttribute('hidden');

                const subpolicyItems = subpoliciesScroll.querySelectorAll('.subpolicy-item');
                subpolicyItems.forEach(subpolicyItem => {
                    subpolicyItem.addEventListener('click', () => {
                        subpolicyItems.forEach(item => item.classList.remove('active'));
                        subpolicyItem.classList.add('active');

                        const policyId = subpolicyItem.getAttribute('data-policy-id');
                        showPolicyCard(policyId);
                    });
                });

                if (subpolicyItems.length > 0) {
                    subpolicyItems[0].click();
                }
            };

            window.renderSubpolicies = renderSubpolicies;

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

                    renderSubpolicies(categoryId);
                });
            });

            // Activate the first category and its content area by default
            if (categoryItems.length > 0) {
                const firstCategory = categoryItems[0];
                const firstCategoryId = firstCategory.getAttribute('data-category');
                firstCategory.classList.add('active'); // Mark the first category as active
                showCategoryContent(firstCategoryId);
                renderSubpolicies(firstCategoryId);
            }
        });
    </script>
    <style>
        /* Hide the folder icon arrow completely */
        .folder-icon { display: none !important; }
        /* Optional: keep highlight style */
        .highlight {
            background-color: #E0AFA0;
            font-weight: bold;
        }
    </style>


    @endsection
