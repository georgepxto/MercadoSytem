# GitHub Copilot Instructions for Food Market Management System

## Project Overview

This is a Laravel-based food market management system with the following core components:

### Models & Relationships

-   **Vendor**: Represents market vendors
    -   Has many `schedules` and `entries`
    -   Fields: name, contact_info, description
-   **Box**: Represents market stalls/boxes
    -   Has many `schedules` and `entries`
    -   Fields: name, location, size, description
-   **Schedule**: Weekly work assignments
    -   Belongs to `vendor` and `box`
    -   Fields: vendor_id, box_id, day_of_week, start_time, end_time
-   **Entry**: Check-in/check-out records
    -   Belongs to `vendor` and `box`
    -   Fields: vendor_id, box_id, entry_time, exit_time

### API Structure

All API endpoints follow RESTful conventions:

-   Base URL: `/api/`
-   Controllers in `app/Http/Controllers/Api/`
-   Return JSON responses with proper HTTP status codes
-   Include validation and error handling

### Frontend Architecture

-   Bootstrap 5.3.0 for styling
-   Blade templates with shared layout (`layouts/app.blade.php`)
-   Axios for API communication
-   CSRF protection enabled
-   Real-time updates using JavaScript intervals

## Development Guidelines

### When Creating New Features

1. **Models**: Use Eloquent relationships and follow naming conventions
2. **Migrations**: Include proper foreign keys and indexes
3. **Controllers**: Separate API and Web controllers
4. **Validation**: Use Laravel Form Requests or validate() method
5. **Views**: Follow Bootstrap responsive design patterns

### Code Style Preferences

-   Use descriptive variable names in both Portuguese and English (vendor names in Portuguese, code in English)
-   Follow Laravel naming conventions (PascalCase for models, camelCase for methods)
-   Include proper error handling and validation
-   Use Eloquent relationships instead of manual joins
-   Implement proper HTTP status codes in API responses

### Database Patterns

-   SQLite for development (configurable to MySQL/PostgreSQL)
-   Use migrations for all schema changes
-   Include seeders with realistic sample data
-   Proper foreign key constraints
-   Index frequently queried fields

### Frontend Patterns

-   Mobile-first responsive design
-   Bootstrap components and utilities
-   Consistent color scheme (blue/green gradient)
-   Bootstrap Icons for UI elements
-   Auto-refresh for real-time data (dashboard: 30s, check-in: 15s)

### API Response Format

```json
{
    "success": true,
    "data": {...},
    "message": "Success message"
}
```

For errors:

```json
{
    "success": false,
    "message": "Error message",
    "errors": {...}
}
```

### Testing Approach

-   Test API endpoints with realistic data
-   Verify CRUD operations work correctly
-   Check relationship queries
-   Validate form submissions
-   Test responsive design on different screen sizes

### Sample Data Context

The system includes Portuguese vendors (João Silva, Maria Santos, Pedro Costa, Ana Oliveira) working in a Brazilian food market context. When creating new sample data or features, maintain this cultural context.

### Performance Considerations

-   Use eager loading for relationships (`with()`)
-   Implement pagination for large datasets
-   Optimize database queries
-   Minimize JavaScript bundle size
-   Use appropriate HTTP caching headers

### Security Best Practices

-   CSRF protection on all forms
-   Input validation and sanitization
-   Use Eloquent ORM to prevent SQL injection
-   Implement proper authorization checks
-   Validate file uploads if added

## Common Tasks

### Adding a New Model

1. Create model with relationships
2. Create migration with proper fields and constraints
3. Add to seeder if needed
4. Create API controller with CRUD operations
5. Add routes to `routes/api.php`
6. Create/update frontend views if needed

### Adding a New API Endpoint

1. Add method to appropriate controller
2. Include validation
3. Return consistent JSON response format
4. Add route with proper HTTP verb
5. Update frontend JavaScript if needed

### Adding a New View

1. Create Blade template extending `layouts/app.blade.php`
2. Use Bootstrap components consistently
3. Include CSRF token in forms
4. Add JavaScript for API communication
5. Add route to `routes/web.php`
6. Update navigation in layout

## File Structure Reference

```
app/
├── Http/Controllers/
│   ├── Api/                 # API controllers
│   └── WebController.php    # Web interface
├── Models/                  # Eloquent models
database/
├── migrations/              # Database schema
├── seeders/                # Sample data
resources/views/
├── layouts/app.blade.php   # Main layout
├── dashboard.blade.php     # Dashboard
├── checkin.blade.php       # Check-in/out
├── vendors.blade.php       # Vendor management
├── boxes.blade.php         # Box management
└── entries.blade.php       # Entry history
routes/
├── api.php                 # API routes
└── web.php                 # Web routes
```

## Integration Points

-   Database: SQLite (configurable)
-   Frontend: Bootstrap + Blade templates
-   API: RESTful with JSON responses
-   Real-time: JavaScript polling
-   Styling: Bootstrap 5.3.0 with custom gradient theme
-   Icons: Bootstrap Icons
-   HTTP Client: Axios with CSRF protection

When making changes, ensure consistency with existing patterns and maintain the system's coherent architecture.
