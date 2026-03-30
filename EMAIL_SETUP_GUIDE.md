# 📧 Email Configuration Guide for E-Food

## Setup Gmail for Sending Order Confirmation Emails

### Step 1: Create Gmail App Password

1. **Go to your Google Account**
   - Visit: https://myaccount.google.com/

2. **Enable 2-Step Verification** (if not already enabled)
   - Go to Security → 2-Step Verification
   - Follow the setup process

3. **Generate App Password**
   - Go to: https://myaccount.google.com/apppasswords
   - Select "Mail" and your device
   - Click "Generate"
   - Copy the 16-character password (e.g., `abcd efgh ijkl mnop`)

### Step 2: Update .env File

Open your `.env` file and update these values:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop  # Your 16-char app password (no spaces)
MAIL_FROM_ADDRESS="noreply@e-food.com"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_ENCRYPTION=tls
```

**Important:**
- Replace `your-email@gmail.com` with your actual Gmail address
- Replace `your-16-character-app-password` with the app password you generated
- Remove spaces from the app password if any

### Step 3: Clear Config Cache

Run these commands in your terminal:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### Step 4: Test Email Configuration

Create a test route to verify email is working:

```php
// Add to routes/web.php temporarily
Route::get('/test-email', function() {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email from E-Food', function($message) {
            $message->to('your-email@gmail.com')
                    ->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

Visit: `http://127.0.0.1:8000/test-email`

## 🎯 How It Works

When a user completes an order:

1. **Order is created** in the database
2. **Telegram notification** is sent to admin
3. **Email confirmation** is automatically sent to the customer's Gmail
4. **Email includes:**
   - Order ID and date
   - List of products ordered
   - Payment method and status
   - Delivery address
   - Total amount
   - Link to view order details

## 📧 Email Template

The email template is located at:
```
resources/views/emails/order-success.blade.php
```

Features:
- ✅ Beautiful gradient design
- ✅ Khmer Battambang font
- ✅ Responsive layout
- ✅ Order details table
- ✅ Delivery information
- ✅ Call-to-action button
- ✅ Professional footer

## 🔧 Troubleshooting

### Email Not Sending?

1. **Check Gmail App Password**
   - Make sure you're using the app password, not your regular Gmail password
   - Ensure 2-Step Verification is enabled

2. **Verify .env Settings**
   ```bash
   php artisan config:clear
   ```

3. **Check Laravel Logs**
   ```
   storage/logs/laravel.log
   ```

4. **Test SMTP Connection**
   ```bash
   telnet smtp.gmail.com 587
   ```

### Common Errors

**Error: "Connection could not be established"**
- Check your internet connection
- Verify MAIL_HOST and MAIL_PORT in .env

**Error: "Authentication failed"**
- Double-check your app password
- Remove any spaces from the password

**Error: "Recipient address rejected"**
- Verify the user's email exists in the database
- Check email format is valid

## 📊 Queue Configuration (Optional)

For better performance, you can queue emails:

1. **Update .env:**
   ```env
   QUEUE_CONNECTION=database
   ```

2. **Run queue worker:**
   ```bash
   php artisan queue:work
   ```

3. **Update CheckoutController:**
   ```php
   Mail::to($order->user->email)->queue(new OrderSuccessMail($order));
   ```

## 🎉 Success!

When everything is set up correctly, users will receive a beautiful order confirmation email like this:

```
Subject: ✅ ការបញ្ជាទិញរបស់អ្នកត្រូវបានបញ្ជាក់ - Order #1

🎉 ការបញ្ជាទិញបានជោគជ័យ!
សូមអរគុណសម្រាប់ការបញ្ជាទិញរបស់អ្នក

សួស្តី [User Name],
ការបញ្ជាទិញរបស់អ្នកត្រូវបានបញ្ជាក់ហើយ...

[Order Details]
[Items Table]
[Total Amount]
[Delivery Info]
```

---

**Need Help?**
Check Laravel documentation: https://laravel.com/docs/mail
