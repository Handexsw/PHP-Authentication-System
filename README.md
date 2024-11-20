# PHP Authentication System

A simple PHP authentication system with password hashing. This project is suitable for small web applications and training purposes.

## Functionality
- **Security:** Password storage using hashing.
- **Access Verification:**
  - Unregistered users are redirected from pages that require authorization.
  - Authorized users cannot return to login or registration pages.
- ** Ready to Integrate:** Simple addition to an existing project.

## Requirements 
- PHP 7.4+
- MySQL (or other compatible database)

## Installation
1. Change the login credentials for the database in the config.php file.
2. Dashboard.php only has a sample page where you can only log in with an account. If there is another insert <?php include 'isnotlogged.php' ?> 