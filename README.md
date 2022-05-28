# Inisev SSP Task

## Introduction
Create a simple subscription platform(only RESTful APIs with MySQL) in which users can subscribe to a website (there can be multiple websites in the system). Whenever a new post is published on a particular website, all it's subscribers shall receive an email with the post title and description in it. (no authentication of any kind is required)


## Table of Contents
1. <a href="#technology-stack">Technology Stack</a>
2. <a href="#application-features">Application Features</a>
3. <a href="#api-endpoints">API Endpoints</a>
4. <a href="#setup">Setup</a>
5. <a href="#author">Author</a>
6. <a href="#license">License</a>


## Technology Stack
  - [PHP](https://www.php.net)
  - Javascript
  - [Laravel](https://laravel.com)
  - [MySQL](https://www.mysql.com)

## Application Features
- Endpoint to create a "post" for a "particular website".
- Endpoint to make a user subscribe to a "particular website" with all the tiny validations included in it.
- Command that sends email to the subscribers.

## API Endpoints
Method | Route | Description
--- | --- | ---
`POST` | `/api/websites/:id/post` | Add a post for a website
`POST` | `/api/websites/:id/subscribe` | Subscribe a user to a website

## Setup
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.
  #### Getting Started
  - git clone https://github.com/steelze/inisev.git
  - Set up the laravel project
    ```
    $ git clone https://github.com/steelze/inisev.git
    $ cd eskimi
    $ cp .env.example .env
    ```
  #### Run Migration
    $ php artisan migrate --seed
    $ Serve up application
 
  
## Author
Odunayo Ileri Ogungbure

## License
ISC
