# Laravel ERP System - Inventory & Sales Management

A basic ERP system built with **Laravel** focused on **Inventory Management**, **Sales Orders**, **PDF invoice generation**, and **RESTful API** support with **Sanctum Authentication**.

---

## ✅ Features

### 1. Authentication & Roles
- Laravel Breeze for auth scaffolding
- Role-based access:  
  - **Admin**: Full access to products, dashboard, and all orders  
  - **Salesperson**: Can only create/view sales orders

### 2. Inventory Management
- CRUD operations for Products (name, SKU, price, quantity)
- Automatically reduces stock when sales order is confirmed
- Low-stock alerts on dashboard

### 3. Sales Orders
- Create sales orders with **multiple products**
- Auto calculate total and **decrease stock**
- Export sales order as **PDF** using `barryvdh/laravel-dompdf`

### 4. Dashboard
- Show total orders
- Total sales (sum)
- List of low-stock products

---

## 🛠️ Tech Stack

- Laravel (Latest)
- Laravel Breeze
- Laravel Sanctum
- MySQL
- Bootstrap/Tailwind CSS (Frontend)
- DOMPDF

---

## 🚀 Setup Instructions

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (for Breeze frontend)

### Installation

```bash
git clone https://github.com/your-username/erp-inventory-sales.git
cd erp-inventory-sales

composer install

cp .env.example .env

php artisan key:generate
php artisan migrate --seed

npm install && npm run dev

php artisan serve
