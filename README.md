# BookMart

BookMart is a **Laravel** web application for a **book marketplace** where users can **buy and sell books**. It supports **three roles**:

- **Buyer**
- **Seller**
- **Admin**

---

## Features

### Buyer

- Browse books with **search + filters** (condition, language, rating, price range, sorting)
- Book details page (reviews, recommendations, recently viewed)
- **Cart** (add/remove/clear)
- **Checkout + Orders** (place orders, view “My Orders”)
- **Wishlist**
- **Profile** update + profile photo upload
- **Addresses** (add/update/delete, set default)
- Account deletion request workflow (request/cancel)

### Seller

- Seller dashboard (listings, orders, earnings overview)
- Add/edit/delete book listings + **cover image upload**
- Toggle book availability (available/sold)
- Seller profile + avatar upload
- Update password
- View received orders

### Admin

- Admin dashboard
- Manage users (view, ban/unban)
- Manage books (view, approve/reject)
- Manage orders (view, update status)
- Manage categories (add/edit/delete)

---

## Tech stack

- **Backend**: Laravel (PHP)
- **Frontend tooling**: Vite + Node (dev/build assets)
- **Database**: MySQL (configured in `.env`)
- **Uploads**: stored on the `public` filesystem disk (`/storage/...`)

---

## Install & run (from ZIP)

### Requirements

- PHP 8.x + Composer
- Node.js + npm
- MySQL

### Setup

From the project root (the folder that contains `artisan`):

1. Install dependencies

```bash
composer install
npm install
```

1. Create `.env`

```bash
copy .env.example .env
```

Update these in `.env` (minimum):

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookmart
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public

ADMIN_NAME="BookMart Admin"
ADMIN_EMAIL=admin@bookmart.test
ADMIN_PASSWORD=admin12345
```

1. Generate app key

```bash
php artisan key:generate
```

1. Migrate database

Create the database (e.g. `bookmart`) in MySQL, then:

```bash
php artisan migrate
```

1. Seed data (categories + admin)

```bash
php artisan db:seed
```

If you only need the admin user:

```bash
php artisan db:seed --class=Database\\Seeders\\AdminUserSeeder
```

1. Enable image serving (important)

```bash
php artisan storage:link
```

### Run (development)

Start Laravel:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Start Vite in a second terminal:

```bash
npm run dev
```

Open:

- `http://127.0.0.1:8000`

---

## How to use

### Admin login

1. Open `/login`
2. Select **Admin**
3. Login with:
  - Email: `admin@bookmart.test`
  - Password: `admin12345`

Admin panel:

- `/admin/dashboard`

### Seller flow

- Register as Seller → open seller dashboard → add a book listing (optionally upload cover image)

### Buyer flow

- Register as Buyer → browse books → add to cart → checkout → view orders

---

## Troubleshooting

### Images not showing

Check:

- `APP_URL=http://127.0.0.1:8000`
- `FILESYSTEM_DISK=public`
- `php artisan storage:link`

Then refresh the page.