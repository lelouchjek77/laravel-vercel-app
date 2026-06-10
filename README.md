# Collaborative Document Editor

A lightweight collaborative document editor inspired by Google Docs, built with Laravel 9, Vue 3, Tiptap, Laravel Sanctum, and SQLite.

## Features

### Authentication

* Login using Laravel Sanctum
* Protected application routes
* Secure logout functionality

### Document Management

* Create documents
* Edit documents
* Save document changes
* Reopen previously created documents
* Rename documents

### Rich Text Editing

* Bold
* Italic
* Underline
* Headings
* Bullet Lists
* Numbered Lists

### Document Sharing

* Share documents with other users
* Distinguish between owned and shared documents
* View documents shared by other users

### File Import

Supported file types:

* `.txt`
* `.md`

Uploaded files are converted into editable documents within the application.

---

## Tech Stack

### Backend

* Laravel 9
* Laravel Sanctum
* SQLite

### Frontend

* Vue 3
* Vue Router
* Axios
* Tiptap Editor

---

## Local Setup

### Backend Setup

Navigate to the backend directory:

```bash
cd backend
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Run migrations:

```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

Start the Laravel development server:

```bash
php artisan serve
```

Backend URL:

```text
http://127.0.0.1:8000
```

---

### Frontend Setup

Navigate to the frontend directory:

```bash
cd frontend
```

Install dependencies:

```bash
npm install
```

Start the development server:

```bash
npm run dev
```

Frontend URL:

```text
http://localhost:5173
```

---

## Test Accounts

### Owner Account

| Field    | Value                                   |
| -------- | --------------------------------------- |
| Email    | [owner@test.com](mailto:owner@test.com) |
| Password | password123                             |

### Collaborator Account

| Field    | Value                                                 |
| -------- | ----------------------------------------------------- |
| Email    | [collaborator@test.com](mailto:collaborator@test.com) |
| Password | password123                                           |

---

## Running Tests

Run all automated tests:

```bash
php artisan test
```

---

## Project Structure

```text
backend/
├── app/
├── database/
├── routes/
└── tests/

frontend/
├── src/
│   ├── pages/
│   ├── router/
│   ├── services/
│   └── components/
└── public/
```

---

## Known Limitations

* Real-time collaboration is not implemented
* Version history is not implemented
* Commenting and suggestion mode are not implemented
* Sharing uses a simplified permission model
* Only `.txt` and `.md` file imports are currently supported

---

## Future Improvements

Given additional development time, the following enhancements would be prioritized:

* Real-time collaboration indicators
* Document version history
* Commenting and suggestion mode
* Export to PDF
* Advanced sharing permissions
* Search and filtering capabilities

---

## Assignment Notes

This project was intentionally scoped to focus on the core collaborative document workflow:

* Authentication
* Document CRUD operations
* Rich text editing
* Document sharing
* File import
* Persistence
* Automated testing

Advanced collaboration features were intentionally deferred to maximize implementation quality within the assignment time constraints.
