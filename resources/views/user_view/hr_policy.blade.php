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
    <!-- Main Content Container -->
    <div class="main-container mx-">
        <!-- Sidebar with Categories -->
        <div class="sidebar">
            <!-- Search Bar at Top -->
            <div class="sidebar-search">
                <div class="search-bar">
                    <input type="text" placeholder="Search Category..." id="searchInput">
                    <div class="search-icon-circle">
                        <img src="{{ asset('user_end/images/search (2) 3.png') }}" alt="Search Icon">
                    </div>
                </div>
            </div>
            <!-- Scrollable Categories Container -->
            <div class="categories-scroll-container">
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
        </div>
        <!-- Content Area -->
        @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
           <div class="content-area my-2" data-category="{{ $categoryId }}">
               <div class="policy-slider">
                   <div class="policy-track">
                       @foreach($categoryPolicies as $policy)
                           <div class="policy-card" data-policy-id="{{ $policy->id }}" data-category-id="{{ $categoryId }}">
                               <div class="policy-folder">
                                   <div class="folder-header">
                                       <div class="subpolicy-dropdown">
                                           <button class="dropdown-toggle" type="button" data-category="{{ $categoryId }}">
                                               <span class="dropdown-text">{{ $policy->policy_title }}</span>
                                               <i class="fas fa-chevron-down dropdown-icon"></i>
                                           </button>
                                           <div class="dropdown-menu" data-category="{{ $categoryId }}">
                                               @foreach($categoryPolicies as $subPolicy)
                                                   <div class="dropdown-item" data-policy-id="{{ $subPolicy->id }}" data-category-id="{{ $categoryId }}">
                                                       {{ $subPolicy->policy_title }}
                                                   </div>
                                               @endforeach
                                           </div>
                                       </div>
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
                    // Set default dropdown selection
                    setDefaultDropdownSelection(firstCategoryId);
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
                    setDefaultDropdownSelection(catId);
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

            // Dropdown functionality
            const setDefaultDropdownSelection = (categoryId) => {
                const activeArea = document.querySelector(`.content-area[data-category="${categoryId}"]`);
                if (!activeArea) return;
                
                const firstCard = activeArea.querySelector('.policy-card');
                if (firstCard) {
                    // Show only the first policy card
                    showPolicyCard(firstCard.getAttribute('data-policy-id'));
                }
            };

            const showPolicyCard = (policyId) => {
                const activeArea = document.querySelector('.content-area.active');
                if (!activeArea) return;

                const cards = activeArea.querySelectorAll('.policy-card');
                cards.forEach(card => {
                    const isMatch = card.getAttribute('data-policy-id') === String(policyId);

                    if (isMatch) {
                        card.classList.remove('policy-card-hidden');
                        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        card.classList.add('policy-card-hidden');
                        // Close any open dropdowns in hidden cards
                        const hiddenDropdowns = card.querySelectorAll('.dropdown-menu');
                        hiddenDropdowns.forEach(dropdown => {
                            dropdown.classList.remove('show');
                        });
                        const hiddenToggles = card.querySelectorAll('.dropdown-toggle');
                        hiddenToggles.forEach(toggle => {
                            toggle.classList.remove('active');
                        });
                    }
                });
            };

            // Initialize dropdown functionality
            const initializeDropdowns = () => {
                // Remove existing event listeners to prevent duplicates
                document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                    toggle.replaceWith(toggle.cloneNode(true));
                });
                
                document.querySelectorAll('.dropdown-item').forEach(item => {
                    item.replaceWith(item.cloneNode(true));
                });

                const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
                
                dropdownToggles.forEach(toggle => {
                    toggle.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const categoryId = toggle.getAttribute('data-category');
                        
                        // Only work with visible dropdowns (not hidden policy cards)
                        if (toggle.closest('.policy-card-hidden')) {
                            return;
                        }
                        
                        const dropdownMenu = toggle.nextElementSibling;
                        
                        // Close all other dropdowns in the same category
                        document.querySelectorAll(`.dropdown-menu[data-category="${categoryId}"]`).forEach(menu => {
                            if (menu !== dropdownMenu) {
                                menu.classList.remove('show');
                            }
                        });
                        
                        document.querySelectorAll(`.dropdown-toggle[data-category="${categoryId}"]`).forEach(t => {
                            if (t !== toggle) {
                                t.classList.remove('active');
                            }
                        });
                        
                        // Toggle current dropdown
                        dropdownMenu.classList.toggle('show');
                        toggle.classList.toggle('active');
                    });
                });

                // Handle dropdown item selection
                const dropdownItems = document.querySelectorAll('.dropdown-item');
                dropdownItems.forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const categoryId = item.getAttribute('data-category-id');
                        const policyId = item.getAttribute('data-policy-id');
                        
                        // Find all dropdowns for this category
                        const categoryDropdowns = document.querySelectorAll(`.dropdown-menu[data-category="${categoryId}"]`);
                        const categoryToggles = document.querySelectorAll(`.dropdown-toggle[data-category="${categoryId}"]`);
                        
                        // Update all dropdowns in this category
                        categoryDropdowns.forEach(dropdownMenu => {
                            dropdownMenu.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
                            item.classList.add('active');
                            
                            // Close dropdown
                            dropdownMenu.classList.remove('show');
                        });
                        
                        categoryToggles.forEach(dropdownToggle => {
                            const dropdownText = dropdownToggle.querySelector('.dropdown-text');
                            dropdownText.textContent = item.textContent;
                            dropdownToggle.classList.remove('active');
                        });
                        
                        // Show selected policy
                        showPolicyCard(policyId);
                        
                        // Re-initialize dropdowns after showing new policy
                        setTimeout(() => {
                            initializeDropdowns();
                        }, 100);
                    });
                });
            };

            // Close dropdowns when clicking outside
            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
                document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                    toggle.classList.remove('active');
                });
            });

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

                    setDefaultDropdownSelection(categoryId);
                });
            });

            // Initialize dropdowns
            initializeDropdowns();

            // Activate the first category and its content area by default
            if (categoryItems.length > 0) {
                const firstCategory = categoryItems[0];
                const firstCategoryId = firstCategory.getAttribute('data-category');
                firstCategory.classList.add('active'); // Mark the first category as active
                showCategoryContent(firstCategoryId);
                setDefaultDropdownSelection(firstCategoryId);
            }
        });
    </script>
    <style>
        /* Optional: keep highlight style for search functionality */
        .highlight {
            background-color: #E0AFA0;
            font-weight: bold;
        }
    </style>


    @endsection
