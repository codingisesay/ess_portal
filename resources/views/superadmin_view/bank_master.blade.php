@extends('superadmin_view.superadmin_layout')
@section('content')

<div class="container">
    <h3>Bank Master</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button onclick="showBankTable(this)">Show Table</button>
        <button onclick="showBankForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection">
        @if($errors->any())
        <div class="alert custom-alert-warning">
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('insert_bank') }}">
            @csrf
            <div class="form-container row">
                <div class="col-4 mb-4">
                    <div class="form-group">
                        <input type="text" name="name" required>
                        <label>Bank Name</label>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="form-group">
                        <select name="status" required>
                            <option value="" disabled selected></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="create-btn" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection">
        @include('partials.data_table', [
            'items' => $banks,
            'columns' => [
                ['header' => 'ID', 'accessor' => 'id'],
                ['header' => 'Bank Name', 'accessor' => 'name'],
                ['header' => 'Status', 'accessor' => 'status'],
            ],
            'editModalId' => 'openEditModal',
            'hasActions' => true,
            'perPage' => 5
        ])
    </div>
</div>

<!-- Edit Modal -->
<div id="editBankModal" class="w3-modal" style="display:none;">
    <div class="w3-modal-content w3-animate-top w3-card-4">
        <header class="w3-container w3-teal">
            <span onclick="document.getElementById('editBankModal').style.display='none'"
                class="w3-button w3-display-topright">&times;</span>
            <h2>Edit Bank</h2>
        </header>
        <div class="w3-container">
            <form id="editBankForm" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="editBankId">
                <div class="popup-form-group">
                    <input type="text" name="name" id="editBankName" required>
                    <label for="editBankName">Bank Name</label>
                </div>
                <div class="popup-form-group">
                    <select name="status" id="editBankStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editBankStatus">Status</label>
                </div>
                <div class="popup-form-group">
                    <button class="create-btn1" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showBankForm(clickedElement) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) sibling.classList.remove('active');
        clickedElement.classList.add('active');
    }

    function showBankTable(clickedElement) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        const siblings = clickedElement.parentElement.children;
        for (let sibling of siblings) sibling.classList.remove('active');
        clickedElement.classList.add('active');
    }

    // Default: Show Table
    document.addEventListener('DOMContentLoaded', () => {
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showBankTable(firstButton);
    });

    function openEditModal(id, bankdata) {
        if (!id) {
            alert('Invalid bank data. Please try again.');
            return;
        }
        document.getElementById('editBankId').value = bankdata.id || '';
        document.getElementById('editBankName').value = bankdata.name || '';
        document.getElementById('editBankStatus').value = bankdata.status || '';

        const formAction = "{{ route('update_bank', ['id' => ':id']) }}".replace(':id', bankdata.id);
        document.getElementById('editBankForm').action = formAction;

        document.getElementById('editBankModal').style.display = 'block';
    }
</script>

@endsection
