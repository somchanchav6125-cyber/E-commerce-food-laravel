# 🚀 Quick Start: Deploy to Vercel

## Step 1: Run Setup (Windows)

Double-click `vercel-setup.bat` or run in terminal:

```bash
vercel-setup.bat
```

This will:
- Install all dependencies
- Build frontend assets
- Generate app key
- Create necessary directories

## Step 2: Install Vercel CLI

```bash
npm install -g vercel
```

## Step 3: Login to Vercel

```bash
vercel login
```

## Step 4: Deploy

```bash
vercel
```

For production:

```bash
vercel --prod
```

## Step 5: Set Environment Variables

Go to your Vercel project dashboard → Settings → Environment Variables

Add these required variables:

| Variable | Value |
|----------|-------|
| `APP_KEY` | Your Laravel app key |
| `APP_URL` | Your Vercel URL |
| `BAKONG_MERCHANT` | Your Bakong merchant account |
| `BAKONG_MERCHANT_NAME` | Your shop name |
| `BAKONG_MERCHANT_CITY` | PHNOM PENH |

## 🎉 Done!

Your Laravel Food Ecommerce is now live on Vercel!

---

## 📋 File Structure Created

```
food-ecommerce/
├── api/
│   ├── index.php          # Vercel serverless entry point
│   └── bootstrap.php      # Laravel bootstrap for Vercel
├── .github/
│   └── workflows/
│       └── vercel-deploy.yml  # GitHub Actions CI/CD
├── vercel.json            # Vercel configuration
├── .vercelignore          # Files to exclude from deployment
├── vercel-setup.bat       # Windows setup script
├── vercel-setup.sh        # Linux/Mac setup script
├── .env.vercel            # Environment variables template
└── VERCEL_DEPLOYMENT.md   # Detailed deployment guide
```

## 🔗 Useful Links

- **Vercel Dashboard**: https://vercel.com/dashboard
- **Vercel CLI Docs**: https://vercel.com/docs/cli
- **Laravel on Vercel**: https://vercel.com/guides/deploying-laravel-with-vercel

## ⚠️ Important Notes

1. **Database**: Vercel is serverless. For persistent data, use external databases like:
   - PlanetScale (MySQL)
   - Supabase (PostgreSQL)
   - AWS RDS

2. **File Storage**: Use cloud storage like:
   - AWS S3
   - DigitalOcean Spaces
   - Cloudinary

3. **Sessions**: Currently using array driver (non-persistent). For production, consider:
   - Database sessions
   - Redis sessions

## 🐛 Troubleshooting

**500 Error?**
```bash
vercel logs
```

**Build fails?**
```bash
npm run build
composer install --optimize-autoloader
```

**Missing dependencies?**
Check `composer.json` and `package.json`

## 📞 Need Help?

Read the full guide: [VERCEL_DEPLOYMENT.md](./VERCEL_DEPLOYMENT.md)
