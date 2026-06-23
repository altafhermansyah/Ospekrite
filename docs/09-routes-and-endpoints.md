# 09 Routes & Endpoints

## Customer Facing Routes (Guest)

All routes are web routes protected by standard `web` middleware (CSRF, Sessions).

| Method | URI | Controller Action | Purpose |
|---|---|---|---|
| GET | `/` | `HomeController@index` | Display landing page and catalog |
| GET | `/produk/{id}` | `ProductController@show` | Display single product detail |
| GET | `/bundle/{id}` | `BundleController@show` | Display bundle detail |
| GET | `/checkout` | `CheckoutController@index` | Render checkout form |
| POST | `/checkout` | `CheckoutController@process` | Submit order, create DB transaction |
| GET | `/order/{invoice}/pembayaran` | `PembayaranController@index` | Display static QRIS & upload form |
| POST | `/order/{invoice}/pembayaran` | `PembayaranController@upload` | Handle proof of payment upload |
| GET | `/order/{invoice}/pembayaran/sukses` | `PembayaranController@sukses` | Upload success page |
| GET | `/track` | `TrackingController@index` | Display verification form (Invoice + WA) |
| POST | `/track` | `TrackingController@cari` | Verify ownership and set secure session |
| GET | `/track/{invoice}` | `TrackingController@show` | Display secure order timeline & details |
| POST | `/order/{invoice}/cancel` | `TrackingController@cancel` | Handle order cancellation |

## Admin Routes (Future Stage 9)
Currently unbuilt, but will follow this structure:

| Method | URI | Controller Action | Middleware |
|---|---|---|---|
| GET | `/admin/dashboard` | `AdminDashboardController` | `auth, role:admin|dewa` |
| GET | `/admin/orders` | `AdminOrderController@index` | `auth, role:admin|dewa` |
| POST | `/admin/orders/{id}/verify` | `AdminPaymentController@verify` | `auth, role:admin|dewa` |

## Internal/System Commands

| Command Signature | Purpose | Scheduler |
|---|---|---|
| `php artisan orders:expire` | Expires unpaid orders older than 24 hours | Every 15 minutes |
