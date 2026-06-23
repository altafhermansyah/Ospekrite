# 10 Testing Guide

## Automated Testing

Laravel Feature tests are located in `tests/Feature`. 

**Warning:** If testing locally using `RefreshDatabase`, ensure your `phpunit.xml` is configured to use SQLite in-memory, otherwise your main development database will be wiped!
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

To run all automated tests:
```bash
php artisan test
```

### Key Automated Tests Implemented:
- `ExpireOrdersTest`: Verifies that orders past 24 hours are expired, active ones are skipped, and the command is safely idempotent.

## Manual Testing Scenarios

When developing new features, perform these manual regressions:

### 1. Happy Path Checkout
1. Add a Bundle and a Product to the cart.
2. Go to `/checkout`.
3. Enter valid details.
4. Submit. Ensure redirection to `/order/{invoice}/pembayaran` occurs.
5. Upload a mock `.jpg` receipt.
6. Verify redirection to success page.

### 2. Tracking Security Check
1. Go to `/track`.
2. Enter the generated Invoice but an *incorrect* WhatsApp number.
3. Assert that access is denied.
4. Enter the correct WhatsApp number.
5. Assert that access is granted and timeline shows correctly.

### 3. Cancellation Rules
1. On a newly created unpaid order, navigate to tracking.
2. Click "Batalkan Pesanan".
3. Assert status changes to "Dibatalkan".
4. Modify database `status_payment` to `lunas`.
5. Assert the "Batalkan Pesanan" button disappears (cannot cancel paid orders).

### 4. Concurrency (Race Condition)
1. Add a product with exactly 1 stock left to the cart.
2. Open two different browser profiles (or devices) to the checkout page.
3. Click "Checkout" at the exact same time.
4. Assert that one succeeds, and the other receives a stock error.
