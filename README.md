# Eco Waste Management Platform

[![Laravel Basic CI](https://github.com/alokumar01/eco-waste-management-platform/actions/workflows/laravel-ci.yml/badge.svg)](https://github.com/alokumar01/eco-waste-management-platform/actions/workflows/laravel-ci.yml)

A role-based Laravel web application that helps users connect with eco-friendly waste management and composting service providers. The platform supports service discovery, bookings, provider verification, blog-based awareness, customer reviews, notifications, messaging, and admin monitoring.


## Project Overview

This project is designed to promote responsible waste handling and sustainable living through a digital platform. It connects customers with service providers who offer composting, recycling, e-waste collection, and other waste management services.

The platform includes three main roles:

- `User`: browse services, book providers, make payments, review services, and save favorite providers
- `Provider`: complete profile, get verified by admin, create/manage services, manage bookings, track earnings, and publish blog posts
- `Admin`: verify providers, monitor platform activity, manage reviews, bookings, transactions, services, and blog articles

## Core Features

- User registration, login, password reset, and email verification
- Role-based access control for users, providers, and admins
- Provider profile completion and manual admin verification
- Service creation and management with images
- Public service listing with search and filtering
- Booking workflow with status updates
- Payment status tracking and transaction records
- Customer reviews and provider ratings
- In-app notifications and email notifications
- Messaging between customer, provider, and admin
- Educational blog module with categories and article preview
- Admin dashboard with platform statistics and moderation tools
- Eco impact tracking using completed booking waste data

## Booking Workflow

1. A customer browses available services.
2. The customer selects a service and creates a booking.
3. The provider accepts or cancels the booking.
4. The customer completes payment for an accepted booking.
5. The provider completes the service and records the waste amount handled.
6. The customer can submit a review after completion.

## Tech Stack

- `Laravel 13`
- `PHP 8.3`
- `Blade` templates
- `Tailwind CSS`
- `Vite`
- `SQLite/MySQL` compatible Laravel database setup
- `Pest` for automated testing

## Architecture Summary

The project follows Laravel MVC architecture:

- `Routes` define application endpoints and middleware protection
- `Controllers` handle business logic
- `Models` manage data and relationships
- `Blade Views` render the frontend
- `Migrations` define the database schema
- `Middleware` enforces role-based access and provider profile checks
- `Notifications` handle booking and service update alerts

## Main Modules

### Authentication Module

- Registration and login
- Password reset
- Email verification
- Profile management

### Provider Module

- Provider profile completion
- Admin verification flow
- Service CRUD operations
- Booking management
- Earnings dashboard
- Review overview
- Blog post management

### Customer Module

- Browse and filter services
- Create bookings
- Make payment
- View booking history
- Submit reviews
- Save providers
- Send messages

### Admin Module

- Dashboard analytics
- Provider verification
- Review moderation
- Booking and transaction monitoring
- Blog article moderation
- Service removal when required

## Database Entities

Main tables used in the project:

- `users`
- `services`
- `bookings`
- `transactions`
- `reviews`
- `messages`
- `notifications`
- `blog_posts`
- `saved_providers`

## Project Structure

```text
app/
  Http/Controllers/     Application logic
  Models/               Database models
  Middleware/           Access control and flow checks
  Notifications/        Email and database notifications

database/
  migrations/           Database schema definitions
  seeders/              Seed data

resources/
  views/                Blade frontend files
  css/                  Styles
  js/                   Frontend scripts

routes/
  web.php               Main web routes
  auth.php              Authentication routes

tests/
  Feature/              Feature tests
  Unit/                 Unit tests
```

## Local Setup

### Prerequisites

- PHP `8.3+`
- Composer
- Node.js and npm
- SQLite or MySQL

### Installation Steps

1. Clone the repository:

```bash
git clone https://github.com/alokumar01/eco-waste-management-platform.git
cd eco-waste-management-platform
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install frontend dependencies:

```bash
npm install
```

4. Create environment file:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`

6. Run migrations:

```bash
php artisan migrate
```

7. Create storage link:

```bash
php artisan storage:link
```

8. Start the development servers:

```bash
composer run dev
```

If you want to run them separately:

```bash
php artisan serve
npm run dev
```

## Testing

Run the automated test suite with:

```bash
php artisan test
```

Current project test coverage includes:

- authentication
- profile management
- provider dashboard behavior
- service creation access control
- booking and payment flow
- blog workflows
- admin dashboard actions
- static pages and support flow

## Educational Value

This project demonstrates:

- full-stack Laravel development
- role-based access control
- relational database design
- booking lifecycle management
- notification systems
- CRUD operations with validation
- dashboard-based analytics
- testing with Pest

## License

This project was developed for academic purposes.
