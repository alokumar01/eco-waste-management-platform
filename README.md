[![Laravel Basic CI](https://github.com/alokumar01/eco-waste-management-platform/actions/workflows/laravel-ci.yml/badge.svg)](https://github.com/alokumar01/eco-waste-management-platform/actions/workflows/laravel-ci.yml)

# Eco Compost Platform

A Laravel-based web application for promoting sustainable waste management and composting practices.

## Project Overview

This platform connects users with composting experts and waste management service providers. It also provides educational resources to encourage eco-friendly practices.

## Features

* User registration and login
* Role-based access (User, Expert, Admin)
* Service listing by experts
* Search and filter services by location and type
* Admin approval system for experts
* Educational blog/articles

## Tech Stack

* Laravel (PHP Framework)
* MySQL Database
* Blade Templates (Frontend)
* Bootstrap (UI)

## User Roles

### User

* Browse services
* Search & filter
* Learn composting

### Expert

* Register and get approved
* Add/manage services

### Admin

* Approve experts
* Manage platform

## Setup Instructions

1. Clone the repository:

   ```bash
   git clone https://github.com/alokumar01/eco-compost-platform.git
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Setup environment:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database in `.env`

5. Run migrations:

   ```bash
   php artisan migrate
   ```

6. Start server:

   ```bash
   php artisan serve
   ```

## Future Improvements

* Booking system
* Payment integration
* Ratings & reviews
* Mobile app version

## License

This project is for academic purposes.
