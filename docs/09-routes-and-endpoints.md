# Routes and Endpoints

This document catalogs the application's defined routes. Note that since Ospekrite is a monolithic Laravel application using Blade, most endpoints return HTML views rather than JSON, with the exception of specific API callbacks.

## Public User Routes (Marketplace & Checkout)

These routes are accessible by any guest user browsing the website.

| URL | Method | Controller | Middleware | Purpose |
|-----|--------|------------|------------|---------|
| `/` | GET | `HomeController@index` | `web` | Displays the landing page with categories, products, and bundles. |
| `/produk/{id}` | GET | `ProdukController@show` | `web` | Displays details of a specific product or bundle. |
| `/cart` | GET | `CartController@index` | `web` | Displays the user's current session cart. |
| `/cart/add` | POST | `CartController@add` | `web` | Adds an item to the session cart. |
| `/cart/remove` | POST | `CartController@remove` | `web` | Removes an item from the session cart. |
| `/checkout` | GET | `CheckoutController@index` | `web` | Displays the checkout form (requires cart items). |
| `/checkout` | POST | `CheckoutController@store` | `web` | Submits the order. Initiates the DB transaction. |

## User Tracking Routes (Secure)

These routes require the user to have placed an order and are protected by the custom Guest Tracking Guard.

| URL | Method | Controller | Middleware | Purpose |
|-----|--------|------------|------------|---------|
| `/track` | GET | `TrackingController@index` | `web` | Displays the login form asking for Invoice and WhatsApp number. |
| `/track` | POST | `TrackingController@store` | `web` | Validates credentials and injects verified status into session. |
| `/track/{invoice}` | GET | `TrackingController@show` | `web`, `cek.invoice` | Displays the detailed status of the order. |
| `/track/{invoice}/cancel` | POST | `TrackingController@cancel` | `web`, `cek.invoice` | Allows the user to manually cancel their order if unpaid. |
| `/pembayaran/{invoice}` | GET | `PembayaranController@index` | `web`, `cek.invoice` | Displays the QRIS Statis upload page. |
| `/pembayaran/{invoice}` | POST | `PembayaranController@upload` | `web`, `cek.invoice` | Processes the uploaded proof of payment image. |

## System & Mock Routes

These routes are used for backend system operations and gateway simulations.

| URL | Method | Controller | Middleware | Purpose |
|-----|--------|------------|------------|---------|
| `/mock-payment/{invoice}` | GET | `MockPaymentController@page` | `web` | Simulates a Midtrans/Xendit hosted checkout UI. |
| `/mock-payment/simulate` | POST | `MockPaymentController@simulate` | `web` | Triggers the webhook callback with SUCCESS/FAILED/EXPIRED status. |

## Admin Routes (Future Implementation)

Currently, there is no Admin Panel implemented. These routes will be established in future stages.

| URL | Method | Controller | Middleware | Purpose |
|-----|--------|------------|------------|---------|
| `/admin/*` | ANY | - | `auth`, `admin` | Planned for Stage 9B/10+ (Admin Panel). |
