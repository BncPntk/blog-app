# Simple Blog - Laravel 12 + Breeze + Inertia (Vue 3) + Tailwind + Sail

## Quick start

```bash
# copy env and boot containers
cp .env.example .env
./vendor/bin/sail up -d

# migrations + seeders
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

#  frontend
./vendor/bin/sail npm install
./vendor/bin/sail npm run de
```
#### Admin user:
Email: admin@admin.com

Password: admin


## Testing
```
./vendor/bin/sail artisan test
```
