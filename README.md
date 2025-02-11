# Pos Management System - Project Setup Guide

## Overview

Welcome to the setup guide for the **Pos Management System**. This document provides comprehensive steps to install, configure, and run the project in your local environment, using both Docker and a native setup. Follow these instructions to ensure proper configuration.

## Prerequisites

Please ensure you have the following installed on your system:

- **PHP** (version 8.3 or higher)
- **Composer**
- **npm**
- **MySQL** (version 8.0 or compatible, e.g., MariaDB)
- **Git**

## Server Requirements

This application requires a server with the following specifications:

- **PHP** (version 8.3 or higher) with the extensions:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - PDO
  - GD
  - Zip
  - PDO MySQL
- **MySQL** (version 8.0) or **MariaDB**
- **Composer**
- **Web Server**: Apache or Nginx

---

## Setup Options

This guide covers two setup methods:
1. **Using Docker**
2. **Setting Up Locally (Without Docker)**

---

### Setup with Docker

#### 1. Clone the Repository

```bash
git clone https://github.com/AzizulBSc/pos.git
cd pos
```

#### 2. Initialize the Project

```bash
sudo make setup
```

#### Additional Docker Commands

- **Install Dependencies**

    ```bash
    sudo make composer-install
    sudo make composer-update
    sudo make npm-install-build
    ```

- **Set File Permissions**

    ```bash
    sudo make set-permissions
    ```

- **Generate Application Key**

    ```bash
    sudo make generate-key
    ```

- **Run Migrations and Seed the Database**

    ```bash
    sudo make migrate-fresh-seed
    ```

- **Setup Environment File**

    ```bash
    sudo make setup-env
    ```

The application should now be accessible at [http://localhost](http://localhost).

---

### Setup Without Docker

#### 1. Clone the Repository

```bash
git clone https://github.com/AzizulBSc/pos.git
cd pos
```

#### 2. Install PHP and npm Dependencies

Within the project directory, run:

```bash
composer install
```

#### 3. Configure the Environment

Create the `.env` file by copying .env.example :

```bash
cp .env.example .env
```
#### 4. Generate Application Key

Secure the application by generating a key:

```bash
php artisan key:generate
```

#### 5. Configure Database
Create a Database name pos in your db. and then update your .env file as like following:
**Update `.env` Database Settings**:
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pos
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
```

#### 6. Run Migrations and Seed Data

To set up the database tables and populate them with initial data, run:

```bash
php artisan migrate --seed
```

#### 7. Start the Development Server

To run the application locally, execute:

```bash
php artisan serve
```

Your application will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

