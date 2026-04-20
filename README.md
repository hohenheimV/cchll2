<h1 align="center">eLANDSKAP</h1>

<p align="center">
Digital Landscape Management System
</p>

---
<p align="right"><i>Most of the contents are AI-generated</i></p>

## About eLANDSKAP

**eLANDSKAP** is a centralized digital platform developed to manage and organize landscape-related information across multiple stakeholders.

The system transforms traditional manual processes into a structured digital workflow, enabling efficient management of parks, landscape assets, project applications, and related documentation.

It is designed for use by:
- Jabatan Landskap Negara (JLN)
- Pihak Berkuasa Tempatan (PBT)
- Industry players
- Public users

---

## Key Features

### 🌿 Landscape Information Management

* Manage comprehensive landscape data including:

  * Parks information
  * Pelan Induk Landskap (Landscape Master Plans)
  * Tree planting records
  * Unique landscape entities

### 🏞️ Multi-Entity Management

* Support for multiple categories of landscape stakeholders:

  * Government agencies (JLN, PBT)
  * Industry players
  * Public access (view-only)

### 📁 Document Management

* Upload and manage documents related to:

  * Landscape projects
  * Applications (Permohonan Projek PBT)
  * Planning and reports

### 🗺️ Map Integration (ArcGIS)

* Visualize landscape data using **ArcGIS**
* Geospatial representation of parks and landscape elements

### 📊 Dashboard & Statistics

* Display aggregated data insights from the database
* Overview of records, projects, and submissions

### 🔐 Role-Based Access Control

* **Admin / Government Users (JLN, PBT):**

  * Full system access and data management
* **Industry Players:**

  * Manage and submit relevant landscape information
* **Public Users:**

  * View available landscape data

---

## Tech Stack

* **Backend:** Laravel 6
* **Frontend:** Blade
* **Database:** PostgreSQL
* **Mapping:** ArcGIS

---

## Installation

### 1. Clone the repository

```bash
git clone <your-repo-url>
cd elandskap
```

### 2. Install dependencies

```bash
composer install
npm install && npm run build
```

### 3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`

Set up your database connection:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Start the server

```bash
php artisan serve
```

---

## Usage

### 👤 Admin / Government Users (JLN, PBT)

* Manage all landscape-related data
* Upload and maintain documents
* Review and manage project applications
* Monitor system data via dashboard

### 🏢 Industry Players

* Submit and manage landscape-related information
* Upload relevant documents and project data

### 🌐 Public Users

* View landscape information and available data
* Access public-facing records

---

## Project Status

✅ Completed

---

## Contributing

This project is not open for public contributions.

---

## License

No license specified.
