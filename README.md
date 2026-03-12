# Local Event Discovery Platform

A multi-application event discovery and management system built with **Laravel 11**, **Tailwind CSS**, and **Vite**. The platform enables users to browse and favorite local events, organizers to create and manage events, and administrators to oversee the entire system.

## Architecture

The project is composed of three Laravel applications sharing a single database:

| Application | Port | Purpose |
|-------------|------|---------|
| **front-app** | 8080 | Public-facing web UI for users and organizers |
| **api-app** | 8090 | RESTful API for mobile/external clients |
| **back-app** | 8091 | Admin control panel |

```
LocalEventDiscoveryPlat/
├── front-app/      # User-facing web application
├── api-app/        # REST API backend
├── back-app/       # Admin dashboard
└── database/       # Shared migrations
```

## Features

### Users
- Register/login with session-based (web) or token-based (API) authentication
- Browse, search, and filter events by category, price, and date
- Save favorite events
- Profile management and password reset via email

### Organizers
- Register/login with company and business details
- Create, edit, and delete events (with image uploads)
- View and manage own events
- Profile management and password reset

### Administrators (back-app)
- Dashboard with real-time stats, monthly/daily trend charts (Chart.js)
- Manage users and organizers (view details, ban/unban)
- Manage events (view, filter, soft-delete)
- Manage event categories (CRUD)
- Admin profile and password management

### API (api-app)
- Full RESTful API with Sanctum token authentication
- Separate endpoints for users, organizers, and admins (`/api/user/*`, `/api/organizer/*`, `/api/admin/*`)
- Public endpoints for browsing events and categories
- Rate-limited auth endpoints (5 login / 10 register requests per minute)
- Contact form endpoint

## Tech Stack

- **Framework:** Laravel 11.31
- **PHP:** 8.2+
- **Authentication:** Laravel Sanctum (tokens for API, sessions for web)
- **Frontend:** Blade templates, Tailwind CSS, Vite
- **Charts:** Chart.js (admin dashboard)
- **Email:** Brevo (Sendinblue) via `symfony/brevo-mailer`
- **Database:** MySQL (or SQLite for development)

## Database Schema

All three apps share the same database with the following tables:

| Table | Description |
|-------|-------------|
| `users` | Regular users (email, name, phone, DOB, ban status) |
| `organizers` | Event organizers (email, company info, business reg, ban status) |
| `user_admin` | Admin accounts |
| `events` | Event listings (title, description, dates, price, location, image; soft deletes) |
| `categories` | Event categories (Music, Business, Technology, Conference, Workshop, Seminar, Webinar) |
| `favorite_events` | User–event favorites (junction table) |
| `password_reset_tokens` | Token-based password reset (24-hour expiry) |
| `sessions` | Web session storage |
| `personal_access_tokens` | Sanctum API tokens |
| `cache` | Application cache |

## Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (or SQLite)
- MAMP / Valet / Herd or any local PHP server

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd LocalEventDiscoveryPlat
   ```

2. **Set up each application** (repeat for `front-app`, `api-app`, and `back-app`):
   ```bash
   cd front-app  # or api-app / back-app
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure the database**

   Update the `.env` file in each app to point to the same database:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=local_events
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. **Configure mail** (in each `.env`):
   ```dotenv
   MAIL_MAILER=brevo
   MAIL_HOST=smtp-relay.brevo.com
   MAIL_PORT=587
   MAIL_USERNAME=<your-brevo-email>
   MAIL_PASSWORD=<your-brevo-api-key>
   MAIL_FROM_ADDRESS=noreply@localevents.com
   MAIL_FROM_NAME="Local Events"
   ```

5. **Run migrations and seed** (only once, from any app):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build frontend assets** (for front-app and back-app):
   ```bash
   npm run build
   ```

## Running the Applications

Start each application on its designated port:

```bash
# Front-app (user-facing web)
cd front-app
php artisan serve --port=8080

# API app (REST API)
cd api-app
php artisan serve --port=8090

# Back-app (admin panel)
cd back-app
php artisan serve --port=8091
```

For development with hot-reloading (front-app and back-app):
```bash
npm run dev
```

## API Endpoints Overview

### Public
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/events` | List events (search, filter, sort) |
| GET | `/api/events/{id}` | Event details |
| GET | `/api/categories` | List categories |
| POST | `/contact/send` | Submit contact form |

### User (Bearer token required)
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/user/register` | Register |
| POST | `/api/user/login` | Login |
| GET | `/api/user/profile` | Get profile |
| PUT | `/api/user/profile` | Update profile |
| GET | `/api/user/favorites` | List favorites |
| POST | `/api/user/favorites` | Add favorite |
| DELETE | `/api/user/favorites/{id}` | Remove favorite |

### Organizer (Bearer token required)
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/organizer/register` | Register |
| POST | `/api/organizer/login` | Login |
| GET | `/api/organizer/events` | List own events |
| POST | `/api/organizer/events` | Create event |
| PUT | `/api/organizer/events/{id}` | Update event |
| DELETE | `/api/organizer/events/{id}` | Delete event |

### Admin (Bearer token required)
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/admin/login` | Login |
| GET | `/api/admin/dashboard` | Dashboard stats |
| GET | `/api/admin/users` | Manage users |
| POST | `/api/admin/users/{id}/toggle-ban` | Ban/unban user |
| GET | `/api/admin/organizers` | Manage organizers |
| GET | `/api/admin/events` | Manage events |
| POST | `/api/admin/categories` | Create category |

## Authentication

The platform uses a **multi-guard** authentication system:

- **Web apps** (front-app, back-app): Session-based authentication with separate guards for `user`, `organizer`, and `admin`
- **API** (api-app): Laravel Sanctum token-based auth with 7-day token expiry
- **Password reset**: Email-based with 24-hour token expiry; all existing tokens revoked on reset
- **Account moderation**: Ban/unban system enforced at login and via middleware

## Project Structure

```
front-app/
├── app/Http/Controllers/
│   ├── EventController.php        # Event CRUD, browse, search
│   ├── UserController.php         # User auth & profile
│   ├── OrganizerController.php    # Organizer auth & profile
│   ├── AuthController.php         # Login/logout handling
│   ├── FavoriteEventController.php
│   └── ContactController.php
├── resources/views/
│   ├── main/home.blade.php        # Homepage with carousel
│   ├── events/                    # Event listing & details
│   ├── auth/                      # Login, signup forms
│   ├── user/                      # User profile & favorites
│   └── org/                       # Organizer dashboard & event forms
└── routes/web.php

api-app/
├── app/Http/Controllers/
│   ├── UserAuthController.php
│   ├── OrganizerAuthController.php
│   ├── AdminAuthController.php
│   ├── EventController.php
│   ├── CategoryController.php
│   ├── FavEventController.php
│   └── ContactController.php
├── app/Http/Middleware/
│   ├── EnsureTokenIsUser.php
│   ├── EnsureTokenIsOrganizer.php
│   └── EnsureTokenIsAdmin.php
└── routes/api.php

back-app/
├── app/Http/Controllers/
│   ├── AdminAuthController.php
│   └── AdminController.php        # Dashboard, user/org/event management
├── resources/views/backend/
│   ├── overview.blade.php         # Dashboard with charts
│   ├── manageUser.blade.php
│   ├── manageOrganizer.blade.php
│   ├── manageEvent.blade.php
│   └── profile.blade.php
└── routes/web.php
```

## Testing

```bash
cd front-app  # or api-app / back-app
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
