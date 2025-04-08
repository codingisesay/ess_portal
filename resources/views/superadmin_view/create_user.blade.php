@extends('superadmin_view/superadmin_layout')
@section('content')

<link rel="stylesheet" href="{{ asset('errors/error.css') }}">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('admin_end/css/admin_form.css') }}">
<link rel="stylesheet" href="{{ asset('admin_end/css/popup_form.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php $id = Auth::guard('superadmin')->user()->id; ?>

<div class="container">
    <h3>Create User Of Your Organisation</h3>

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button onclick="showUserTable(this)">Show Table</button>
        <button onclick="showUserForm(this)">Show Form</button>
    </div>

    <!-- Form Section -->
    <div id="formSection">
        <form action="{{ route('register_save') }}" method="POST">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <input type="hidden" name="organisation_id" value="{{$id}}">
                    <input type="text" name="username" required>
                    <label>Name</label>
                </div>
                <div class="form-group">
                    <input type="text" name="empid" required>
                    <label>Company Emp ID</label>
                </div>
                <div class="form-group">
                    <input type="email" name="usermailid" required>
                    <label>Email</label>
                </div>
                <div class="form-group">
                    <input type="text" id="passwordField" name="userpassword" readonly>
                    <label>Password</label>
                </div>
                <div class="form-group">
                    <a href="#" onclick="generateAndDisplayPassword()">Generate Password</a>
                </div>
                <button class="create-btn" type="submit">Create User</button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableSection" style="display:none;">
        <div class="table-container">

            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by name or email..." onkeyup="searchUsers()" />
            </div>

            <table id="userTable">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <!-- Pagination Controls -->
            <div id="pagination" class="pagination-container">
                <button onclick="changePage('prev')">Prev</button>
                <span id="pageNumbers"></span>
                <button onclick="changePage('next')">Next</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    const rowsPerPage = 7;
    const users = @json($users);
    let filteredUsers = [...users];

    function displayPage(page) {
        const table = document.querySelector("#userTable tbody");
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedUsers = filteredUsers.slice(start, end);
        
        table.innerHTML = "";

        if (paginatedUsers.length === 0) {
            table.innerHTML = `<tr><td colspan="5">No users found</td></tr>`;
        } else {
            paginatedUsers.forEach((user, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${start + index + 1}</td>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><i class="bi bi-pencil-square" onclick="openEditUserModal(${JSON.stringify(user)})"></i></td>
                `;
                table.appendChild(row);
            });
        }

        updatePaginationControls();
    }

    function updatePaginationControls() {
        const totalPages = Math.ceil(filteredUsers.length / rowsPerPage);
        const pageNumbers = document.getElementById("pageNumbers");
        pageNumbers.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.onclick = () => changePage(i);
            if (i === currentPage) btn.disabled = true;
            pageNumbers.appendChild(btn);
        }
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredUsers.length / rowsPerPage);
        if (page === 'prev' && currentPage > 1) currentPage--;
        else if (page === 'next' && currentPage < totalPages) currentPage++;
        else if (typeof page === 'number') currentPage = page;
        displayPage(currentPage);
    }

    function searchUsers() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        filteredUsers = users.filter(user => 
            user.name.toLowerCase().includes(query) || 
            user.email.toLowerCase().includes(query)
        );
        currentPage = 1;
        displayPage(currentPage);
    }

    function showUserForm(el) {
        document.getElementById('formSection').style.display = 'block';
        document.getElementById('tableSection').style.display = 'none';
        updateButtonStyles(el);
    }

    function showUserTable(el) {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('tableSection').style.display = 'block';
        updateButtonStyles(el);
    }

    function updateButtonStyles(activeButton) {
        const buttons = activeButton.parentElement.children;
        for (let btn of buttons) btn.classList.remove('active');
        activeButton.classList.add('active');
    }

    function generateSecurePassword(length = 12) {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
        const array = new Uint32Array(length);
        window.crypto.getRandomValues(array);
        return Array.from(array, (num) => chars[num % chars.length]).join('');
    }

    function generateAndDisplayPassword() {
        const password = generateSecurePassword(12);
        document.getElementById('passwordField').value = password;
    }

    function openEditUserModal(user) {
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editUsername').value = user.name;
        document.getElementById('editEmpid').value = user.employeeID;
        document.getElementById('editUsermailid').value = user.email;
        document.getElementById('editUserModal').style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', () => {
        displayPage(currentPage);
        const firstButton = document.querySelector('.toggle-buttons button:first-child');
        showUserTable(firstButton);
    });
</script>

<style>
    .search-container {
        margin-bottom: 10px;
    }

    #searchInput {
        width: 100%;
        padding: 8px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .pagination-container {
        margin-top: 15px;
    }

    .pagination-container button {
        margin: 0 2px;
        padding: 5px 10px;
    }

 </style>

@endsection
