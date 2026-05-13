# 🚀 Quick Start: Deploy CatSU GAD System to Railway.com

## 5-Minute Quick Setup

### Step 1: Prerequisites
```bash
# Install Railway CLI
npm install -g @railway/cli

# Install Laravel dependencies
composer install
```

### Step 2: Create Railway Account
Visit https://railway.app and sign up

### Step 3: Login to Railway
```bash
railway login
```

### Step 4: Deploy
```bash
# Option A: Automatic (Recommended)
bash deploy-railway.sh

# Option B: Manual
railway init
railway add  # Add MySQL plugin
railway up
```

### Step 5: Configure Environment Variables
In Railway Dashboard → Project → Variables, add:

```
APP_NAME=CatSU_GAD_System
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:[generate-with-command-below]
ANTHROPIC_API_KEY=[your-api-key]
```

Generate APP_KEY:
```bash
php artisan key:generate --show
```

### Step 6: View Application
```bash
railway logs
# Your URL will appear in logs like: https://xxx-production.railway.app
```

---

## Files Included for Railway Deployment

| File | Purpose |
|------|---------|
| **Procfile** | Specifies how Railway runs the app |
| **railway.json** | Railway configuration & build settings |
| **runtime.txt** | PHP version specification (8.2.12) |
| **Dockerfile** | Container configuration for Railway |
| **docker-compose.yml** | Local testing with MySQL |
| **.railwayignore** | Files to exclude from deployment |
| **RAILWAY_DEPLOYMENT.md** | Detailed deployment guide |
| **DEPLOYMENT_CHECKLIST.md** | Pre/post deployment checklist |
| **.env.railway** | Environment variable template |
| **deploy-railway.sh** | Automated deployment script |

---

## Database Setup

Railway automatically provides MySQL. To initialize:

```bash
# Run migrations and seeders
railway exec php artisan migrate --force
railway exec php artisan db:seed --force

# Or Procfile runs these automatically on first deploy
```

---

## Common Commands After Deployment

```bash
# View logs
railway logs -f

# SSH into container
railway shell

# Run artisan commands
railway exec php artisan [command]

# View environment
railway env

# Restart app
railway restart

# View deployments
railway deployments
```

---

## Troubleshooting

### App won't start
```bash
railway logs -f
# Check for migration errors or missing env vars
```

### Database connection error
```bash
railway shell
php artisan tinker
> DB::connection()->getPdo()
```

### File uploads not persisting
Use AWS S3:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=xxx
AWS_SECRET_ACCESS_KEY=xxx
AWS_BUCKET=xxx
```

### Need to reset database
```bash
railway exec php artisan migrate:fresh --seed
```

---

## Local Testing (Docker)

Test your app locally before deploying:

```bash
# Build and run
docker-compose up -d

# Access at http://localhost
# MySQL at localhost:3306

# View logs
docker-compose logs -f app

# Stop
docker-compose down
```

---

## Cost Estimate

| Service | Cost |
|---------|------|
| MySQL (Always On) | $15/month |
| Web Dyno | $5-10/month |
| Bandwidth | Included in plan |
| Storage | $0-5/month |
| **TOTAL** | **~$20-30/month** |

---

## Production Checklist

Before going live, verify:
- [ ] `APP_DEBUG=false`
- [ ] Strong database passwords
- [ ] API keys configured
- [ ] Email working
- [ ] Seeders ran
- [ ] Admin dashboard accessible
- [ ] All features tested
- [ ] Monitoring/alerts set up

---

## Next Steps

1. ✅ Deploy to Railway
2. ✅ Test all features
3. ✅ Configure custom domain (if needed)
4. ✅ Set up monitoring alerts
5. ✅ Document any custom configurations

---

**For detailed info**: See [RAILWAY_DEPLOYMENT.md](RAILWAY_DEPLOYMENT.md)  
**For full checklist**: See [DEPLOYMENT_CHECKLIST.md](DEPLOYMENT_CHECKLIST.md)
