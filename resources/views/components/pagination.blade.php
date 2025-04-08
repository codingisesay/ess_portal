<div class="pagination-container pagination-style-{{ $style }}">
    <button 
        onclick="{{ $onPageChange }}('prev')" 
        {{ $currentPage <= 1 ? 'disabled' : '' }}
    >
        Prev
    </button>
    
    <span class="page-numbers">
        @for ($i = 1; $i <= $totalPages; $i++)
            <button 
                onclick="{{ $onPageChange }}({{ $i }})" 
                {{ $i == $currentPage ? 'disabled' : '' }}
            >
                {{ $i }}
            </button>
        @endfor
    </span>
    
    <button 
        onclick="{{ $onPageChange }}('next')" 
        {{ $currentPage >= $totalPages ? 'disabled' : '' }}
    >
        Next
    </button>
</div>

@push('styles')
<style>
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        margin-top: 20px;
    }

    .pagination-container button {
        padding: 6px 14px;
        border: 1px solid #ccc;
        background-color: #fff;
        color: #333;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .pagination-container button:hover {
        background-color: #872657;
        color: #fff;
        border-color: #872657;
    }

    .pagination-container button:disabled {
        background-color: #eee;
        color: #aaa;
        cursor: default;
        border: 1px solid #ddd;
        box-shadow: none;
    }

    /* Additional styles for different style options */
    .pagination-style-minimal button {
        border: none;
        box-shadow: none;
        background: transparent;
    }

    .pagination-style-dark button {
        background-color: #333;
        color: white;
    }
</style>
@endpush