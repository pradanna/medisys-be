# Gemini Context for Medisys Backend

## Project Overview
This project, `medisys-be`, is a backend application built with the Laravel framework. It serves as the API for a medical system.

## Architecture
The application follows a layered architecture to separate concerns:

- **Controllers** (`app/Http/Controllers`): Handle incoming HTTP requests, validate input (often using FormRequests), and return API responses. They delegate business logic to Services.
- **Services** (`app/Services`): Contain the core business logic of the application. They orchestrate operations and interact with Repositories.
- **Repositories** (`app/Repositories`): Responsible for data access logic and interaction with the database (Eloquent models). They implement interfaces defined in `app/Interfaces`.
- **DTOs** (`app/DTOs`): Data Transfer Objects used to pass structured data between layers (e.g., from Controller to Service, or Service to Repository).
- **Models** (`app/Models`): Eloquent ORM models representing database tables.

## Coding Standards & Conventions
- **PHP Version**: 8.x
- **Framework**: Laravel
- **Style**: Follows PSR-12 coding standards.
- **Type Hinting**: Use strict typing for method arguments and return types where possible.
- **API Responses**: Standardized JSON responses (often using `APIResponse` utility).
- **Pagination**: Handled via `PaginateResponse` utility.

## Key Directories
- `app/Http/Controllers`: API Controllers.
- `app/Services`: Business logic services.
- `app/Repositories`: Data access repositories.
- `app/Interfaces`: Interfaces for repositories and services.
- `app/DTOs`: Data Transfer Objects.
- `app/Models`: Database models.
- `routes`: Route definitions (`api.php` for API routes).

## Common Patterns
- **Dependency Injection**: Services and Repositories are injected into constructors.
- **Repository Pattern**: Database queries are encapsulated in repositories.
- **Service Pattern**: Complex business logic resides in services, keeping controllers thin.

## Example Workflow
1.  **Route**: Defined in `routes/api.php`.
2.  **Controller**: Receives request, maps to DTO (if applicable), calls Service.
3.  **Service**: Executes logic, calls Repository.
4.  **Repository**: Queries database, returns Model or Collection.
5.  **Controller**: Returns formatted JSON response.
