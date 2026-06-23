# 11 Roadmap & Progress

## Finished Stages

- [x] **Stage 0:** Initial setup, basic models, mock data.
- [x] **Stage 1:** Product & bundle catalog, UI implementation.
- [x] **Stage 2:** Session-based shopping cart drawer.
- [x] **Stage 3:** Checkout page rendering and UI logic.
- [x] **Stage 4:** DTOs and Form Requests validation.
- [x] **Stage 5:** Core Transaction (`CreateOrderAction`) with row locks and idempotency.
- [x] **Stage 6:** QRIS Statis payment flow and proof upload.
- [x] **Stage 7:** Secure guest tracking timeline via Invoice & WhatsApp.
- [x] **Stage 8:** Order cancellation and automated 24-hour expiration scheduler.

## Upcoming Stages

### Stage 9: Admin Dashboard & Verification
- Implement login for committee members.
- Display table of orders requiring payment verification.
- Allow admins to mark orders as `lunas` (triggering stock deduction) or `ditolak` (triggering re-upload prompts).

### Stage 10: Logistics & Distribution
- Allow admins to transition orders from `lunas` -> `diproses` -> `siap_diambil`.
- Provide a QR code scanner interface for admins to instantly mark an order as `selesai` when the student picks up their package.

### Stage 11: Dynamic Payment Integration (Optional/Future)
- Integrate Midtrans / Xendit APIs.
- Replace manual upload form with auto-generated Virtual Accounts and dynamic QR codes.
- Implement webhooks to auto-verify payments.

### Stage 12: Notifications
- Integrate Fonnte or equivalent WhatsApp API.
- Send automated WhatsApp messages upon: Order Created, Payment Verified, Ready for Pickup.

## Production Readiness Requirements
Before deploying to production, the following must be done:
1. Setup **Redis** for sessions and cache to handle traffic spikes.
2. Setup **Laravel Horizon / Queues** for background tasks (email, WA notifications).
3. Ensure SSL/TLS is active.
4. Optimize database indexes on `no_invoice` and `idempotency_key`.
