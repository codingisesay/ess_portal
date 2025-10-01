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
                        card.classList.add('folder-open');

                        const title = card.querySelector('.folder-title');
                        const icon = card.querySelector('.folder-icon');
                        if (title) {
                            title.setAttribute('aria-expanded', 'true');
                        }
                        if (icon) {
                            icon.style.transform = 'rotate(90deg)';
                        }

                        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        card.classList.remove('folder-open');
                        card.classList.add('policy-card-hidden');

                        const otherTitle = card.querySelector('.folder-title');
                        const otherIcon = card.querySelector('.folder-icon');
                        if (otherTitle) {
                            otherTitle.setAttribute('aria-expanded', 'false');
                        }
                        if (otherIcon) {
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
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
                    card.classList.remove('policy-card-hidden');
                    card.classList.remove('folder-open');

                    const title = card.querySelector('.folder-title');
                    const icon = card.querySelector('.folder-icon');
                    if (title) {
                        title.setAttribute('aria-expanded', 'false');
                    }
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)';
                    }
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
    <script>
        // Enhanced folder-like policy interaction
        document.addEventListener('DOMContentLoaded', function() {
            function initPolicyFolders(scope) {
                const cards = (scope || document).querySelectorAll('.policy-card');
                cards.forEach(card => {
                    const title = card.querySelector('.folder-title');
                    const content = card.querySelector('.folder-content');

                    if (!title || !content) return;

                    // Avoid double-binding
                    if (title.dataset.bound === '1') return;
                    title.dataset.bound = '1';

                    // Style as folder header
                    title.style.cursor = 'pointer';
                    title.setAttribute('role', 'button');
                    title.setAttribute('tabindex', '0');
                    title.setAttribute('aria-expanded', 'false');

                    // Add folder icon
                    const folderIcon = document.createElement('span');
                    folderIcon.className = 'folder-icon';
                    folderIcon.innerHTML = '▼';
                    folderIcon.style.marginRight = '0.75rem';
                    folderIcon.style.fontSize = '1.1rem';
                    folderIcon.style.transition = 'transform 0.3s ease';

                    title.insertBefore(folderIcon, title.firstChild);

                    // Click handler for folder toggle
                    const toggleFolder = () => {
                        const isOpen = card.classList.contains('folder-open');
                        const allCards = card.closest('.content-area')?.querySelectorAll('.policy-card') || [];

                        if (isOpen) {
                            // Close folder
                            card.classList.remove('folder-open');
                            title.setAttribute('aria-expanded', 'false');
                            folderIcon.style.transform = 'rotate(0deg)';
                        } else {
                            // Close other open folders first
                            allCards.forEach(otherCard => {
                                if (otherCard !== card && otherCard.classList.contains('folder-open')) {
                                    otherCard.classList.remove('folder-open');
                                    const otherTitle = otherCard.querySelector('.folder-title');
                                    const otherIcon = otherCard.querySelector('.folder-icon');
                                    if (otherTitle && otherIcon) {
                                        otherTitle.setAttribute('aria-expanded', 'false');
                                        otherIcon.style.transform = 'rotate(0deg)';
                                    }
                                }
                            });

                            // Open current folder
                            card.classList.add('folder-open');
                            title.setAttribute('aria-expanded', 'true');
                            folderIcon.style.transform = 'rotate(90deg)';
                        }
                    };

                    title.addEventListener('click', toggleFolder);
                    title.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            toggleFolder();
                        }
                    });
                });
            }

            // Initial binding
            initPolicyFolders(document);

            // Re-bind after category switches
            const categoryItems = document.querySelectorAll('.category-item');
            categoryItems.forEach(item => {
                item.addEventListener('click', function () {
                    const categoryId = item.getAttribute('data-category');
                    const shownArea = document.querySelector(`.content-area[data-category="${categoryId}"]`);
                    if (shownArea) {
                        setTimeout(() => initPolicyFolders(shownArea), 100);
                    }
                });
            });
        });
    </script>


<script>
    // Search functionality for HR Policy page
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.querySelector('.search-icon-circle');
        const categoryItems = document.querySelectorAll('.category-item');
        const contentAreas = document.querySelectorAll('.content-area');

        const resetToDefault = () => {
            // Clear highlights
            categoryItems.forEach(it => it.classList.remove('highlight', 'active'));
            // Show all categories in header (in case future logic hides them)
            categoryItems.forEach(it => it.style.display = '');
            // Hide all content areas
            contentAreas.forEach(area => { area.style.display = 'none'; area.classList.remove('active'); });
            // Activate first category
            if (categoryItems.length > 0) {
                const firstCategory = categoryItems[0];
                const firstCategoryId = firstCategory.getAttribute('data-category');
                firstCategory.classList.add('active');
                // Show content for first
                contentAreas.forEach(area => {
                    if (area.getAttribute('data-category') === firstCategoryId) {
                        area.style.display = 'block';
                        area.classList.add('active');
                    }
                });
            }
        };

        const performSearch = () => {
            const term = (searchInput.value || '').trim().toLowerCase();
            if (!term) {
                resetToDefault();
                return;
            }

            let firstMatch = null;

            // Highlight matching categories by name
            categoryItems.forEach(item => {
                const matches = item.textContent.toLowerCase().includes(term);
                if (matches) {
                    item.classList.add('highlight');
                    if (!firstMatch) firstMatch = item;
                } else {
                    item.classList.remove('highlight');
                }
            });

            if (!firstMatch) {
                // No category name matched; try to match any policy title/content in content areas
                contentAreas.forEach(area => {
                    const inArea = area.querySelector('.folder-title, .folder-content p');
                    if (!firstMatch && inArea && area.textContent.toLowerCase().includes(term)) {
                        // Map content-area back to its header category item
                        const catId = area.getAttribute('data-category');
                        const catHeader = Array.from(categoryItems).find(ci => ci.getAttribute('data-category') === catId);
                        if (catHeader) firstMatch = catHeader;
                    }
                });
            }

            if (firstMatch) {
                const catId = firstMatch.getAttribute('data-category');
                // Activate this category similar to click handler
                categoryItems.forEach(it => it.classList.remove('active'));
                firstMatch.classList.add('active');
                // Hide all content areas
                contentAreas.forEach(area => { area.style.display = 'none'; area.classList.remove('active'); });
                // Show the target content area
                contentAreas.forEach(area => {
                    if (area.getAttribute('data-category') === catId) {
                        area.style.display = 'block';
                        area.classList.add('active');
                    }
                });
            }
        };

        // Trigger search on click of the search icon
        if (searchBtn) {
            searchBtn.addEventListener('click', performSearch);
        }

        // Trigger search on Enter key inside the input
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });

            // Live highlighting as user types (non-destructive)
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
