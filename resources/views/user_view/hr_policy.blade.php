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
        <!-- New Sidebar based on FingoldZ-FE design -->
        <div class="sidebar_main" id="sidebarMain">
            <div class="sidebar_internal">
                <!-- Top Section with Search Bar and Toggle -->
                <div class="sidebar_top">
                    <div class="sidebar_top_left">
                        <div class="Logo_main sidebar-search" id="logoMain">
                            <div class="search-bar">
                                <input type="text" placeholder="Search Category..." id="searchInput">
                            </div>
                        </div>
                    </div>
                    <div class="sidebar_top_right">
                        <div class="top_button_container">
                            <button type="button" class="top_button" id="collapseButton" onclick="toggleSidebar()">
                                <i class="fas fa-chevron-right" id="collapseIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Bottom with Categories -->
                <div class="sidebar_bottom">
                    <div class="button-list" id="buttonList">
                        @foreach($policies->groupBy('policy_categorie_id') as $categoryId => $categoryPolicies)
                            <div class="dropdown-section">
                                <button class="sidebar-button dropdown-toggle" 
                                        onclick="toggleCategoryDropdown({{ $categoryId }}, event)"
                                        data-category="{{ $categoryId }}">
                                    <div class="sidebar-icon">
                                        <img src="{{ Storage::url($categoryPolicies->first()->iconLink) }}" alt="{{ $categoryPolicies->first()->category_name }}">
                                    </div>
                                    <span class="sidebar-button-text">{{ $categoryPolicies->first()->category_name }}</span>
                                </button>
                                <div class="dropdown-options" id="dropdown-{{ $categoryId }}" style="display: none;">
                                    @foreach($categoryPolicies as $policy)
                                        <div class="dropdown-option" 
                                             data-policy-id="{{ $policy->id }}" 
                                             data-category-id="{{ $categoryId }}"
                                             onclick="selectPolicy({{ $policy->id }}, {{ $categoryId }}, event)">
                                            {{ $policy->policy_title }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                                       <h2 class="policy-title">{{ $policy->policy_title }}</h2>
                                       <a href="{{ Storage::url($policy->docLink) }}" class="download-btn" download>
                                           <img src="{{ asset('user_end/images/download 1.png') }}" alt="Download Icon"> Download
                                       </a>
                                   </div>
                                   <div class="folder-content">
                                       <div class="content-text">
                                           <p>{{ $policy->policy_content }}</p>
                                       </div>
                                       <div class="content-image">
                                           <img src="{{ asset('user_end/images/polocies-compliance-operation-method-system.jpg') }}" alt="Policy Image">
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
        // Sidebar collapse/expand functionality
        let sidebarCollapsed = false;

        function toggleSidebar() {
            sidebarCollapsed = !sidebarCollapsed;
            const sidebarMain = document.getElementById('sidebarMain');
            const sidebarTop = document.querySelector('.sidebar_top');
            const logoMain = document.getElementById('logoMain');
            const searchBar = document.querySelector('.search-bar');
            const searchInput = document.getElementById('searchInput');
            const collapseIcon = document.getElementById('collapseIcon');
            const buttonList = document.getElementById('buttonList');
            const sidebarButtons = document.querySelectorAll('.sidebar-button');
            const buttonTexts = document.querySelectorAll('.sidebar-button-text');
            const dropdownOptions = document.querySelectorAll('.dropdown-options');
            const sidebarTopLeft = document.querySelector('.sidebar_top_left');
            const sidebarTopRight = document.querySelector('.sidebar_top_right');
            const topButtonContainer = document.querySelector('.top_button_container');
            const sidebarBottom = document.querySelector('.sidebar_bottom');

            if (sidebarCollapsed) {
                // Collapse sidebar to 75px width
                sidebarMain.style.width = '75px';
                sidebarMain.style.minWidth = '75px';
                
                // Hide search bar and logo completely
                if (logoMain) {
                    logoMain.style.display = 'none';
                }
                if (searchBar) {
                    searchBar.style.display = 'none';
                }
                if (searchInput) {
                    searchInput.style.display = 'none';
                }
                if (sidebarTopLeft) {
                    sidebarTopLeft.style.display = 'none';
                }
                
                // Adjust sidebar top to center button only
                if (sidebarTop) {
                    sidebarTop.style.justifyContent = 'center';
                    sidebarTop.style.alignItems = 'center';
                    sidebarTop.style.padding = '10px 0';
                }
                
                // Center the collapse button
                if (sidebarTopRight) {
                    sidebarTopRight.style.width = '100%';
                    sidebarTopRight.style.display = 'flex';
                    sidebarTopRight.style.justifyContent = 'center';
                    sidebarTopRight.style.alignItems = 'center';
                    sidebarTopRight.style.borderRadius = '30px 30px 0 0';
                }
                if (topButtonContainer) {
                    topButtonContainer.style.padding = '10px';
                    topButtonContainer.style.margin = '0 auto';
                }
                
                // Rotate collapse icon
                collapseIcon.style.transform = 'rotate(180deg)';
                
                // Adjust sidebar bottom for icons only
                if (sidebarBottom) {
                    sidebarBottom.style.paddingTop = '5px';
                }
                
                // Adjust button list for icons only
                if (buttonList) {
                    buttonList.style.borderRadius = '0px 0px 25px 25px';
                    buttonList.style.paddingTop = '5px';
                    buttonList.style.gap = '8px';
                }
                
                // Show only icons, hide text - properly centered
                sidebarButtons.forEach(btn => {
                    btn.style.width = '60px';
                    btn.style.height = '60px';
                    btn.style.justifyContent = 'center';
                    btn.style.alignItems = 'center';
                    btn.style.padding = '0';
                    btn.style.margin = '0 auto';
                });
                
                // Hide icon backgrounds when collapsed, show just icons
                document.querySelectorAll('.sidebar-icon').forEach(icon => {
                    icon.style.margin = '0';
                    icon.style.width = '50px';
                    icon.style.height = '50px';
                });
                
                buttonTexts.forEach(text => {
                    text.style.display = 'none';
                });
                
                // Hide all dropdowns
                dropdownOptions.forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            } else {
                // Expand sidebar back
                sidebarMain.style.width = '22%';
                sidebarMain.style.minWidth = 'auto';
                
                // Restore sidebar top layout
                if (sidebarTop) {
                    sidebarTop.style.justifyContent = 'space-between';
                    sidebarTop.style.alignItems = 'flex-start';
                    sidebarTop.style.padding = '0';
                }
                
                // Show search bar and logo
                if (logoMain) {
                    logoMain.style.display = 'flex';
                    logoMain.style.width = '75%';
                    logoMain.style.height = '70px';
                    logoMain.style.marginLeft = '10px';
                    logoMain.style.marginRight = '10px';
                }
                if (searchBar) {
                    searchBar.style.display = 'flex';
                }
                if (searchInput) {
                    searchInput.style.display = 'block';
                }
                if (sidebarTopLeft) {
                    sidebarTopLeft.style.display = 'block';
                }
                
                // Restore top right layout
                if (sidebarTopRight) {
                    sidebarTopRight.style.width = '30%';
                    sidebarTopRight.style.justifyContent = 'flex-end';
                    sidebarTopRight.style.borderRadius = '45px 45px 45px 0';
                }
                if (topButtonContainer) {
                    topButtonContainer.style.padding = '20px';
                    topButtonContainer.style.margin = '0';
                }
                
                // Rotate collapse icon back
                collapseIcon.style.transform = 'rotate(0deg)';
                
                // Restore sidebar bottom
                if (sidebarBottom) {
                    sidebarBottom.style.paddingTop = '0';
                }
                
                // Restore button list
                if (buttonList) {
                    buttonList.style.borderRadius = '0px 25px 25px 25px';
                    buttonList.style.paddingTop = '10px';
                    buttonList.style.gap = '6px';
                }
                
                // Show text with icons - restore full layout
                sidebarButtons.forEach(btn => {
                    btn.style.width = '98%';
                    btn.style.height = 'auto';
                    btn.style.justifyContent = 'flex-start';
                    btn.style.alignItems = 'center';
                    btn.style.padding = '10px 15px';
                    btn.style.margin = '0';
                });
                
                // Restore icon sizes
                document.querySelectorAll('.sidebar-icon').forEach(icon => {
                    icon.style.width = '50px';
                    icon.style.height = '50px';
                    icon.style.margin = '0';
                });
                
                buttonTexts.forEach(text => {
                    text.style.display = 'inline';
                });
            }
        }

        // Category dropdown toggle
        function toggleCategoryDropdown(categoryId, event) {
            if (sidebarCollapsed) return;

            const dropdown = document.getElementById(`dropdown-${categoryId}`);
            const allDropdowns = document.querySelectorAll('.dropdown-options');
            const allButtons = document.querySelectorAll('.sidebar-button');

            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd.id !== `dropdown-${categoryId}`) {
                    dd.style.display = 'none';
                }
            });

            // Remove active class from all buttons
            allButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Remove active class from all dropdown options
            const allOptions = document.querySelectorAll('.dropdown-option');
            allOptions.forEach(opt => opt.classList.remove('active'));

            // Toggle current dropdown
            const button = event.target.closest('.sidebar-button');
            if (dropdown.style.display === 'none' || !dropdown.style.display) {
                dropdown.style.display = 'flex';
                button.classList.add('active');
                
                // Show category content (which will hide all cards by default)
                showCategoryContent(categoryId);
                
                // Show first sub-policy by default (without scrolling on initial load)
                const firstOption = dropdown.querySelector('.dropdown-option');
                if (firstOption) {
                    const firstPolicyId = firstOption.getAttribute('data-policy-id');
                    firstOption.classList.add('active');
                    showPolicyCard(firstPolicyId, categoryId, false); // Don't scroll on initial load
                }
            } else {
                dropdown.style.display = 'none';
                button.classList.remove('active');
            }
        }

        // Select policy and show it
        function selectPolicy(policyId, categoryId, event) {
            // Update active state
            const allOptions = document.querySelectorAll('.dropdown-option');
            allOptions.forEach(opt => opt.classList.remove('active'));
            event.target.classList.add('active');

            // Show the policy card with scrolling (user clicked)
            showPolicyCard(policyId, categoryId, true);
        }

        // Show content for selected category
        function showCategoryContent(categoryId) {
            const contentAreas = document.querySelectorAll('.content-area');
            contentAreas.forEach(area => {
                if (area.getAttribute('data-category') === String(categoryId)) {
                    area.style.display = 'block';
                    area.classList.add('active');
                    // Hide all policy cards by default - they will be shown when clicking dropdown options
                    const cards = area.querySelectorAll('.policy-card');
                    cards.forEach(card => {
                        card.classList.add('policy-card-hidden');
                    });
                } else {
                    area.style.display = 'none';
                    area.classList.remove('active');
                }
            });
        }

        // Show specific policy card
        function showPolicyCard(policyId, categoryId, shouldScroll = true) {
            const activeArea = document.querySelector(`.content-area[data-category="${categoryId}"]`);
            if (!activeArea) return;

            const cards = activeArea.querySelectorAll('.policy-card');
            cards.forEach(card => {
                const isMatch = card.getAttribute('data-policy-id') === String(policyId);

                if (isMatch) {
                    card.classList.remove('policy-card-hidden');
                    // Scroll to card accounting for header height to prevent navbar clipping
                    // Only scroll if shouldScroll is true (i.e., user clicked, not initial load)
                    if (shouldScroll) {
                        setTimeout(() => {
                            const header = document.querySelector('header');
                            const headerHeight = header ? header.offsetHeight + 20 : 100; // Add 20px padding
                            const cardRect = card.getBoundingClientRect();
                            const cardTop = cardRect.top + window.pageYOffset;
                            
                            // Only scroll if card is not already visible below header
                            const viewportTop = window.pageYOffset;
                            if (cardTop < viewportTop + headerHeight || cardRect.top < headerHeight) {
                                window.scrollTo({
                                    top: Math.max(0, cardTop - headerHeight),
                                    behavior: 'smooth'
                                });
                            }
                        }, 100); // Small delay to ensure layout is stable
                    }
                } else {
                    card.classList.add('policy-card-hidden');
                }
            });
        }

        // Search functionality - only highlights, doesn't open dropdowns
        function performSearch() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;
            
            const term = (searchInput.value || '').trim().toLowerCase();
            const sidebarButtons = document.querySelectorAll('.sidebar-button');
            const dropdownOptions = document.querySelectorAll('.dropdown-option');

            // Remove highlight classes only
            sidebarButtons.forEach(btn => btn.classList.remove('highlight'));
            dropdownOptions.forEach(opt => opt.classList.remove('highlight'));

            if (!term) {
                // Reset - remove all highlights
                return;
            }

            // Search in category names and highlight matching categories
            sidebarButtons.forEach(button => {
                const categoryNameEl = button.querySelector('.sidebar-button-text');
                if (categoryNameEl) {
                    const categoryName = categoryNameEl.textContent.toLowerCase().trim();
                    if (categoryName.includes(term)) {
                        button.classList.add('highlight');
                    }
                }
            });

            // Search in policy titles and highlight matching policies
            // Only highlight policies within already-open dropdowns, don't auto-expand
            dropdownOptions.forEach(option => {
                const policyTitle = (option.textContent || '').toLowerCase().trim();
                const parentDropdown = option.closest('.dropdown-options');
                
                // Check if dropdown is visible
                let isDropdownVisible = false;
                if (parentDropdown) {
                    // Check inline style first
                    const inlineDisplay = parentDropdown.style.display;
                    if (inlineDisplay === 'flex' || inlineDisplay === 'block') {
                        isDropdownVisible = true;
                    } else if (!inlineDisplay || inlineDisplay === '') {
                        // If no inline style, check computed style
                        const computedDisplay = window.getComputedStyle(parentDropdown).display;
                        isDropdownVisible = computedDisplay !== 'none';
                    }
                }
                
                if (policyTitle.includes(term) && isDropdownVisible) {
                    option.classList.add('highlight');
                }
            });
        }

        // Initialize on page load
        document.addEventListener("DOMContentLoaded", function () {
            // Ensure page starts at top to prevent navbar clipping
            window.scrollTo(0, 0);
            
            const contentAreas = document.querySelectorAll('.content-area');
            const policiesByCategory = @json($policiesByCategory);
            const searchInput = document.getElementById('searchInput');

            // Add search event listeners
            if (searchInput) {
                // Real-time search as user types
                searchInput.addEventListener('input', function(e) {
                    performSearch();
                });
                
                // Also trigger on keyup for better responsiveness
                searchInput.addEventListener('keyup', function(e) {
                    performSearch();
                });
            } else {
                console.error('Search input not found!');
            }


            // Activate the first category by default
            const firstCategoryButton = document.querySelector('.sidebar-button');
            if (firstCategoryButton) {
                const firstCategoryId = firstCategoryButton.getAttribute('data-category');
                firstCategoryButton.classList.add('active');
                const firstDropdown = document.getElementById(`dropdown-${firstCategoryId}`);
                if (firstDropdown) {
                    firstDropdown.style.display = 'flex';
                }
                showCategoryContent(firstCategoryId);
                
                // Show first policy (without scrolling on initial page load)
                const firstPolicy = firstDropdown?.querySelector('.dropdown-option');
                if (firstPolicy) {
                    const firstPolicyId = firstPolicy.getAttribute('data-policy-id');
                    showPolicyCard(firstPolicyId, firstCategoryId, false); // Don't scroll on initial load
                }
            }
        });
    </script>
    <style>
        /* Optional: keep highlight style for search functionality */
        .sidebar-button.highlight {
            background-color: #E0AFA0 !important;
            font-weight: bold !important;
        }
        
        .dropdown-option.highlight {
            background-color: #E0AFA0 !important;
            font-weight: bold !important;
        }
        
        /* Make top_button (sidebar collapse button) circular */
        .top_button {
            border-radius: 50% !important; /* Perfect circle */
        }
    </style>


    @endsection
