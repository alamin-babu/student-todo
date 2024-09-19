
# Student To-Do List App

## Overview
A CRUD application for managing student information including ID, name, email, and tasks. Built with Laravel for the backend, MySQL for the database, and AJAX for dynamic updates.

## Features
- **Add**: Create new student records.
- **Edit**: Update existing student records.
- **Delete**: Remove student records with confirmation.
- **View**: Display all student records in a table.

## Technologies
- **Frontend**: HTML, CSS, JavaScript (AJAX)
- **Backend**: Laravel (PHP)
- **Database**: MySQL

## Setup
1. **Clone the Repo**
   ```bash
   git clone https://github.com/alamin-babu/student-todo.git
   cd student-todo
   ```
2. **Install Dependencies**
   ```bash
   composer install
   ```
3. **Configure Environment**
   Copy `.env.example` to `.env` and configure database settings:
   ```bash
   cp .env.example .env
   ```
4. **Generate Key & Migrate**
   ```
   php artisan key:generate
   php artisan migrate
   ```
5. **Start Server**
   ```
   php artisan serve
   ```

## Usage
- **Add**: Use the form to add a student.
- **Edit**: Click "Edit" to update a record.
- **Delete**: Click "Delete" and confirm in the modal.



## API Endpoints
- **GET `/students`**: List all students.
- **POST `/students`**: Add a student.
- **PUT `/students/{id}`**: Update a student.
- **DELETE `/students/{id}`**: Delete a student.
