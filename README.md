# Ecommerce Capstone :money_mouth_face:
 *Capstone project for Village 88 - PHP Track*

### History
8/10/2022
1.  Added clickable prototype pages
2.  Stated enumerating features for ERD
8/14/2022
1. Finished initial clickable prototype
2. Started coding in CI
3. Created js/less/cdn helper function

## Overview of project
### What we want to do
1. Seller (Shops)
   1. To sell products
   2. To receive payments
   3. To be able to ship products
   4. To market products
   5. To feel secure with their account
2. Buyer
   1. To buy products
   2. To review products
   3. To ask about the products
   4. To receive products
   5. To feel secure with their account

### Enumerating features (Rough details)
1. Products
   - Overview
   - Categories
   - History
   - Inventory
   - Payment
   - Shipping
   - Reviews
2. Customers
   - Overview
   - Addresses
   - Profiles
   - History
3. Payments
   - Payment gateways
   - Storing
   - -History
4. Vendors (Optional)
5. Security
   - Auth
   - Other account security (Optional)
6. Orders
   - Order management
   - Order items
7. Checkout
8. Pricing
   - Prices
   - Adjustments
   - Currencies (Optional, use Peso for now)
   - Taxes (Optional, scope creep)
9.  Promotions (Optional, scope creep)
10. Shipping
   -Shipping methods

### ERD
![ERD 2nd Prototype Image](/references/Prototype-6.png)
Schema thought process:

## Progress

### **Clickable Prototype Pages for E-commerce Project**
1. [x] [Partials loginbar (Loaded by other page thru jQuery) (100% completed)](/clickable-prototype/Partials/loginbar.html)
2. [x] [Partials navbar_user (Loaded by other page thru jQuery) (100% completed)](/clickable-prototype/Partials/navbar_user.html)
3. [x] [Partials navbar_admin (Loaded by other page thru jQuery) (100% completed)](/clickable-prototype/Partials/navbar_admin.html)
4. [x] [Login Page (100% completed)](/clickable-prototype/Users/login.html)
5. [x] [Register Page (100% completed)](/clickable-prototype/Users/register.html)
6. [x] [Profile Page (100% completed)](/clickable-prototype/Users/profile.html)
7. [x] [Home Page (100% completed)](/clickable-prototype/Products/home.html)
8. [x] [Catalog page (100% completed)](/clickable-prototype/Products/catalog.html)
9. [x] [Product details page (100% completed)](/clickable-prototype/Products/show_products.html)
10. [x]  [Cart page (100% completed)](/clickable-prototype/Products/cart.html)
11. [x]  [Checkout page (100% completed)](/clickable-prototype/Products)
12. [x]  [Dashboard page (100% completed)](/clickable-prototype/dashboard.html)
13. [x]  [Products page (100% completed)](/clickable-prototype/)
14. [x]  [Order view page (100% completed)](/clickable-prototype/order_view.html)
15. [ ]  [Optional: Orders page (0% completed)](/clickable-prototype/)
16. [ ]  [Optional: Shipping page (0% completed)](/clickable-prototype/)

### Codeigniter progress
1. [x]  Home
2. [x]  LESS/JS/CDN Helper
3. [x]  Login
4. [x]  Registration
5. [x]  Profile
   1. [x]  Edit profile
   2. [x]  Change password
   3. [x]  Add/edit shipping address
   4. [x]  Add/edit billiin address
6. [ ]  Admin