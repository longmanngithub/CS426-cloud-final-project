# \[2.0.0\] -- Major UI Redesign, Security & Storage Upgrade

## Added

### Frontend

-   Active filtering for search and categories on the Events page.
-   Organizer guard and provider configuration in `config/auth.php`.
-   Route middlewares and protected routes.
-   Required field indicators (`*`) in user and organizer Sign Up forms.
-   Cancel button in profile edit pages.
-   Required field indicators in the Post Event form.
-   Filtering and sorting functionality on the Events page.
-   Tailwind CSS integration for UI styling.
-   Profile icon in the navigation bar.
-   Contact Us page.
-   Forgot password functionality.
-   Password visibility toggle.
-   Custom 404 error page.
-   Auto-dismiss success and error messages.
-   Loading states for login, sign up, and save actions.
-   Browse button when My Events or Favorite Events are empty.
-   Client-side validation.
-   Custom modal for deleting events.
-   Search, filter, sort, and category functionality in the Organizer My
    Events page.
-   Light/Dark theme support.
-   Brevo mailing service integration.
-   SMTP email server using Mailtrap.
-   Cloudflare R2 object storage.

### Backend

-   Tailwind CSS integration.
-   Integrated navigation bar.
-   Dashboard analytics graphs (pie, bar, and line charts).
-   Forgot password functionality.
-   SMTP email configuration using Mailtrap.
-   Mobile-friendly card layout for smaller screens.
-   Admin profile view page.
-   Password change functionality in admin profile.
-   User, organizer, and event detail pages.
-   Custom modals for delete and ban/unban actions.
-   Light/Dark theme support.
-   Brevo mailing service integration.
-   Cloudflare R2 object storage.

### API

-   API controllers and models aligned with frontend and backend.
-   Forgot password functionality.
-   SMTP email configuration using Mailtrap.
-   Brevo mailing service integration.
-   Cloudflare R2 object storage.

------------------------------------------------------------------------

## Changed

### Frontend

-   Redesigned all pages for improved UI/UX consistency.
-   Unified migration files across project folders.
-   Controllers now use guard-based authentication.
-   Updated validation rules in `UserController` and
    `OrganizerController`.
-   Event date/time logic now supports start and end date with start and
    end time.
-   Event price input now required (`0` represents free events).
-   Edit Event page now allows uploading new images without requiring
    image URL.
-   Replaced session authentication with Sanctum authentication.
-   Migrated file storage to S3-compatible storage.
-   Login redirect routes simplified (`/userhome` and `/orghome` →
    `/home`).

### Backend

-   Complete backend redesign to align with frontend UI.
-   Implemented server-side search.
-   Events now use soft deletes to prevent data inconsistencies in
    analytics charts.
-   Replaced session authentication with Sanctum authentication.
-   Migrated file storage to S3-compatible storage.

### API

-   Updated guards, providers, and Sanctum authentication configuration.
-   Migrated file storage to S3-compatible storage.

------------------------------------------------------------------------

## Fixed

### Frontend

-   Fixed organizer information incorrectly displaying user information
    in event pages.
-   Fixed event links on Home page redirecting to Events page instead of
    event detail page.
-   Fixed category navigation routing on Home page.
-   Fixed search functionality to be case-insensitive.
-   Fixed issue where deleted users remained logged in (now redirected
    to login).
-   Fixed inconsistent navbar across pages.
-   Fixed age calculation logic based on Date of Birth.
-   Fixed event image cropping issues.

### Backend

-   Updated delete logic so users are now banned instead of permanently
    deleted.

------------------------------------------------------------------------

## Removed

### Frontend

-   Body padding in About Us page.
-   "Explore More" button from Events page hero section.
-   Age field from Sign Up form and database.
-   Time component in Date of Birth column on profile page.
-   "View Details" button from Events page.

### Backend

-   Sidebar navigation.
-   Ability to directly edit users and events.
-   JavaScript-based search.

### API

-   `destroy` methods for user, organizer, and admin resources.
-   Admin ability to edit/delete users and organizers directly.
