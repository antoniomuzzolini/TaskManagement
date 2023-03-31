requirements
    docker, composer

install & run
    cp .env.example .env
    php artisan key:generate
    composer install
    vendor/bin/sail up
    vendor/bin/sail php artisan migrate:fresh --seed
    vendor/bin/sail npm install
    vendor/bin/sail npm run dev

navigation
    MAILHOG: http://localhost:8025
    APP: http://localhost/login
    project manager user: pm@example.com / password
    developer user: dev@example.com / password