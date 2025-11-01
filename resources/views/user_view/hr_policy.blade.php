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
        // Sidebar collapse/expand functionality
        let sidebarCollapsed = false;

        function toggleSidebar() {
            sidebarCollapsed = !sidebarCollapsed;
            const sidebarMain = document.getElementById('sidebarMain');
            const logoMain = document.getElementById('logoMain');
            const searchBar = document.querySelector('.search-bar');
            const searchInput = document.getElementById('searchInput');
            const collapseIcon = document.getElementById('collapseIcon');
            const buttonList = document.getElementById('buttonList');
            const sidebarButtons = document.querySelectorAll('.sidebar-button');
            const buttonTexts = document.querySelectorAll('.sidebar-button-text');
            const dropdownOptions = document.querySelectorAll('.dropdown-options');

            if (sidebarCollapsed) {
                sidebarMain.style.width = '75px';
                logoMain.style.width = '50px';
                logoMain.style.height = '50px';
                logoMain.style.marginLeft = '15px';
                logoMain.style.marginRight = '15px';
                if (searchBar) {
                    searchBar.style.display = 'none';
                }
                if (searchInput) {
                    searchInput.style.display = 'none';
                }
                collapseIcon.style.transform = 'rotate(180deg)';
                buttonList.style.borderRadius = '0px 0px 25px 25px';
                sidebarButtons.forEach(btn => {
                    btn.style.width = '67%';
                });
                buttonTexts.forEach(text => {
                    text.style.display = 'none';
                });
                dropdownOptions.forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            } else {
                sidebarMain.style.width = '22%';
                logoMain.style.width = '75%';
                logoMain.style.height = '70px';
                logoMain.style.marginLeft = '10px';
                logoMain.style.marginRight = '10px';
                if (searchBar) {
                    searchBar.style.display = 'flex';
                }
                if (searchInput) {
                    searchInput.style.display = 'block';
                }
                collapseIcon.style.transform = 'rotate(0deg)';
                buttonList.style.borderRadius = '0px 25px 25px 25px';
                sidebarButtons.forEach(btn => {
                    btn.style.width = '98%';
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

            // Toggle current dropdown
            const button = event.target.closest('.sidebar-button');
            if (dropdown.style.display === 'none' || !dropdown.style.display) {
                dropdown.style.display = 'flex';
                button.classList.add('active');
                
                // Show category content
                showCategoryContent(categoryId);
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

            // Show the policy card
            showPolicyCard(policyId, categoryId);
        }

        // Show content for selected category
        function showCategoryContent(categoryId) {
            const contentAreas = document.querySelectorAll('.content-area');
            contentAreas.forEach(area => {
                if (area.getAttribute('data-category') === String(categoryId)) {
                    area.style.display = 'block';
                    area.classList.add('active');
                } else {
                    area.style.display = 'none';
                    area.classList.remove('active');
                }
            });
        }

        // Show specific policy card
        function showPolicyCard(policyId, categoryId) {
            const activeArea = document.querySelector(`.content-area[data-category="${categoryId}"]`);
            if (!activeArea) return;

            const cards = activeArea.querySelectorAll('.policy-card');
            cards.forEach(card => {
                const isMatch = card.getAttribute('data-policy-id') === String(policyId);

                if (isMatch) {
                    card.classList.remove('policy-card-hidden');
                    card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    card.classList.add('policy-card-hidden');
                }
            });
        }

        // Search functionality
        function performSearch() {
            const searchInput = document.getElementById('searchInput');
            const term = (searchInput?.value || '').trim().toLowerCase();
            const sidebarButtons = document.querySelectorAll('.sidebar-button');
            const contentAreas = document.querySelectorAll('.content-area');

            // Remove active and highlight classes
            sidebarButtons.forEach(btn => btn.classList.remove('active', 'highlight'));
            contentAreas.forEach(area => {
                area.style.display = 'none';
                area.classList.remove('active');
            });

            if (!term) {
                // Reset to default - show first category
                const firstButton = sidebarButtons[0];
                if (firstButton) {
                    const firstCategoryId = firstButton.getAttribute('data-category');
                    firstButton.classList.add('active');
                    showCategoryContent(firstCategoryId);
                    const firstDropdown = document.getElementById(`dropdown-${firstCategoryId}`);
                    if (firstDropdown) {
                        firstDropdown.style.display = 'flex';
                    }
                }
                return;
            }

            // Search in category names
            let firstMatch = null;
            sidebarButtons.forEach(button => {
                const categoryName = button.querySelector('.sidebar-button-text')?.textContent.toLowerCase() || '';
                if (categoryName.includes(term)) {
                    button.classList.add('highlight');
                    if (!firstMatch) {
                        firstMatch = button;
                    }
                }
            });

            // Also search in policy titles
            if (!firstMatch) {
                const dropdownOptions = document.querySelectorAll('.dropdown-option');
                dropdownOptions.forEach(option => {
                    if (option.textContent.toLowerCase().includes(term)) {
                        const categoryId = option.getAttribute('data-category-id');
                        firstMatch = document.querySelector(`.sidebar-button[data-category="${categoryId}"]`);
                        if (firstMatch) {
                            return;
                        }
                    }
                });
            }

            // Show matched category
            if (firstMatch) {
                const categoryId = firstMatch.getAttribute('data-category');
                firstMatch.classList.add('active');
                showCategoryContent(categoryId);
                const dropdown = document.getElementById(`dropdown-${categoryId}`);
                if (dropdown) {
                    dropdown.style.display = 'flex';
                }
            }
        }

        // Initialize on page load
        document.addEventListener("DOMContentLoaded", function () {
            const contentAreas = document.querySelectorAll('.content-area');
            const policiesByCategory = @json($policiesByCategory);
            const searchInput = document.getElementById('searchInput');

            // Add search event listeners
            if (searchInput) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        performSearch();
                    }
                });

                searchInput.addEventListener('input', function() {
                    const term = (searchInput.value || '').trim().toLowerCase();
                    const sidebarButtons = document.querySelectorAll('.sidebar-button');
                    
                    sidebarButtons.forEach(button => {
                        const categoryName = button.querySelector('.sidebar-button-text')?.textContent.toLowerCase() || '';
                        if (term && categoryName.includes(term)) {
                            button.classList.add('highlight');
                        } else {
                            button.classList.remove('highlight');
                        }
                    });
                });
            }

            // Initialize dropdown functionality for policy cards
            const initializeDropdowns = () => {
                document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                    if (toggle.closest('.policy-card')) {
                        toggle.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const categoryId = toggle.getAttribute('data-category');
                            const dropdownMenu = toggle.nextElementSibling;
                            
                            if (toggle.closest('.policy-card-hidden')) {
                                return;
                            }
                            
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
                            
                            dropdownMenu.classList.toggle('show');
                            toggle.classList.toggle('active');
                        });
                    }
                });

                document.querySelectorAll('.dropdown-item').forEach(item => {
                    if (item.closest('.policy-card')) {
                        item.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const categoryId = item.getAttribute('data-category-id');
                            const policyId = item.getAttribute('data-policy-id');
                            
                            const categoryDropdowns = document.querySelectorAll(`.dropdown-menu[data-category="${categoryId}"]`);
                            const categoryToggles = document.querySelectorAll(`.dropdown-toggle[data-category="${categoryId}"]`);
                            
                            categoryDropdowns.forEach(dropdownMenu => {
                                dropdownMenu.querySelectorAll('.dropdown-item').forEach(i => i.classList.remove('active'));
                                item.classList.add('active');
                                dropdownMenu.classList.remove('show');
                            });
                            
                            categoryToggles.forEach(dropdownToggle => {
                                const dropdownText = dropdownToggle.querySelector('.dropdown-text');
                                dropdownText.textContent = item.textContent;
                                dropdownToggle.classList.remove('active');
                            });
                            
                            showPolicyCard(policyId, categoryId);
                            
                            setTimeout(() => {
                                initializeDropdowns();
                            }, 100);
                        });
                    }
                });
            };

            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.dropdown-toggle') && !e.target.closest('.dropdown-menu')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                        toggle.classList.remove('active');
                    });
                }
            });

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
                
                // Show first policy
                const firstPolicy = firstDropdown?.querySelector('.dropdown-option');
                if (firstPolicy) {
                    const firstPolicyId = firstPolicy.getAttribute('data-policy-id');
                    showPolicyCard(firstPolicyId, firstCategoryId);
                }
            }

            // Initialize policy card dropdowns
            initializeDropdowns();
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
