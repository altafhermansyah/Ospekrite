# Ospekrite

Welcome to Ospekrite! This is a modern, high-performance marketplace designed specifically for handling university orientation gear distribution. 

If you are a new developer joining the team, please read through the `docs/` folder to understand the architecture, business rules, and security paradigms before writing any code.

---

## 📚 Comprehensive Documentation
- [01. Overview & Architecture](docs/01-overview.md)
- [02. Database Schema & ERD](docs/02-database.md)
- [03. System Architecture (Services/Actions)](docs/03-architecture.md)
- [04. Business Flow & Concurrency](docs/04-business-flow.md)
- [05. User Flow & UX](docs/05-user-flow.md)
- [06. Order State Machine](docs/06-order-state-machine.md)
- [07. Payment Flow (QRIS Statis/Dynamic)](docs/07-payment-flow.md)
- [08. Security Architecture](docs/08-security.md)
- [09. Routes & Endpoints](docs/09-routes-and-endpoints.md)
- [10. Testing Guide](docs/10-testing-guide.md)
- [11. Project Roadmap](docs/11-roadmap.md)

---

## 🚀 Getting Started (Local Setup)

Follow these steps strictly to get your local environment running.

### 1. Clone the Repository
```bash
git clone https://github.com/your-org/ospekrite.git
cd ospekrite
```

### 2. Install Dependencies
```bash
composer install
npm install
npm run build
```

### 3. Environment Setup
Copy the `.env.example` file to create your local `.env`.
```bash
cp .env.example .env
php artisan key:generate
```
Update your `.env` file with your local database credentials (e.g., Laragon/XAMPP):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ospekkit
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Setup
If you are starting fresh, run the migrations and seeders to populate mock products and bundles:
```bash
php artisan migrate:fresh --seed
```
*Note: If you already have a populated database dump from a previous developer, simply import it via your SQL client instead.*

### 5. Start the Server
```bash
php artisan serve
```
Visit `http://127.0.0.1:8000` in your browser.

---

## ⚠️ Important Warnings for Developers

1. **Never use `RefreshDatabase` in Tests without checking `phpunit.xml`:** Always ensure `<env name="DB_CONNECTION" value="sqlite"/>` is uncommented in `phpunit.xml` before running tests, otherwise you will wipe your local MySQL development database!
2. **Never Touch Sessions in Actions:** Classes in `app/Actions` (like `CreateOrderAction`) must remain completely stateless. Any interaction with cookies or sessions must happen in `Controllers` or `Services` (like `CartService`).
3. **Database Transactions are Mandatory:** Any operation that touches multiple tables or involves stock deduction MUST be wrapped in `DB::transaction()`.
4. **Use `lockForUpdate`:** When dealing with stock verification, ALWAYS use pessimistic locking to prevent race conditions during high-traffic "war ticket" events.

---

## 🌿 Branching Strategy

- `main` : Production-ready code only.
- `develop` : Default branch for integration.
- `feature/*` : Create a feature branch for any new stage (e.g., `feature/stage-9-admin`). 
- `hotfix/*` : For emergency production bugs.

Welcome to the team! 🎉
