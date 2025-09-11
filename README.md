# Vehicle application

## How to set up

* Check out the project
```
git checkout git@github.com:evtimkirov/vehicles-app.git
cd vehicles_app
```

You can just run `./scripts/setup.sh` for fast installation and setup or use follow one-by-one the next steps.

_For the fast setup you should be sure that your MySQL username and password are `root:root`._

### Backend Setup (Symfony)

* Run the composer
```
composer install
```

* Create a .env file
```
cp .env.example .env
```
 _Change the database `root:root` if your MySQL username/password is different. Current example: `DATABASE_URL="mysql://root:root@127.0.0.1:3306/vehicles_app?serverVersion=8.0.32&charset=utf8mb4"`_


* Create database, run migrations and load fixtures
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

* Generate JWT token
```
php bin/console lexik:jwt:generate-keypair
```
 _Enter `mysecretpass` (same as in `JWT_PASSPHRASE` in `.env`)_

* Run the server
```
symfony server:start
```
### Frontend Setup (React)

* Install and run NPM
```
npm install && npm run dev
```
