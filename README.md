# Laravel Stock Quotes

## Table of Contents
- [Description](#description)
- [Features](#features)
- [Installation](#installation)
- [Dependencies](#dependencies)
- [License](#license)
- [Contributing](#contributing)
- [Author](#author)

## Description
Laravel Stock Quotes is a web application built with Laravel framework that allows users to retrieve historical stock quotes for a specific company symbol within a given date range. The application provides a user-friendly form where users can select a company symbol, start date, end date, and provide their email address. Upon form submission, the application retrieves the historical stock quotes, displays them in a table format, and sends an email to the user with the requested information.

## Features
- Select a company symbol from a list of available options.
- Choose a start date and end date for the historical quotes.
- Validate form inputs on the client and server-side.
- Display the historical quotes in a table format.
- Show a chart of the open and close prices based on the retrieved data.
- Send an email to the user with the requested information.

## Installation
1. Clone the repository: `git clone https://github.com/your-username/laravel-stock-quotes.git`
2. Navigate to the project directory: `cd laravel-stock-quotes`
3. Install composer dependencies: `composer install`
4. Copy the `.env.example` file to `.env`: `cp .env.example .env`
5. Generate an application key: `php artisan key:generate`
6. Update the `.env` file with your database credentials, RapidAPI key, and other necessary configuration.
7. Run migrations: `php artisan migrate`
8. Start the development server: `php artisan serve`
9. Access the application in your browser at `http://localhost:8000`.

## Dependencies
The Laravel Stock Quotes project utilizes the following major dependencies:
- Laravel Framework: The PHP web framework used for building the application.
- Bootstrap 5: CSS framework for styling the frontend.
- jQuery: JavaScript library for DOM manipulation and AJAX requests.
- jQuery UI: Library for providing datepicker functionality.
- Select2: jQuery-based replacement for select boxes with enhanced features.