# Panduan Deployment Sumsel-Peduli

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- MySQL/MariaDB atau SQLite
- Node.js (untuk asset compilation)
- Git

## Instalasi Lokal

### 1. Clone Repository
```bash
git clone <repository-url>
cd sumsel-peduli
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan database connection:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sumsel_peduli
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migrations & Seeding
```bash
php artisan migrate --seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Deployment ke Production

### Opsi 1: Shared Hosting (cPanel/Plesk)

1. **Upload Files**
   - Upload semua file Laravel ke folder `public_html`
   - Pastikan folder `storage` dan `bootstrap/cache` writable

2. **Setup Database**
   - Buat database MySQL melalui cPanel
   - Import schema atau jalankan migrations

3. **Konfigurasi .env**
   - Update database credentials
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`

4. **Jalankan Migrations**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chmod -R 644 storage bootstrap/cache/*
   ```

### Opsi 2: VPS (Ubuntu/Debian)

1. **Install Dependencies**
   ```bash
   sudo apt update
   sudo apt install -y php8.2 php8.2-mysql php8.2-xml php8.2-mbstring composer nginx
   ```

2. **Clone Repository**
   ```bash
   cd /var/www
   git clone <repository-url> sumsel-peduli
   cd sumsel-peduli
   ```

3. **Install & Setup**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate --seed --force
   ```

5. **Configure Nginx**
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/sumsel-peduli/public;

       add_header X-Frame-Options "SAMEORIGIN" always;
       add_header X-Content-Type-Options "nosniff" always;
       add_header X-XSS-Protection "1; mode=block" always;

       index index.html index.htm index.php;

       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

6. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/sumsel-peduli
   sudo chmod -R 755 storage bootstrap/cache
   ```

7. **Enable SSL (Let's Encrypt)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

### Opsi 3: Docker

1. **Build Image**
   ```bash
   docker build -t sumsel-peduli .
   ```

2. **Run Container**
   ```bash
   docker run -d \
     -p 80:8000 \
     -e APP_KEY=base64:... \
     -e DB_HOST=db \
     -e DB_DATABASE=sumsel_peduli \
     -e DB_USERNAME=root \
     -e DB_PASSWORD=password \
     sumsel-peduli
   ```

## Backup & Maintenance

### Backup Database
```bash
php artisan backup:run
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Update Aplikasi
```bash
git pull origin main
composer install
php artisan migrate --force
npm run build
```

## Troubleshooting

### Error: SQLSTATE[HY000]: General error
- Pastikan file permission storage dan bootstrap/cache sudah benar
- Jalankan: `php artisan cache:clear`

### Error: Class not found
- Jalankan: `composer dump-autoload`

### Gambar tidak tampil
- Pastikan folder `storage/app/public` sudah di-link
- Jalankan: `php artisan storage:link`

## Kredensial Default

**Email:** admin@sumsel-peduli.com  
**Password:** password

*Ubah password setelah login pertama kali!*

## Support

Untuk bantuan lebih lanjut, silakan hubungi tim development.
