@extends('admin_view.admin_layout')

@section('content')
<!-- Include client details specific CSS -->
<link rel="stylesheet" href="{{ asset('Offical_admin/css/client-details.css') }}">

<div class="client-details-container">
    <!-- Header Section -->
    <div class="client-header">
        <h2>All Clients</h2>

        <!-- Header action area (search) -->
        <div class="header-actions">
            <div class="search-container">
                <!-- Search input for filtering clients -->
                <input type="text" 
                       id="clientSearch" 
                       placeholder="Search clients..." 
                       class="search-input" 
                       onkeyup="searchClients()">
                <!-- Search icon -->
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>

    <!-- Client Cards Grid -->
    <div class="client-cards-grid">
        <!-- No Results Message (hidden by default) -->
        <div id="noResultsMessage" class="no-results-message">
            <i class="fas fa-search"></i>
            <h3>No clients found</h3>
            <p>No clients match your search criteria. Try different keywords.</p>
        </div>
        
         <!-- Loop through all organisations passed from the controller -->
        @foreach($organisations as $org)
        <div class="client-card"
            data-client-id="{{ $org->id }}"
            data-package-id="{{ $org->software_package_plan }}"
            data-package-name="{{ $org->plan_name }}">

            
            <!-- Card Header -->
            <div class="card-header">
                <!-- Avatar using first two letters of organisation name -->
                <div class="client-avatar">
                    {{ strtoupper(substr($org->name, 0, 2)) }}
                </div>

                <!-- Client basic information -->
                <div class="client-info">
                    <h3 class="client-name">{{ $org->name }}</h3>
                    <p class="client-type">{{ $org->client_name ?? 'Client' }}</p>
                </div>

                <!-- Toggle details icon -->
                <i class="fas fa-eye view-icon toggle-details-btn" onclick="toggleDetails(this)"></i>
            </div>

            <!-- Client detailed information section -->
            <div class="details-section">

                <!-- Contact Information -->
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    <span>Contact Details</span>
                </div>

                <!-- Contact person -->
                <div class="detail-row">
                    <span class="detail-label">Contact Person:</span>
                    <span class="detail-value">{{ $org->contact_person ?? 'N/A' }}</span>
                </div>

                <!-- Email -->
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $org->email ?? 'N/A' }}</span>
                </div>

                <!-- Mobile number -->
                <div class="detail-row">
                    <span class="detail-label">Mobile:</span>
                    <span class="detail-value">{{ $org->mobile ?? 'N/A' }}</span>
                </div>

                <!-- Address Section -->
                <div class="section-title">Address</div>

                <!-- kept the all fields of addres in only one address input  -->
                <!-- Full address -->
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value">
                        {{ $org->road_street ?? '' }}, 
                        {{ $org->landmark }},
                        {{ $org->building_no ?? '' }} ,{{ $org->premises_name ?? '' }},
                        {{ $org->district ?? '' }}, 
                        {{ $org->state ?? '' }} - {{ $org->pincode ?? '' }}
                    </span>
                </div>

                <!-- Country -->
                <div class="detail-row">
                    <span class="detail-label">Country:</span>
                    <span class="detail-value">{{ $org->country ?? 'India' }}</span>
                </div>

                <!-- Business Details -->
                <div class="section-title">Business Details</div>

                <!-- GST Number -->
                <div class="detail-row">
                    <span class="detail-label">GST Number:</span>
                    <span class="detail-value">{{ $org->GST_number ?? 'N/A' }}</span>
                </div>

                <!-- PAN -->
                <div class="detail-row">
                    <span class="detail-label">PAN:</span>
                    <span class="detail-value">{{ $org->PAN ?? 'N/A' }}</span>
                </div>

                <!-- TAN -->
                <div class="detail-row">
                    <span class="detail-label">TAN:</span>
                    <span class="detail-value">{{ $org->TAN ?? 'N/A' }}</span>
                </div>

                <!-- Industry type -->
                <div class="detail-row">
                    <span class="detail-label">Industry Type:</span>
                    <span class="detail-value">{{ $org->industry_type ?? 'N/A' }}</span>
                </div>

                <!-- Subscription Details -->
                <div class="section-title">Subscription</div>

                <!-- Plan -->
                <div class="detail-row">
                    <span class="detail-label">Plan:</span>
                    <span class="detail-value">{{ $org->software_package_plan ?? 'N/A' }}</span>
                </div>

                <!-- Expiry date (if available) -->
                @if($org->expire_date)
                <div class="detail-row">
                    <span class="detail-label">Expiry Date:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($org->expire_date)->format('d M Y') }}</span>
                </div>
                @endif

                <!-- Certificates Section -->
                <div class="section-title">Certificates</div>
                <div class="certificates-container">

                    <!-- MSME Certificate -->
                    @if($org->MSME_udyam_certificate)
                    <div class="certificate-item">
                        <i class="fas fa-file-pdf"></i>
                        <div class="certificate-info">
                            <span class="certificate-name">MSME Udyam Certificate</span>
                            <a href="{{ route('admin.organisation.certificate', ['id' => $org->id, 'type' => 'msme']) }}" 
                               class="download-certificate" 
                               title="View MSME Certificate"
                               target="_blank">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- GST Certificate -->
                    @if($org->GST_registration_certificate)
                    <div class="certificate-item">
                        <i class="fas fa-file-pdf"></i>
                        <div class="certificate-info">
                            <span class="certificate-name">GST Registration Certificate</span>
                            <a href="{{ route('admin.organisation.certificate', ['id' => $org->id, 'type' => 'gst']) }}" 
                               class="download-certificate" 
                               title="View GST Certificate"
                               target="_blank">
                               <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- No certificates message -->
                    @if(!$org->MSME_udyam_certificate && !$org->GST_registration_certificate)
                    <div class="no-certificates">
                        <i class="far fa-folder-open"></i>
                        <span>No certificates uploaded</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Button to show details in modal -->
            <div class="toggle-details" onclick="showClientDetails(this)">
                Show Details <i class="fas fa-chevron-down"></i>
            </div>

        </div>
        @endforeach
    </div>
</div>

<!-- Client Details Modal -->
<div id="clientDetailsModal" class="client-modal">
    <div class="client-modal-content">
        <!-- Close modal button -->
        <span class="close-modal">&times;</span>

        <!-- Modal body where client details are injected -->
        <div id="modalClientDetails" class="modal-body">
            <!-- Dynamic content will be inserted here -->
        </div>
    </div>
</div>

<script>
// Reference to the modal element
const modal = document.getElementById('clientDetailsModal');

// Close modal function
function closeModal() {
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable page scrolling
    }
}

// DOM ready event
document.addEventListener('DOMContentLoaded', function() {

    // Close modal when clicking close icon
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('close-modal')) {
            closeModal();
            event.preventDefault();
            event.stopPropagation();
        }
    });

    // Close modal when clicking outside content
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    // Close modal on ESC key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal && modal.style.display === 'block') {
            closeModal();
        }
    });
});

// Show client details inside modal
function showClientDetails(button) {
    if (!button) return;

    const card = button.closest('.client-card');
    if (!card) return;

    const detailsSection = card.querySelector('.details-section');
    if (!detailsSection) return;

    const modalContent = document.getElementById('modalClientDetails');
    if (!modal || !modalContent) return;

    // Copy details into modal
    modalContent.innerHTML = detailsSection.innerHTML;

    // Show modal and disable body scroll
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';

    // Scroll modal to top
    modal.scrollTop = 0;
}

// Toggle inline details view
function toggleDetails(button) {
    const card = button.closest('.client-card');
    const detailsSection = card.querySelector('.details-section');
    const toggleText = card.querySelector('.toggle-details');
    const icon = button.classList.contains('toggle-details-btn') ? button : button.querySelector('i');

    // Toggle expanded class
    detailsSection.classList.toggle('expanded');

    if (detailsSection.classList.contains('expanded')) {
        toggleText.innerHTML = 'Hide Details <i class="fas fa-chevron-up"></i>';
        if (icon) icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        toggleText.innerHTML = 'Show Details <i class="fas fa-chevron-down"></i>';
        if (icon) icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Client search functionality
function searchClients() {
    const searchTerm = document.getElementById('clientSearch').value.toLowerCase();
    const noResultsMessage = document.getElementById('noResultsMessage');
    const clientCards = document.querySelectorAll('.client-card[data-searchable="true"]');
    let visibleCards = 0;

    // Loop through all client cards
    clientCards.forEach(card => {
        const cardText = card.textContent.toLowerCase();

        if (searchTerm === '' || cardText.includes(searchTerm)) {
            card.style.display = '';
            visibleCards++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show or hide "no results" message
    if (visibleCards === 0 && searchTerm !== '') {
        noResultsMessage.style.display = 'block';
    } else {
        noResultsMessage.style.display = 'none';
    }
}

// Ensure search works even on dynamic load
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('clientSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', searchClients);
    }
});
</script>

@endsection
