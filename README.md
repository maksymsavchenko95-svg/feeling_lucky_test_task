# I'm Feeling Lucky

**Stack:** PHP 8.4, Laravel 13, PostgreSQL 18, Nginx, Docker Compose.

## Getting started

1. Clone the repository:

   ```bash
   git clone https://github.com/maksymsavchenko95-svg/feeling_lucky_test_task.git
   cd feeling_lucky_test_task
   ```

2. Build and start the containers:

   ```bash
   docker compose up -d --build
   ```

   On the first start, the `app` container automatically creates `.env`, installs Composer
   dependencies, generates the application key and runs the migrations.

   > [!NOTE]
   > This takes up to a minute after the containers are created. The app is ready when the
   > logs show `ready to handle connections`:
   >
   > ```bash
   > docker compose logs -f app
   > ```

3. Open http://localhost:8080.

## Running tests

```bash
docker compose exec app php artisan test
```

## Project structure

```
docker/                                     Docker configuration (PHP-FPM, Nginx)
compose.yml                                 Docker Compose services
app/                                        Laravel application
├── app/Http/Controllers/
│   ├── LinkController.php                  registration, link regeneration and deactivation
│   └── GameController.php                  game page, play and history
├── app/Http/Requests/RegisterRequest.php   registration validation
├── app/Models/                             User (link handling), GameResult
├── app/Services/GameService.php            game rules
└── tests/                                  unit and feature tests
```
