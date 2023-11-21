# Project Title

Superior Crane Corp

## Table of Contents

-   [Introduction](#introduction)
-   [Features](#features)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)
-   [Contributing](#contributing)
-   [License](#license)

## Introduction

Superior Crane Corporation is a full-service design, engineering and manufacturing firm specializing in overhead material handling equipment and machining.

## Features

-   Creating Jobs
-   Rigger Tickets
-   Transportation Tickets
-   Search Filters
-   User Management
-   Role Based Authentication
-   Pay Duty Tickets
-   Generating PDF and Excel files
-   Signatures
-   Drafting Transportation Tickets

## Requirements

List any software dependencies, tools, or technologies that are required to run your project.

-   PHP version 7.4.33^
-   Composer 1.10.27
-   Laravel version 8.83.27
-   Database (MySQL)

## Installation

Provide step-by-step instructions on how to install your project.

1. Clone the repository: `git clone https://github.com/usamakhan143/superior-crane`
2. Install dependencies: `composer install`
3. Set up environment variables: `cp .env.example .env`
4. Generate application key: `php artisan key:generate`

## Configuration

Explain any configuration settings or environment variables that users need to set.

-   Database configuration:

    -   Setup your new database in MySql
    -   Configure your .env file.

    ```bash

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE="Your_database_name"
    DB_USERNAME="Your_username"
    DB_PASSWORD="Your_password"

    ```

    -   Migrate the migrations: `php artisan migrate`

-   Mail configuration

    Setup SMTP as your mailer in .env file. If you have paid account so you can configure based on your provider's configuration or you can use google SMTP as well.

    ```bash

    MAIL_MAILER=smtp
    MAIL_HOST="Your_host"
    MAIL_PORT="Your_port"
    MAIL_USERNAME="Your_email_address"
    MAIL_PASSWORD="Your_password"
    MAIL_ENCRYPTION="tls/ssl"
    MAIL_FROM_ADDRESS="Your_email_address"
    MAIL_FROM_NAME="Superior Crane"

    ```

## Usage

This project is totally based on backend APIs for the main Mobile App and Web App this is application is used by a crane company called Superior Crane.

### Running the Development Server

```bash
php artisan serve

```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
