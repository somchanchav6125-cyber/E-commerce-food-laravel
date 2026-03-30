# Deploy Laravel to Vercel

This guide will help you deploy your Laravel Food Ecommerce project to Vercel.

## Prerequisites

- Node.js installed
- Vercel CLI installed (`npm install -g vercel`)
- Vercel account

## Deployment Steps

### 1. Build Frontend Assets

```bash
npm install
npm run build
```

### 2. Install PHP Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Generate App Key (if not already set)

```bash
php artisan key:generate
```

### 4. Login to Vercel

```bash
vercel login
```

### 5. Deploy to Vercel

```bash
vercel
```

For production deployment:

```bash
vercel --prod
```

## Environment Variables

Set these environment variables in your Vercel project dashboard:

1. Go to your Vercel project
2. Navigate to **Settings** → **Environment Variables**
3. Add the following variables:

| Variable | Value |
|----------|-------|
| `APP_NAME` | Food Ecommerce |
| `APP_ENV` | production |
| `APP_DEBUG` | false |
| `APP_KEY` | (your generated key) |
| `APP_URL` | (your vercel URL) |
| `DB_CONNECTION` | sqlite |
| `DB_DATABASE` | /tmp/database.sqlite |
| `SESSION_DRIVER` | array |
| `CACHE_DRIVER` | array |
| `QUEUE_CONNECTION` | sync |
| `LOG_CHANNEL` | errorlog |
| `BAKONG_MERCHANT` | your_account@bkrt |
| `BAKONG_MERCHANT_NAME` | Your Shop Name |
| `BAKONG_MERCHANT_CITY` | PHNOM PENH |

## Important Notes

### Database

Vercel is serverless, so traditional databases don't persist. Options:

1. **SQLite** - Stored in `/tmp` (temporary, cleared after deployment)
2. **External Database** - Use services like:
   - PlanetScale (MySQL)
   - Supabase (PostgreSQL)
   - AWS RDS
   - DigitalOcean Database

For external database, update environment variables:
```
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### File Storage

For persistent file storage, use:
- AWS S3
- DigitalOcean Spaces
- Cloudinary

Update `.env`:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket
```

### Sessions & Cache

Using `array` driver means sessions/cache are not persistent across requests. For production:
- Use Redis or database-backed sessions
- Use Redis or external cache service

## Testing Locally

To test the Vercel setup locally:

```bash
vercel dev
```

## Troubleshooting

### 500 Error

Check logs in Vercel dashboard:
```bash
vercel logs
```

### Missing Dependencies

Ensure all dependencies are in `composer.json` and `package.json`.

### Build Failures

Run build locally first:
```bash
npm run build
composer install --optimize-autoloader
```

## Useful Commands

```bash
# View deployment logs
vercel logs

# List deployments
vercel ls

# Remove deployment
vercel rm <deployment-url>

# Pull environment variables
vercel env pull
```

## Additional Resources

- [Vercel PHP Runtime](https://vercel.com/docs/runtimes#official-runtimes/php)
- [Laravel on Vercel Guide](https://vercel.com/guides/deploying-laravel-with-vercel)
- [Vercel CLI](https://vercel.com/docs/cli)
