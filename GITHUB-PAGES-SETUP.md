# Eco Kuku — GitHub Pages setup

This repository now includes a static website for GitHub Pages. GitHub Pages serves HTML, CSS and JavaScript; it does **not** run WordPress, PHP, or WooCommerce. This version uses WhatsApp enquiries rather than a checkout/payment gateway.

## Enable hosting
1. Open the repository: https://github.com/primemotors254-debug/ECO-KUKU
2. Go to **Settings → Pages**.
3. Under **Build and deployment → Source**, choose **GitHub Actions**.
4. Open **Actions**, select **Deploy Eco Kuku website to GitHub Pages**, and run it manually once if it has not already run. Future pushes to `main` will trigger deployment automatically.
5. Wait for the workflow to succeed. The repository's Pages settings or deployment job will show the published URL. For a project site it is usually `https://primemotors254-debug.github.io/ECO-KUKU/`, provided the account's Pages configuration permits it.

## Set the official contact details
Edit `assets/js/site-config.js`:
- `whatsappNumber`: digits only, international format, e.g. `2547XXXXXXXX` (replace Xs with the actual business number)
- `displayPhone`: approved public phone number
- `email`: approved public email
- `location`: approved business location

Save and commit the changes. Do not publish placeholder or unapproved contact details.

## Before announcing the site
- Replace generic stock photography with real, approved Eco Kuku farm/product photos or images you have permission to use.
- Verify the company story, business details, delivery areas, product range and all claims.
- Add actual products, specifications and current prices only after the business confirms them. Current site intentionally uses categories and enquiry calls to action, not fabricated stock/prices.
- Check all pages and WhatsApp links on mobile and desktop.
- Add privacy policy and terms if you collect personal information or expand order handling.
- If a custom domain is chosen, add it in **Settings → Pages → Custom domain**, configure the DNS records shown by GitHub, and enable HTTPS when available.

## Important limitations
- This is not a WordPress/WooCommerce installation and does not provide a dashboard, server-side database, inventory synchronisation, cart checkout, online payment processing or order records.
- Orders are manually discussed and confirmed on WhatsApp.
- GitHub Pages is public hosting; do not commit credentials, private customer information, or secret keys to the repository.
