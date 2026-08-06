# AdminArea Views Documentation

## Structure Overview
All admin views are located at `app/Views/AdminArea/` and organized by feature:

### Directory Structure
- `dashboard/` - Main dashboard views
  - `index.php` - Main admin dashboard (stats, charts, recent activity)
  - `customers.php` - Customer management list
  - `products.php` - Product management list
  - `orders.php` - Order management list
  - `invoices.php` - Invoice management list
  - `payments.php` - Payment management list
  - `services.php` - Services management list
  - `portfolio.php` - Portfolio management list
  - `reports.php` - Reports dashboard with charts
  - `settings.php` - Settings form
  - `media.php` - Media manager list
  - `support.php` - Support tickets list
  - `support_create.php` - Create ticket form
  - `support_detail.php` - Ticket detail view

- `cms/` - CMS management views
  - `index.php` - CMS dashboard
  - `pages.php` - Pages management list
  - `page_form.php` - Page create/edit form
  - `articles.php` - Articles management list
  - `article_form.php` - Article create/edit form
  - `categories.php` - Categories management list
  - `tags.php` - Tags management list

- `Testimonial/` - Testimonials management
  - `index.php` - Testimonials list
  - `form.php` - Testimonial create/edit form

## View Variables
All views share common variables passed from controllers:
- `$title` - Page title
- `$stats` - Statistics array
- `$pager` - Pagination object (where applicable)

## Controller Mapping
- `AdminDashboardController` - Main dashboard (routes: /admin/dashboard, /admin/customers, etc.)
- `CMSDashboardController` - CMS management (routes: /admin/cms/*)
- `MediaController` - Media management (routes: /admin/media)
- `TicketController` - Support tickets (routes: /admin/support*)
- `TestimonialController` - Testimonials (routes: /admin/testimonials*)

## Navigation
All views include a consistent sidebar navigation with active state highlighting based on the `$page` or route.
