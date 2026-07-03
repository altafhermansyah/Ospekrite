# Payment & Notification Flow

Ospekrite implements a flexible payment architecture designed to start manually and seamlessly upgrade to automated gateways in the future. Coupled with this is a robust notification abstraction system.

---

## Payment Flow

### QRIS Static (Manual)

```mermaid
sequenceDiagram
    participant User
    participant System
    participant Admin
    
    User->>System: Submit Checkout (QRIS Statis)
    System-->>User: Redirect to Payment Page (Show QR)
    User->>User: Scans QR with Banking App
    User->>System: Upload Screenshot (UploadBuktiAction)
    System->>System: status_payment = menunggu_validasi
    System->>Admin: Notification: Bukti Uploaded
    Admin->>System: Review Screenshot (Admin Panel)
    alt is valid
        System->>System: status_payment = lunas, status_order = diproses
    else is fake
        System->>System: status_payment = ditolak
        System-->>User: Please Re-upload
    end
```

### QRIS Dynamic (Automated Gateway)

```mermaid
sequenceDiagram
    participant User
    participant System
    participant Gateway (Midtrans/Mock)
    
    User->>System: Submit Checkout (QRIS Dinamis)
    System->>Gateway: createTransaction(Order)
    Gateway-->>System: Return Redirect URL
    System-->>User: Redirect to Gateway Page
    User->>Gateway: Completes Payment
    Gateway->>System: POST Webhook Callback (status: SUCCESS)
    System->>System: Verify Signature / Idempotency
    System->>System: Lock Rows, Deduct Stock, status = lunas
    System-->>Gateway: 200 OK
```

### Payment Abstraction

To ensure controllers don't need to change when switching providers, we use `PaymentServiceInterface`.
Currently, `MockDynamicPaymentService` implements this to simulate the webhook flow locally. When ready for production, we simply create `MidtransPaymentService` and swap the binding in `AppServiceProvider`.

---

## Notification Flow

Notifications to the organizing committee are strictly decoupled from the core business transaction. **Notifications must never break the business flow.** If Telegram servers are down, the student's order must still be successfully saved and processed.

### Supported Providers
- **`TelegramNotificationService`**: Uses Laravel's HTTP client (`Http::withoutVerifying()->post()`) to hit the Bot API.
- **`DummyNotificationService`**: Fallback for local environments, simply logs the message to `laravel.log`.
- **Future Support**: Ready for WhatsApp (Fonnte/Twilio) via the same `NotificationServiceInterface`.

### Failure Handling Architecture

```mermaid
sequenceDiagram
    participant Transaction (CreateOrderAction)
    participant NotificationService
    participant TelegramAPI
    participant DB
    
    Transaction->>DB: DB::transaction() start
    Transaction->>DB: Lock Variants & Insert Order
    Transaction->>DB: DB::commit()
    Transaction->>NotificationService: sendOrderCreated($order)
    
    alt Telegram API is UP
        NotificationService->>TelegramAPI: HTTP POST
        TelegramAPI-->>NotificationService: 200 OK
    else Telegram API is DOWN
        NotificationService->>TelegramAPI: HTTP POST
        TelegramAPI--xNotificationService: Timeout / 500 Error
        NotificationService->>NotificationService: Catch Exception
        NotificationService->>Log: Log::error(Exception)
    end
    
    NotificationService-->>Transaction: void return
    Transaction-->>User: Redirect to Tracking (Success)
```

As demonstrated, the `try-catch` block inside the Notification Service prevents the Exception from bubbling up to the Action, thereby saving the customer from encountering a 500 Server Error just because a background notification failed to send.
