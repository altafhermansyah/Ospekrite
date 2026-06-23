# 08 Security Architecture

Security is heavily prioritized, particularly around data integrity and preventing unauthorized access to guest orders.

## 1. Concurrency & Race Conditions (`lockForUpdate`)
**The Threat:** If a jacket has 1 stock left, and two students click "Pay" at the exact same millisecond, standard SQL queries might read `stock=1` for both, resulting in negative stock (-1) and overselling.
**The Fix:** Inside `CreateOrderAction`, we use MySQL row-level locking:
```php
ProdukVarian::where('id_varian', $id)->lockForUpdate()->first();
```
This forces the database to serialize identical requests. The second request waits, sees `stock=0`, and gets cleanly rejected.

## 2. Double Submit Prevention (Idempotency)
**The Threat:** Users double-clicking the checkout button, or refreshing the page mid-submission, creating multiple identical orders and skewing statistics.
**The Fix:** The checkout form generates a unique UUID (`idempotency_key`) embedded in a hidden input. The `orders` table has a `UNIQUE` index on this column. If the same key arrives twice, Laravel catches the `DuplicateCheckoutException` and simply redirects the user to the first created invoice.

## 3. ACID Transactions (`DB::transaction`)
**The Threat:** The system successfully inserts the `orders` row but crashes before inserting `order_item` rows, leaving a corrupted, empty invoice in the database.
**The Fix:** All mutations happen inside `DB::transaction()`. If any exception is thrown, all queries roll back entirely.

## 4. Guest Order Ownership Verification
**The Threat:** Because there is no login, anyone could theoretically guess an invoice number (e.g., `OSP-2026-000001`) and view someone else's personal data (name, NIM, phone number).
**The Fix:** The `/track` endpoint acts as a gatekeeper. It requires both the `no_invoice` AND the exact `no_whatsapp` used during checkout. Once verified, a secure, cryptographically signed session variable (`session('verified_invoice')`) is set, allowing access to the detail page. Without this session, accessing the URL directly bounces the user back.

## 5. File Upload Protection
**The Threat:** Users uploading PHP scripts disguised as images to gain Remote Code Execution (RCE) on the server via the proof upload form.
**The Fix:** 
- Strict Laravel Validation: `mimes:jpg,jpeg,png,pdf|max:2048`
- Files are stored in the non-executable `storage/app/public` directory, ensuring they cannot be executed by the PHP interpreter even if bypassed.

## 6. CSRF & XSS
- **CSRF:** Every `POST` form utilizes Laravel's `@csrf` token to prevent Cross-Site Request Forgery.
- **XSS:** All blade outputs use `{{ $variable }}` which runs PHP's `htmlspecialchars` automatically, preventing Cross-Site Scripting injections. Raw output `{!! !!}` is strictly forbidden.
