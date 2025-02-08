# API for CRUD Operations with Authorization

This is my API with CRUD-operations and authorization in practice. 

`Created by Denis Zaitsev (ZIPZK-24-1)`

## Description

This API enables secure data management through fundamental CRUD operations with authorization. It supports multiple HTTP methods, including **POST**, **GET**, **DELETE**, and **PATCH**, for seamless interaction with the system.

## Operations

### POST (Create and Authenticate)
- **Register a new user**: Adds a new user to the system.
- **User login**: Authenticates an existing user with their credentials.

### GET (Retrieve Users)
- **Fetch all users**: Returns a list of all registered users.
- **Fetch a specific user**: Retrieves detailed information about a particular user.

### DELETE (Remove a User)
- **Delete a user**: Eliminates a user from the system using their unique identifier.

### PATCH (Modify User Data)
- **Update user details**: Modifies specific information of an existing user.

## Documentation

[API Documentation on Postman](https://documenter.getpostman.com/view/41658062/2sAYX8K25g)

## Usage
- **PHP**
- **JWT**

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/yourproject.git
2. Install dependencies (if applicable)
    ```bash
    composer install
3. Install jwt for your project (if you don't have it)
   ```bash
   php composer.phar require "lexik/jwt-authentication-bundle
`If you work in Windows then you should find php.ini (default: C:/tools/php84/php.ini)
and uncomment sodium (;extension=sodium -> extension=sodium)`

`Also in Windows you need to install OpenSSL`
