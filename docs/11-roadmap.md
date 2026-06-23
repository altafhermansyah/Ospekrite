# Development Roadmap

This document tracks the historical progress of Ospekrite and charts the course for future stages.

## Completed Stages

- [x] **Stage 0**: Initialization (Laravel 11, UI template setup)
- [x] **Stage 1**: Database schema creation (Categories, Products, Variants, Bundles)
- [x] **Stage 2**: Data Seeding & Product/Bundle display logic
- [x] **Stage 3**: Hybrid Session Cart implementation
- [x] **Stage 4**: Guest Checkout form & Database Transaction logic
- [x] **Stage 5**: Guest Tracking Portal with Invoice + WhatsApp authentication
- [x] **Stage 6**: QRIS Statis Manual Payment & Image Upload handling
- [x] **Stage 7**: Scheduled Cron Job for Order Expiration (`orders:expire`)
- [x] **Stage 8A**: Manual Order Cancellation by User
- [x] **Stage 8B**: Order Status UI polish on Tracking page
- [x] **Stage 9A**: Payment Abstraction Contracts
- [x] **Stage 9B**: Mock Dynamic QRIS Gateway Simulation
- [x] **Stage 10**: Notification Abstraction & Telegram Bot Integration

## Future Roadmap

The following stages dictate the future direction of the project. Priority should follow this sequence to ensure stability before scale.

### Stage 11A: Security Hardening
**Priority:** High
**Rationale:** Before real students use the system, we must audit rate limits (ThrottleRequests), ensure all uploads are strictly validated (MIME types, max sizes), and confirm no sensitive data leaks via debug modes.

### Stage 11B: Feature Tests
**Priority:** High
**Rationale:** The system is becoming complex. Manual testing is no longer sufficient. We must introduce automated PHPUnit/Pest tests covering cart math, stock deduction, and webhook handling.

### Stage 11C: Race Condition and Idempotency
**Priority:** Medium
**Rationale:** While we have basic `lockForUpdate` and `idempotency_key` implementations, we need to harden these. We should write specific concurrent tests to physically prove our DB locks hold up under stress.

### Stage 12: Production Readiness
**Priority:** Medium
**Rationale:** Swapping out local File cache/session for Redis. Integrating a real S3 bucket instead of local storage for uploaded payment proofs. Swapping Mock Gateway for real Midtrans/Xendit API keys.

### Stage 13: UX Polish
**Priority:** Low
**Rationale:** Adding micro-interactions, loading spinners during checkout, and refining mobile responsiveness to ensure a premium feel for the end-user.
