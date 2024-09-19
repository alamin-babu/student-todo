<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student To-Do List</title>
    <link rel="shortcut icon" href="{{asset('public/check.png')}}" type="image/x-icon">

    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f4f8;
        color: #333;
        padding: 20px;
        line-height: 1.6;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #2c3e50;
        font-size: 2.5em;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    input[type="text"],
    input[type="email"] {
        padding: 12px;
        margin: 8px;
        border-radius: 5px;
        border: 1px solid #bdc3c7;
        width: 250px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus {
        outline: none;
        border-color: #3498db;
    }

    button {
        padding: 12px 24px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2980b9;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
        margin-top: 30px;
        background-color: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #34495e;
        color: #ffffff;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .deleteBtn {
        background-color: #e74c3c;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .deleteBtn:hover {
        background-color: #c0392b;
    }

    .editBtn {
        background-color: #2ecc71;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 5px;
        transition: background-color 0.3s ease;
    }

    .editBtn:hover {
        background-color: #27ae60;
    }

    .center {
        text-align: center;
    }

    .no-tasks {
        text-align: center;
        margin-top: 20px;
        color: #7f8c8d;
        font-style: italic;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 30px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .close:hover,
    .close:focus {
        color: #2c3e50;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <h1>Student To-Do List</h1>

    <form id="todoForm">
        <input type="text" id="id" placeholder="Student ID" required>
        <input type="text" id="name" placeholder="Student Name" required>
        <input type="email" id="email" placeholder="Student Email" required>
        <input type="text" id="task" placeholder="Task" required>
        <button type="submit">Add Task</button>
    </form>

    <div class="center">
        <table id="todoTable" style="display: none;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Task</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <p class="no-tasks">No tasks added yet.</p>
    </div>

    <!-- Modal for delete confirmation -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeConfirm">&times;</span>
            <p>Are you sure you want to delete this task?</p>
            <button id="confirmDelete" class="deleteBtn">Yes, Delete</button>
            <button id="cancelDelete" class="deleteBtn">Cancel</button>
        </div>
    </div>

    <!-- Modal for editing -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEdit">&times;</span>
            <h2>Edit Task</h2>
            <form id="editForm">
                <input type="text" id="editName" placeholder="Student Name" required>
                <input type="email" id="editEmail" placeholder="Student Email" required>
                <input type="text" id="editTask" placeholder="Task" required>
                <input type="hidden" id="editId">
                <button type="submit">Update Task</button>
            </form>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const todoTable = document.querySelector('#todoTable');
        const noTasksMsg = document.querySelector('.no-tasks');
        const confirmModal = document.querySelector('#confirmModal');
        const editModal = document.querySelector('#editModal');
        const confirmDelete = document.querySelector('#confirmDelete');
        const cancelDelete = document.querySelector('#cancelDelete');
        const closeConfirm = document.querySelector('#closeConfirm');
        const closeEdit = document.querySelector('#closeEdit');
        const editForm = document.querySelector('#editForm');
        let deleteId = null;

        // Fetch all tasks
        function fetchTasks() {
            fetch('/students')
                .then(response => response.json())
                .then(students => {
                    let rows = '';
                    if (students.length > 0) {
                        todoTable.style.display = 'table';
                        noTasksMsg.style.display = 'none';

                        students.forEach(student => {
                            rows += `
                                    <tr>
                                        <td>${student.id}</td>
                                        <td>${student.name}</td>
                                        <td>${student.email}</td>
                                        <td>${student.task}</td>
                                        <td>
                                            <button class="editBtn" data-id="${student.id}" data-name="${student.name}" data-email="${student.email}" data-task="${student.task}">Edit</button>
                                            <button class="deleteBtn" data-id="${student.id}">Delete</button>
                                        </td>
                                    </tr>
                                `;
                        });
                    } else {
                        todoTable.style.display = 'none';
                        noTasksMsg.style.display = 'block';
                    }
                    document.querySelector('#todoTable tbody').innerHTML = rows;
                })
                .catch(error => console.error('Error fetching tasks:', error));
        }

        fetchTasks();

        // Add new task
        document.querySelector('#todoForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.querySelector('#id').value;
            const name = document.querySelector('#name').value;
            const email = document.querySelector('#email').value;
            const task = document.querySelector('#task').value;

            fetch('/students', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id,
                        name,
                        email,
                        task
                    })
                })
                .then(response => response.json())
                .then(student => {
                    if (student.error) {
                        alert(student.error);
                    } else {
                        fetchTasks();
                        document.querySelector('#id').value = '';
                        document.querySelector('#name').value = '';
                        document.querySelector('#email').value = '';
                        document.querySelector('#task').value = '';
                    }
                })
                .catch(error => console.error('Error adding task:', error));
        });

        // Open edit modal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('editBtn')) {
                const id = e.target.getAttribute('data-id');
                const name = e.target.getAttribute('data-name');
                const email = e.target.getAttribute('data-email');
                const task = e.target.getAttribute('data-task');

                // Populate form with existing data
                document.querySelector('#editName').value = name;
                document.querySelector('#editEmail').value = email;
                document.querySelector('#editTask').value = task;
                document.querySelector('#editId').value = id;

                editModal.style.display = 'block';
            }
        });

        // Edit task form submission
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.querySelector('#editId').value;
            const name = document.querySelector('#editName').value;
            const email = document.querySelector('#editEmail').value;
            const task = document.querySelector('#editTask').value;

            fetch(`/students/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        email,
                        task
                    })
                })
                .then(response => response.json())
                .then(() => {
                    fetchTasks();
                    editModal.style.display = 'none';
                })
                .catch(error => console.error('Error updating task:', error));
        });

        // Open confirmation modal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('deleteBtn')) {
                deleteId = e.target.getAttribute('data-id');
                confirmModal.style.display = 'block';
            }
        });

        // Close confirmation modal
        closeConfirm.addEventListener('click', function() {
            confirmModal.style.display = 'none';
        });

        // Confirm delete
        confirmDelete.addEventListener('click', function() {
            fetch(`/students/${deleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(() => {
                    fetchTasks();
                    confirmModal.style.display = 'none';
                })
                .catch(error => console.error('Error deleting task:', error));
        });

        // Cancel delete
        cancelDelete.addEventListener('click', function() {
            confirmModal.style.display = 'none';
        });

        // Close edit modal
        closeEdit.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
    });
    </script>
</body>

</html>