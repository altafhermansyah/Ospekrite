# Business Flow

This document details the lifecycle of a user interaction within Ospekrite, from landing on the marketplace to completing an order.

## High-Level Flowchart

```mermaid
flowchart TD
    Start([User visits Website]) --> Browse[Browse Products & Bundles]
    Browse --> Detail[View Product Detail]
    Detail --> AddToCart{Select Variant & Add}
    AddToCart --> Cart[View Cart]
    Cart --> Checkout[Fill Checkout Form]
    
    Checkout --> Submit[Submit Order]
    Submit --> CheckType{Payment Type?}
    
    CheckType -->|QRIS Statis| StatisFlow[Show Manual QRIS Page]
    CheckType -->|QRIS Dinamis| DinamisFlow[Redirect to Payment Gateway]
    
    StatisFlow --> Upload[Upload Proof of Payment]
    Upload --> WaitValid[Admin Validates Proof]
    WaitValid -->|Rejected| Reupload[User Re-uploads]
    Reupload --> WaitValid
    WaitValid -->|Approved| Lunas[Status: Lunas]
    
    DinamisFlow --> Gateway[Gateway Processing]
    Gateway -->|User Pays| Webhook[Webhook Callback]
    Webhook --> Lunas
    
    Gateway -->|Timeout| GatewayExp[Gateway Expired]
    GatewayExp --> WebhookExp[Webhook Callback]
    WebhookExp --> Expired[Status: Expired / Batal]
    
    StatisFlow --> CronJob[Cron Job (24h limit)]
    CronJob -->|Not Paid| Expired
    
    Lunas --> Pack[Admin Packs Order]
    Pack --> Siap[Status: Siap Diambil]
    Siap --> Pickup[User Picks up Kit]
    Pickup --> Selesai([Status: Selesai])
```

## Edge Cases & Error Handling

### 1. Concurrent Checkouts (Race Conditions)
If two students try to checkout the last available T-Shirt size M at the exact same millisecond:
- `CreateOrderAction` uses a database transaction.
- It iterates through the cart items and uses `lockForUpdate()` on the `produk_varians` table.
- The second user's request is blocked at the database level until the first transaction finishes.
- If the first transaction takes the last stock, the second transaction evaluates the fresh stock, realizes it's insufficient, and cleanly throws an `Exception` preventing negative stock.

### 2. Network Timeouts (Idempotency)
If a user's internet lags while submitting the checkout, and they impatiently press the "Submit" button 3 times:
- The frontend generates a unique UUID `idempotency_key` upon page load.
- All 3 POST requests carry the exact same UUID.
- The `idempotency_key` column in the `orders` table has a `UNIQUE` database constraint.
- The first request creates the order. The 2nd and 3rd requests fail at the database level instantly, and the application catches this gracefully, redirecting the user to the tracking page of their existing order rather than charging them thrice.

### 3. Expiration Cleanup
If a user chooses QRIS Statis, decides they don't want to buy, and closes the browser:
- The stock remains locked (or theoretically reserved).
- The `php artisan orders:expire` cron job runs automatically.
- It finds orders past `expired_at` (24 hours).
- It changes the status to `batal` and importantly, calls `ReleaseStockAction` to restore the inventory for other students to buy.
