# Library Management System

## Overview

The Library Management System is a web application built with Laravel to manage books, users, borrowing records, and book ratings in a library. The system allows users to log in, manage books, borrow books, and rate the books they have borrowed.

## Key Features

- **Book Management**: Create, read, update, and delete books.
- **User Management**: Create, read, update, and delete users.
- **Borrow Records**: Manage book borrowing operations, including setting borrow and return dates.
- **Rating System**: Allow users to rate books they have borrowed and add reviews.
- **Book Filtering**: Search for books based on author, genre, and availability.

## Technologies Used

- **Laravel**: The framework used to build the application.
- **MySQL**: The database used for storing data.
- **JWT (JSON Web Tokens)**: For authentication using API tokens.
- **Eloquent ORM**: For managing data and interacting with the database.

## Installation and Setup

### 1. Clone the Repository

git clone <https://github.com/GhofranWarrakia/library-management-system>
cd <library-management-system>


### 2. Install Dependencies

composer install


### 3. Configure Environment

Copy the `.env.example` file to `.env` and update it with your database credentials.


cp .env.example .env


### 4. Generate Application Key


php artisan key:generate


### 5. Run Migrations


php artisan migrate


### 6. Start the Server


php artisan serve


## Usage

1. **Register and Log In:**

   Create a new user and log in using JWT tokens.

2. **Manage Books:**

   - **Add a New Book:** Go to `/books` and add book details.
   - **View Books:** Go to `/books` to view all books.
   - **Update and Delete Books:** Use `PUT` and `DELETE` methods on `/books/{id}`.

3. **Manage Borrow Records:**

   - **Borrow a Book:** Go to `/borrow-records` and add a borrowing record.
   - **Return a Book:** Use the `PUT` method to update the return date on `/borrow-records/{id}`.

4. **Rate Books:**

   - **Add a Rating:** Go to `/ratings` and submit your rating.
   - **View Ratings:** Use the `GET` method on `/books/{book_id}/ratings` to view ratings for a specific book.
   - **Update and Delete Ratings:** Use `PUT` and `DELETE` methods on `/ratings/{id}`.

5. **Filter Books:**

   Use the `GET` method on `/books` with parameters like `author`, `genre`, and `available` to filter books based on these criteria.

## Testing

You can test the Library Management System using the following methods:

1. **Laravel Unit Tests:**

   - **Run Unit Tests:**


     php artisan test
  

2. **API Testing:**

   - Use tools like Postman to test the API endpoints. Make sure to verify all CRUD operations for resources.

## Contributors

- [GHofran Warrakia] - Development and maintenance of the project.

## References

- [Laravel Documentation](https://laravel.com/docs)
- [JWT Documentation](https://jwt.io/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

## License

This project is licensed under the [[Focal X]].

