# Security Mechanisms

Security in Ospekrite is multi-layered, protecting against unauthorized data access, race conditions, and accidental duplicate billing.

## 1. CSRF (Cross-Site Request Forgery)
**What:** Laravel's `@csrf` token is enforced on all `POST`, `PUT`, `DELETE` requests.
**Why:** Prevents malicious external websites from submitting fake orders or uploading fake proof of payments on behalf of a logged-in session.

## 2. Strict Form Validation
**What:** `CheckoutRequest` and `TrackRequest` use strict Laravel validation rules.
**Why:** Ensures data integrity. For example, `payment_type` is restricted to `in:qris_statis,qris_dinamis` so a user cannot inject a non-existent payment gateway.

## 3. Idempotency Keys (Double Submit Prevention)
**What:** A UUID generated on the frontend is sent with the checkout form. The `orders` table has a unique constraint on `idempotency_key`.
**Why:** If a user clicks the "Submit" button multiple times due to a slow internet connection, only the first request succeeds. The subsequent requests hit a database constraint violation, which the controller catches and safely redirects the user to the already-created order tracking page.

## 4. Race Condition Prevention (`lockForUpdate`)
**What:** During checkout, when determining if enough stock is available, the code uses `DB::transaction()` and `->lockForUpdate()` on the `produk_varians` table.
**Why:** If 5 students try to buy the last 1 available T-Shirt at the exact same millisecond, they would all see `stock = 1` in a normal query and all 5 orders would succeed, causing negative stock (`-4`). By locking the rows, the database forces them to process sequentially. The first one takes the stock, and the other 4 will read `stock = 0` and be rejected.

## 5. DB Transactions
**What:** `DB::transaction()` is wrapped around `CreateOrderAction` and Webhook Callbacks.
**Why:** If creating the `order_details` fails halfway through, the entire `orders` row creation is rolled back. This prevents orphaned data and ensures atomicity.

## 6. Guest Tracking Ownership Validation
**What:** The tracking page cannot be accessed by simply visiting `/track/{invoice}`. The system uses a dedicated `GuestTrackingGuard`.
**Why:** Because there are no user accounts, the invoice number alone is not secure enough (someone could guess `OSP-2026-000001`). By requiring the user to input their `no_wa` (WhatsApp number) that matches the database record, we create a pseudo-authentication mechanism that protects the privacy of the student's name, email, and order details.
