# Testing Guide

This document outlines the current testing strategies. Because automated feature tests are slated for a future stage, testing is currently heavily manual.

## Manual Testing Scenarios

When developing locally or reviewing pull requests, execute the following flows:

### 1. Happy Path Checkout (QRIS Statis)
1. Navigate to `/`.
2. Add a Bundle to the cart.
3. Proceed to Checkout. Fill in dummy data. Select **QRIS Statis**.
4. Submit order.
5. On the payment page, upload any dummy image file (JPG/PNG < 2MB).
6. Verify redirect to the Tracking page.
7. Verify `status_payment` in the DB is `menunggu_validasi`.
8. Verify a Telegram notification "BUKTI PEMBAYARAN BARU" was received.

### 2. Happy Path Checkout (QRIS Dinamis)
1. Follow the steps above, but select **QRIS Dinamis** at Checkout.
2. Submit order. Verify redirect to the Mock Gateway Simulator (`/mock-payment/...`).
3. Click **Success**.
4. Verify redirect to the Tracking page.
5. Verify `status_payment` in DB is `lunas` and `status_order` is `diproses`.
6. Verify stock in `produk_varians` was atomically deducted.
7. Verify a Telegram notification "PEMBAYARAN DIVERIFIKASI" was received.

### 3. Idempotency Check
1. On the checkout form, open Chrome DevTools Network Tab.
2. Set network throttling to "Slow 3G".
3. Double-click the "Buat Pesanan" button very fast.
4. Verify that only ONE order is created in the database. The second request should gracefully redirect to the tracking page of the first order without throwing a SQL Error.

### 4. Expiration Cron Job
1. Create an order with QRIS Statis. Do not upload proof.
2. In the database, manually edit the `expired_at` timestamp of the new order to a date in the past (e.g., `2000-01-01`).
3. Open your terminal and run: `php artisan orders:expire`.
4. Verify the CLI output reports 1 order expired.
5. Refresh your DB: verify `status_order` is `batal` and `status_payment` is `expired`.
6. Verify Telegram received an "ORDER EXPIRED" notification.

### 5. Telegram Notification Failure Gracefulness
1. Open `.env` and intentionally corrupt your `TELEGRAM_BOT_TOKEN` (e.g. `TELEGRAM_BOT_TOKEN=invalid-token`).
2. Do NOT clear config (to simulate a sudden Telegram API outage). Wait, if you change `.env`, you must run `php artisan config:clear` so the system reads the invalid token.
3. Perform a checkout.
4. The checkout **must succeed** and redirect you to the payment page. It should NOT show a 500 Server Error.
5. Open `storage/logs/laravel.log`. Verify there is an error logged regarding the Telegram exception.

## Future Automated Tests (Stage 11B)
In Stage 11B, PHPUnit/Pest will be used to automate these manual flows using:
- `RefreshDatabase` for clean state.
- `Http::fake()` to mock the Telegram API and Payment Gateway HTTP calls.
