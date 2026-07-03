# Ospekrite

Ospekrite is a modern, guest-checkout e-commerce marketplace built specifically to handle the ordering of university orientation (Ospek) kits. It features a frictionless purchasing flow, robust backend tracking, payment abstraction, and event-driven Telegram notifications.

## Key Features
- **Guest Checkout**: No user registration required. Authentication via Invoice Number + WhatsApp.
- **Hybrid Cart**: Supports individual variants and predefined bundles.
- **Stock Management**: Atomic stock deduction with database-level race condition locks.
- **Payment Flexibility**: Supports manual QRIS uploads and simulated Dynamic Webhook gateways.
- **Telegram Notifications**: Real-time updates pushed directly to the organizing committee's group chat.
- **Automated Expiration**: Background cron jobs cleanly manage unpaid reservations.

---

## 📂 Folder Structure

```
Ospekrite/
├── app/
│   ├── Actions/       # Complex business logic (CreateOrder, UploadBukti)
│   ├── Console/       # Scheduled tasks (ExpireOrders)
│   ├── Contracts/     # Interfaces (Notification, Payment)
│   ├── DTOs/          # Data Transfer Objects
│   ├── Enums/         # Strictly typed status definitions
│   ├── Http/          # Controllers, Requests, Middleware
│   ├── Models/        # Eloquent ORM
│   └── Services/      # External integrations (Telegram, Mock Gateway)
├── config/            # Custom config (notification.php, payment.php)
├── database/          # Migrations & Seeders
├── docs/              # 📚 Comprehensive Project Documentation
├── resources/         # Blade views and assets
└── routes/            # Web and API routing
```

---

## 🚀 Installation & Environment Setup

### 1. Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.x
- Node.js & NPM

### 2. Installation Steps

1. Clone the repository and install dependencies:
   ```bash
   composer install
   npm install && npm run build
   ```

2. Setup the environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure your Database in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ospekkit
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Run Migrations and Seeders (Populates dummy products):
   ```bash
   php artisan migrate:fresh --seed
   ```

5. Setup Storage Symlink (Required for uploaded QRIS proofs):
   ```bash
   php artisan storage:link
   ```

6. Start the local development server:
   ```bash
   php artisan serve
   ```

---

## 📱 Telegram Configuration

To receive real-time notifications when users create orders or pay, you must configure the Telegram driver. 

1. Open `.env` and add the following keys. **Never commit real tokens to version control!**
   ```env
   NOTIFICATION_DRIVER=telegram
   TELEGRAM_BOT_TOKEN=your_bot_token_here
   TELEGRAM_CHAT_ID=your_chat_id_here
   ```
   > **Note on Chat IDs:**
   > Use a positive number (e.g., `123456789`) for direct messages to the bot.
   > Use a negative number (e.g., `-100123456789`) for group chats where the bot is a member.

2. Clear your configuration cache so Laravel reads the new values:
   ```bash
   php artisan config:clear
   ```

*(If you leave `NOTIFICATION_DRIVER=dummy` or empty, the application will safely log notifications to `storage/logs/laravel.log` without failing).*

---

## ⚠️ Important Warnings

- **Local Development SSL Errors**: If you encounter `cURL error 60` locally when sending Telegram messages, it's due to local SSL certificate issues. We have implemented `Http::withoutVerifying()` in the Telegram Service specifically to bypass this locally. Do not use this in production.
- **Cron Jobs**: To test the expiration of unpaid orders, you must manually trigger the command `php artisan orders:expire` in your local terminal. In production, this must be added to the server's crontab.

---

## 📖 Further Reading

Please refer to the `docs/` directory for exhaustive documentation on architecture, flows, and state machines. Start with [`docs/01-overview.md`](docs/01-overview.md).
