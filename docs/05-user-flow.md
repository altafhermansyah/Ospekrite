# 05 User Flow & UX

## Overview
Ospekrite is designed to look like a premium, modern web application. It uses a clean interface with Inter typography, Bootstrap Icons, and Alpine.js for smooth micro-animations.

## Customer Journey Map

```mermaid
journey
    title Student Purchasing Ospek Gear
    section Discovery
      Visit Homepage: 5: Student
      Browse Catalog: 4: Student
      View Bundle Details: 5: Student
    section Selection
      Select Size Variant: 4: Student
      Add to Cart: 5: Student
      Open Cart Drawer: 5: Student
    section Checkout
      Fill Personal Info: 3: Student
      Select Faculty: 4: Student
      Submit Order: 5: Student
    section Post-Purchase
      Scan QRIS: 4: Student
      Upload Screenshot: 4: Student
      Track Order Status: 5: Student
```

## Page by Page Breakdown

### 1. Home (`/`)
- **Hero Section:** Large call-to-action, welcoming the new students.
- **Dynamic Catalog:** Grid of products and bundles fetched from the database.
- **Interactions:** Hover effects on cards, "Add to Cart" opens a side drawer seamlessly without reloading the page.

### 2. Product/Bundle Detail (`/produk/{id}` & `/bundle/{id}`)
- **Visuals:** Large product images, clear descriptions.
- **Selection:** Radio buttons or dropdowns for selecting variants (e.g., T-Shirt Size: S, M, L, XL).
- **Validation:** Cannot add to cart if a variant is not selected or out of stock.

### 3. Cart Drawer (Global Component)
- **UX:** Slides in from the right edge of the screen using Alpine.js transitions.
- **Features:** Allows adjusting quantities, removing items, and shows real-time subtotal calculations.
- **Action:** Clicking "Lanjut ke Checkout" redirects to `/checkout`.

### 4. Checkout (`/checkout`)
- **Review:** Displays final cart items and exact total.
- **Form:** Collects `nama_pembeli`, `nim`, `no_whatsapp` (validated via regex `^(\+62|08)[0-9]{8,12}$`), and `fakultas` (populated from config).
- **Submission:** On submit, the button goes into a loading state to prevent double clicks.

### 5. Payment (`/order/{invoice}/pembayaran`)
- **Display:** Shows the exact nominal to transfer and the static QRIS image.
- **Upload:** Provides a clean file input for uploading `.jpg`, `.png`, or `.pdf` proof of transfer.
- **Success:** Redirects to a success page indicating the admin is verifying the payment.

### 6. Tracking (`/track`)
- **Guest Authentication:** Requires entering the Invoice Number AND the exact WhatsApp number used during checkout.
- **Timeline:** Visual step-by-step progress bar (Pesanan Dibuat -> Diproses -> Siap Diambil -> Selesai).
- **Actions:** 
  - If `belum_bayar`: Shows "Batalkan Pesanan" and "Lanjut Pembayaran".
  - If `ditolak`: Shows "Upload Ulang Bukti".

### 7. Cancel / Expired
- **Cancel:** Users can cancel actively pending, unpaid orders. Triggers an Alpine.js confirmation modal.
- **Expired:** After 24 hours, the UI automatically reflects the expired state, hiding all payment buttons.
