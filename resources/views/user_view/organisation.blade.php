<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Hierarchy</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="header">
    <h1>Organization Hierarchy</h1>
    <div class="dropdown">
        <select id="display-option" onchange="changeDisplayMode()">
            <option value="horizontal">Horizontal Organization Chart</option>
            <option value="vertical">Vertical Organization Chart</option>
        </select>
    </div>
    <div class="search-box">
        <input type="text" id="search" placeholder="Search here..." />
        <button type="button">
            <img src="{{ asset('resource/image/common/search (1).png') }}" alt="Search" />
        </button>
    </div>
</div>

<div class="scroll-container">
    <div class="tree">
        <?php
            $controller = new \App\Http\Controllers\organisationController();
            $controller->displayEmployeeTree(null, $departmentColors);
        ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('search');

    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const employees = document.querySelectorAll('.employee');

        if (!query) {
            employees.forEach(emp => {
                emp.style.display = 'block';
                const empName = emp.querySelector('.emp-name');
                empName.innerHTML = empName.textContent;
            });
            return;
        }

        employees.forEach(emp => {
            emp.style.display = 'none';
            const empName = emp.querySelector('.emp-name');
            empName.innerHTML = empName.textContent;
        });

        employees.forEach(emp => {
            const nameElement = emp.querySelector('.emp-name');
            const name = nameElement.textContent.toLowerCase();

            if (name.includes(query)) {
                emp.style.display = 'block';
                const regex = new RegExp(`(${query})`, 'gi');
                nameElement.innerHTML = nameElement.textContent.replace(regex, '<span class="highlight">$1</span>');

                let currentParent = emp;
                while (currentParent) {
                    const managerId = currentParent.getAttribute('data-manager-id');
                    if (managerId) {
                        currentParent = document.querySelector(`.employee[data-emp-id='${managerId}']`);
                        if (currentParent) currentParent.style.display = 'block';
                    } else {
                        currentParent = null;
                    }
                }

                const children = document.querySelectorAll(`.employee[data-manager-id='${emp.getAttribute('data-emp-id')}']`);
                children.forEach(child => child.style.display = 'block');
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const employeeCards = document.querySelectorAll('.employee-box');

    employeeCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();

            const parentLi = this.parentElement;
            const childUl = parentLi.querySelector('ul');

            if (childUl) {
                childUl.style.display = (childUl.style.display === 'none' || !childUl.style.display) ? 'flex' : 'none';
            }
        });
    });
});

function changeDisplayMode() {
    const displayOption = document.getElementById('display-option').value;

    if (displayOption === 'vertical') {
        window.location.href = '../orgnizationchart/vert_org.php'; 
    }
}

window.onload = function() {
    document.getElementById('display-option').value = 'horizontal';
};
</script>
<style>
.highlight {
    background-color: #8A3366;
    font-weight: bold;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>
</body>
</html>