#!/bin/bash
set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}=== CatSU GAD Application Startup ===${NC}"

# Wait for database to be available
echo -e "${YELLOW}Waiting for MySQL to be ready...${NC}"
MAX_ATTEMPTS=30
ATTEMPT=1
while [ $ATTEMPT -le $MAX_ATTEMPTS ]; do
    if php -r "new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));" 2>/dev/null; then
        echo -e "${GREEN}Database is ready!${NC}"
        break
    fi
    echo "Attempt $ATTEMPT/$MAX_ATTEMPTS: Waiting for database..."
    ATTEMPT=$((ATTEMPT + 1))
    sleep 2
done

if [ $ATTEMPT -gt $MAX_ATTEMPTS ]; then
    echo -e "${RED}Database connection failed after $MAX_ATTEMPTS attempts${NC}"
    echo "Starting application anyway - check logs for database errors"
else
    # Run migrations
    echo -e "${YELLOW}Running database migrations...${NC}"
    if php artisan migrate --force 2>&1; then
        echo -e "${GREEN}Migrations completed successfully${NC}"
        
        # Run seeders
        echo -e "${YELLOW}Seeding database...${NC}"
        if php artisan db:seed --force 2>&1; then
            echo -e "${GREEN}Seeders completed successfully${NC}"
        else
            echo -e "${YELLOW}Seeding had issues (may already be seeded)${NC}"
        fi
    else
        echo -e "${RED}Migration failed${NC}"
    fi
fi

echo -e "${GREEN}Starting Apache web server...${NC}"
exec apache2 -D FOREGROUND
