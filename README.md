# 🛒 E-Commerce Order Management System

Modern, scalable e-commerce backend API built with Laravel 12.x, featuring comprehensive order management, cart functionality, and role-based access control.

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Database Setup](#-database-setup)
- [Seeded Data](#-seeded-data)
- [Authentication](#-authentication)
- [API Endpoints](#-api-endpoints)
- [Testing](#-testing)
- [Project Structure](#-project-structure)
- [Development](#-development)

## ✨ Features

### 🔐 Authentication & Authorization
- **Laravel Sanctum** token-based authentication
- **Role-based access control** (Admin/Customer)
- Secure registration, login, and logout
- Protected API endpoints

### 🛍️ E-commerce Core
- **Product Management** with categories, pricing, and stock tracking
- **Advanced Cart System** - one active cart per customer with multiple items
- **Order Processing** with status management and payment integration
- **Inventory Management** with stock availability checks

### 🏗️ Architecture
- **Service Layer Pattern** for business logic separation
- **Repository Pattern** for data access abstraction
- **Form Request Validation** for input sanitization
- **API Response Trait** for consistent JSON responses
- **Custom Middleware** for stock availability and role checks

### 🚀 Performance & Scalability
- **Caching** for product listings
- **Queue System** for asynchronous notifications
- **Database Optimization** with proper indexing and relationships
- **Pagination** for large datasets

### 🧪 Testing & Quality
- **Feature Tests** for API endpoints
- **Unit Tests** for business logic
- **Pest Testing Framework** integration
- **Code Quality** with Laravel Pint

## 🛠️ Tech Stack

- **Framework**: Laravel 12.x
- **PHP**: ^8.2
- **Database**: MySQL/PostgreSQL/SQLite
- **Authentication**: Laravel Sanctum
- **Testing**: Pest
- **Code Quality**: Pint, Pail
- **Frontend Build**: Vite
- **Queue**: Redis/Database

## 📋 Requirements

- PHP ^8.2
- Composer
- Node.js 18+
- MySQL/PostgreSQL/SQLite
- Redis (optional, for queues)

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/ahmetbulbul0/E-Commerce-Order-Management-System-Laravel.git
cd E-Commerce-Order-Management-System-Laravel
```

### 2. Install Dependencies
```bash
# PHP dependencies
composer install

# Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Generate Sanctum key
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## 🗄️ Database Setup

### 1. Configure Database
Update `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Run Migrations & Seeders
```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Or step by step
php artisan migrate
php artisan db:seed
```

### 3. Start Development Server
```bash
# Using Laravel's built-in server
php artisan serve

## 🌱 Seeded Data

The application comes with comprehensive test data:

- **👥 Users**: 2 admins + 10 customers
- **📦 Categories**: 5 product categories
- **🛍️ Products**: 20 products with varied pricing
- **🛒 Carts**: 10 active carts with multiple items
- **📋 Orders**: 15 orders with payment records

### Default Admin Credentials
- **Email**: `admin1@example.com` / `admin2@example.com`
- **Password**: `password`

## 🔐 Authentication

### Registration
```bash
POST /api/v1/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Login
```bash
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

### Using Tokens
Include the token in the Authorization header:
```bash
Authorization: Bearer {your-token-here}
```

## 📡 API Endpoints

### 🔐 Authentication (`/api/v1/auth`)
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/register` | User registration | ❌ |
| POST | `/login` | User login | ❌ |
| POST | `/logout` | User logout | ✅ |
| GET | `/me` | Get current user | ✅ |

### 📂 Categories (`/api/v1/categories`)
| Method | Endpoint | Description | Auth Required | Role |
|--------|----------|-------------|---------------|------|
| GET | `/` | List categories | ❌ | - |
| POST | `/` | Create category | ✅ | Admin |
| PUT | `/{id}` | Update category | ✅ | Admin |
| DELETE | `/{id}` | Delete category | ✅ | Admin |

### 🛍️ Products (`/api/v1/products`)
| Method | Endpoint | Description | Auth Required | Role |
|--------|----------|-------------|---------------|------|
| GET | `/` | List products | ❌ | - |
| GET | `/{id}` | Show product | ❌ | - |
| POST | `/` | Create product | ✅ | Admin |
| PUT | `/{id}` | Update product | ✅ | Admin |
| DELETE | `/{id}` | Delete product | ✅ | Admin |

**Query Parameters for Product Listing:**
- `per_page` - Items per page (default: 15)
- `category_id` - Filter by category
- `search` - Search by name
- `min_price` - Minimum price filter
- `max_price` - Maximum price filter

### 🛒 Cart (`/api/v1/cart`)
| Method | Endpoint | Description | Auth Required | Role |
|--------|----------|-------------|---------------|------|
| GET | `/` | Get active cart | ✅ | Customer |
| POST | `/items` | Add item to cart | ✅ | Customer |
| PUT | `/items/{productId}` | Update item quantity | ✅ | Customer |
| DELETE | `/items/{productId}` | Remove item from cart | ✅ | Customer |
| DELETE | `/` | Clear cart | ✅ | Customer |

**Cart Item Structure:**
```json
{
    "id": 1,
    "user_id": 1,
    "status": "active",
    "items": [
        {
            "id": 1,
            "product_id": 1,
            "quantity": 2,
            "product": {
                "id": 1,
                "name": "Product Name",
                "price": 99.99
            }
        }
    ]
}
```

### 📋 Orders (`/api/v1/orders`)
| Method | Endpoint | Description | Auth Required | Role |
|--------|----------|-------------|---------------|------|
| POST | `/` | Create order from cart | ✅ | Customer |
| GET | `/` | List user orders | ✅ | Customer |
| PUT | `/{id}/status` | Update order status | ✅ | Admin |
| POST | `/{id}/payment` | Process payment | ✅ | Customer |

### 💳 Payments (`/api/v1/payments`)
| Method | Endpoint | Description | Auth Required | Role |
|--------|----------|-------------|---------------|------|
| GET | `/payments/{id}` | View payment | ❌ | - |

## 🧪 Testing

### Run All Tests
```bash
# Run tests with Pest
php artisan test

# Run with coverage
php artisan test --coverage
```

### Test Categories
- **Feature Tests**: API endpoint testing
- **Unit Tests**: Service layer testing
- **Integration Tests**: Database and external service testing

### Test Coverage
- **Controllers**: 85%+ coverage
- **Services**: 90%+ coverage
- **Models**: 80%+ coverage

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/          # API Controllers
│   ├── Middleware/           # Custom middleware
│   └── Requests/             # Form request validation
├── Models/                   # Eloquent models
├── Services/                 # Business logic layer
├── Repositories/             # Data access layer
├── Traits/                   # Reusable traits
└── Notifications/            # Email notifications

database/
├── migrations/               # Database migrations
├── factories/                # Model factories
└── seeders/                  # Database seeders

routes/
└── api/                      # Modular API routes
    ├── auth.php
    ├── category.php
    ├── product.php
    ├── cart.php
    └── order.php

tests/
├── Feature/                  # Feature tests
└── Unit/                     # Unit tests
```

## 🚀 Development

### Available Commands
```bash
# Development server
composer run dev

# Run tests
composer run test

# Code formatting
composer run format

# Code analysis
composer run analyze
```

### Code Standards
- **PSR-12** coding standards
- **4-space indentation**
- **Thin controllers** using services
- **Repository pattern** for data access
- **Form requests** for validation
- **API response traits** for consistency

### Database Migrations
```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback
```

### Queue Processing
```bash
# Process queued jobs
php artisan queue:work

# Process specific queue
php artisan queue:work --queue=emails
```

## 📚 Additional Resources

- **Postman Collection**: Import `docs/postman_collection.json`
- **Laravel Documentation**: [laravel.com/docs](https://laravel.com/docs)
- **Sanctum Documentation**: [laravel.com/docs/sanctum](https://laravel.com/docs/sanctum)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Follow coding standards
4. Write tests for new features
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Built with ❤️ using Laravel 12.x**