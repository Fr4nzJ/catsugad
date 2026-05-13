# Railway.com Deployment Guide

## Prerequisites

- Railway.com account (https://railway.app)
- Railway CLI installed (`npm i -g @railway/cli`)
- GitHub repository for the project
- MySQL database (Railway provides this)

## Environment Variables Required

Add these to Railway environment variables:

### Core Laravel Settings
```
APP_NAME=CatSU_GAD_System
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.railway.app
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

### Database (MySQL)
```
DB_CONNECTION=mysql
DB_HOST=${{ Mysql.PRIVATE_URL }}
DB_PORT=3306
DB_DATABASE=${{ Mysql.DATABASE }}
DB_USERNAME=${{ Mysql.USERNAME }}
DB_PASSWORD=${{ Mysql.PASSWORD }}
```

### Session & Cache
```
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### File Storage (use local or S3)
```
FILESYSTEM_DISK=local
# OR for AWS S3:
# FILESYSTEM_DISK=s3
# AWS_ACCESS_KEY_ID=your_key
# AWS_SECRET_ACCESS_KEY=your_secret
# AWS_DEFAULT_REGION=us-east-1
# AWS_BUCKET=your_bucket
```

### Anthropic API (for AI features)
```
ANTHROPIC_API_KEY=your_anthropic_api_key
```

### Email (Mailtrap or similar)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@catsugad.app
```

## Deployment Steps

### Option 1: Using Railway CLI

1. **Login to Railway**
   ```bash
   railway login
   ```

2. **Initialize Railway Project**
   ```bash
   railway init
   ```

3. **Add MySQL Database**
   ```bash
   railway add
   # Select MySQL
   ```

4. **Set Environment Variables**
   ```bash
   railway env:set APP_KEY=base64:xxxxx
   railway env:set APP_ENV=production
   railway env:set ANTHROPIC_API_KEY=your_key
   # ... add all other variables above
   ```

5. **Deploy**
   ```bash
   railway up
   ```

### Option 2: Using GitHub Integration

1. Push code to GitHub repository
2. Go to Railway.com dashboard
3. Click "New Project" → "Deploy from GitHub"
4. Select your repository
5. Railway auto-detects Laravel and uses Procfile
6. Add MySQL plugin
7. Set environment variables in Railway dashboard
8. Deploy automatically

## Important Notes

### Database Migrations
- The `Procfile` includes: `release: php artisan migrate:fresh --seed --force`
- This runs migrations and seeders automatically on every deployment
- **⚠️ WARNING**: `migrate:fresh` drops all tables. For production, use `migrate` instead:
  ```bash
  release: php artisan migrate --force
  ```

### File Storage
- Default uses local disk (`storage/app`)
- For production, consider AWS S3 or similar
- Local storage may be lost on container restarts

### Performance Optimization
```bash
railway exec php artisan optimize
railway exec php artisan view:cache
railway exec php artisan route:cache
railway exec php artisan config:cache
```

### Viewing Logs
```bash
railway logs
```

### SSH into Container
```bash
railway shell
```

## Troubleshooting

### Migration Errors
```bash
railway exec php artisan migrate --force
railway exec php artisan db:seed --force
```

### Clear Cache
```bash
railway exec php artisan cache:clear
railway exec php artisan view:clear
```

### Check Status
```bash
railway status
```

### Run Specific Command
```bash
railway exec "php artisan your:command"
```

## Post-Deployment

1. ✅ Test application: Visit `https://your-app-name.railway.app`
2. ✅ Check admin dashboard: `/admin`
3. ✅ Verify seeders ran: Check data in admin panel
4. ✅ Test authentication: Login with credentials
5. ✅ Monitor logs: `railway logs -f` (real-time)

## Scaling & Monitoring

- Railway provides automatic horizontal scaling
- Monitor from Railway dashboard
- Set deployment triggers for GitHub branches

## Cost Considerations

- Railway uses pay-as-you-go pricing
- MySQL database: $15/month base
- Web dyno: ~$5-10/month for typical usage
- Storage: Additional charges for large file uploads

## Security Best Practices

- ✅ Set `APP_DEBUG=false` in production
- ✅ Use strong `APP_KEY` (Laravel generates with `php artisan key:generate`)
- ✅ Store sensitive keys in Railway environment variables (never in git)
- ✅ Enable HTTPS (automatic with Railway)
- ✅ Regular database backups
- ✅ Update dependencies: `composer update`
