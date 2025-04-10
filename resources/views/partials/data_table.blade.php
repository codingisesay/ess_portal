@props(['items', 'columns', 'editModalId' => null, 'perPage' => 10, 'hasActions' => false])

<div class="table-container">
    <!-- Add search input -->
    <div class="table-search mb-3">
        <input type="text" id="tableSearch" placeholder="Search..." class="form-control">
    </div>
    
    <table id="dataTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Serial No</th>
                @foreach($columns as $column)
                    @if($column['accessor'] !== 'id') <!-- Skip the id column -->
                        <th>{{ $column['header'] }}</th>
                    @endif
                @endforeach
                @if($hasActions)
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @foreach($columns as $column)
                        @if($column['accessor'] !== 'id') <!-- Skip the id column -->
                            <td>{{ $item->{$column['accessor']} }}</td>
                        @endif
                    @endforeach
                    @if($hasActions)
                        <td>
                            @if(isset($column['action']))
                                {!! $column['action'] !!}
                            @elseif($editModalId)
                            <button class="btn p-0" onclick="openEditModal('{{ $editModalId }}', {{ json_encode($item) }})">
                                <x-icon name="edit" /> 
                                </button>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination-container">
        <small class="page-info">Showing Page <span class="current-page">1</span> of <span class="total-pages">1</span></small>
        <ul class="pagination">
            <li><a href="#" class="page-prev"><x-icon name="prev" /></a></li>        
            <li class="page-numbers"></li>     
            <li><a href="#" class="page-next"><x-icon name="next" /></a></li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cache DOM elements
        const table = document.getElementById('dataTable');
        const searchInput = document.getElementById('tableSearch');
        const prevButton = document.querySelector('.page-prev');
        const nextButton = document.querySelector('.page-next');
        const currentPageEl = document.querySelector('.current-page');
        const totalPagesEl = document.querySelector('.total-pages');
        const pageNumbersContainer = document.querySelector('.page-numbers');
        
        if (!table || !searchInput || !prevButton || !nextButton || !currentPageEl || !totalPagesEl || !pageNumbersContainer) {
            console.error('Required elements not found');
            return;
        }

        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const perPage = 10; // Fixed to 10 rows per page
        let totalPages = Math.ceil(rows.length / perPage);
        let currentPage = 1;
        let filteredRows = rows;
        
        // Initialize pagination
        updatePagination();
        showPage(currentPage);
        
        // Search functionality
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            if (searchTerm === '') {
                filteredRows = rows;
            } else {
                filteredRows = rows.filter(row => {
                    return Array.from(row.cells).some(cell => {
                        return cell.textContent.toLowerCase().includes(searchTerm);
                    });
                });
            }
            
            totalPages = Math.ceil(filteredRows.length / perPage) || 1;
            currentPage = 1;
            updatePagination();
            showPage(currentPage);
        });
        
        // Pagination event listeners
        prevButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
                updatePagination();
            }
        });
        
        nextButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
                updatePagination();
            }
        });
        
        function showPage(page) {
            const start = (page - 1) * perPage;
            const end = start + perPage;
            
            // Hide all rows first
            rows.forEach(row => row.style.display = 'none');
            
            // Show only filtered rows for current page
            filteredRows.slice(start, end).forEach(row => {
                row.style.display = '';
            });
            
            currentPageEl.textContent = page;
        }
        
        function updatePagination() {
            totalPages = Math.ceil(filteredRows.length / perPage) || 1;
            totalPagesEl.textContent = totalPages;
            
            // Disable prev/next buttons when appropriate
            prevButton.parentElement.classList.toggle('disabled', currentPage <= 1);
            nextButton.parentElement.classList.toggle('disabled', currentPage >= totalPages);
            
            // Generate page numbers with ellipsis logic
            let pageNumbersHTML = '';
            const maxVisiblePages = 5; // Number of page buttons to show
            let startPage, endPage;
            
            if (totalPages <= maxVisiblePages) {
                // Show all pages
                startPage = 1;
                endPage = totalPages;
            } else {
                // Calculate start and end pages with ellipsis
                const maxVisibleBeforeAfter = Math.floor(maxVisiblePages / 2);
                
                if (currentPage <= maxVisibleBeforeAfter) {
                    // Near the beginning
                    startPage = 1;
                    endPage = maxVisiblePages;
                } else if (currentPage + maxVisibleBeforeAfter >= totalPages) {
                    // Near the end
                    startPage = totalPages - maxVisiblePages + 1;
                    endPage = totalPages;
                } else {
                    // In the middle
                    startPage = currentPage - maxVisibleBeforeAfter;
                    endPage = currentPage + maxVisibleBeforeAfter;
                }
            }
            
            // Always show first page
            if (startPage > 1) {
                pageNumbersHTML += `<a href="#" class="page-number" data-page="1">1</a>`;
                if (startPage > 2) {
                    pageNumbersHTML += `<span class="ellipsis">...</span>`;
                }
            }
            
            // Generate page numbers
            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    pageNumbersHTML += `<a href="#" class="page-number active" data-page="${i}">${i}</a>`;
                } else {
                    pageNumbersHTML += `<a href="#" class="page-number" data-page="${i}">${i}</a>`;
                }
            }
            
            // Always show last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    pageNumbersHTML += `<span class="ellipsis">...</span>`;
                }
                pageNumbersHTML += `<a href="#" class="page-number" data-page="${totalPages}">${totalPages}</a>`;
            }
            
            pageNumbersContainer.innerHTML = pageNumbersHTML;
            
            // Add click event listeners to page numbers
            document.querySelectorAll('.page-number').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = parseInt(this.getAttribute('data-page'));
                    if (page !== currentPage) {
                        currentPage = page;
                        showPage(currentPage);
                        updatePagination();
                    }
                });
            });
        }
    });
</script>