<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Task Laravel

### 1. Create a New Laravel Project
- Laravel version 8 or higher.
- Use SQLite database for simplicity.

### 2. Authentication System using Sanctum
- **/register** endpoint that validates and accepts:
  - Name
  - Phone number
  - Password
- **/login** endpoint.
- Both endpoints should return user data with an access token.
- Generate a random 6-digit verification code for every user.
- Log the code when generated.
- **/verify** endpoint to verify the code sent to the user.
- Only verified accounts can log in to the system.

### 3. Tags API Resource
- Authenticated users can:
  - View all tags.
  - Store new tags.
  - Update a single tag.
  - Delete a single tag.
- Tags should have unique names.

### 4. Posts API Resource
- Authenticated users can:
  - View only their posts.
  - Store new posts.
  - View a single post.
  - Update a single post.
  - Soft delete a single post.
  - View deleted posts.
  - Restore deleted posts.
- Posts have the following data:
  - Title (Required, max 255 characters)
  - Body (Required, string)
  - Cover image (Required for storing, optional for updating)
  - Pinned (Required, boolean)
  - One or more tags (Many-to-many relationship)
- Pinned posts should appear first for every user.
- All received data for storing and updating posts should be validated.

### 5. Jobs
- **Daily Job**: Force-delete all softly-deleted posts that are older than 30 days.
- **Six-hourly Job**: Make an HTTP request to `https://randomuser.me/api/` and log only the `results` object in the response.

### 6. Stats API Endpoint
- The endpoint should return:
  - Number of all users.
  - Number of all posts.
  - Number of users with 0 posts.
- The results should be cached and update with every update to the related models (User and Post).
