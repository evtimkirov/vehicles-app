# Vehicle Application

This project uses **Symfony** (backend) and **React** (frontend).

---

## Fast Setup (Single Command)

You can run everything with one command:

```
./scripts/setup.sh
```
> [!WARNING]
> Make sure your MySQL username and password are root:root for the fast setup to work.
You can edit .env if your credentials are different.

### Manual Setup (Step-by-Step)

* Check out the project
```
git checkout git@github.com:evtimkirov/vehicles-app.git
cd vehicles_app
```

* Run the composer
```
composer install
```

* Create a .env file
```
cp .env.example .env
```
> [!WARNING]
> Edit the database URL if your MySQL username/password is different. Example:
DATABASE_URL="mysql://root:root@127.0.0.1:3306/vehicles_app?serverVersion=8.0.32&charset=utf8mb4"

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

## Default Users

### The system comes with two pre-configured users for testing purposes:

| Email  | Password | Role     | Access                                                                        |
| ------------- |----------|----------|-------------------------------------------------------------------------------|
| user_merchant@mypos.com | password | Merchant | Full access to all features, including creating vehicles.                     |
| user_buyer@mypos.com	| password | Buyer    | 	Restricted access — cannot create vehicles. Can view and follow vehicles.    |

Use these accounts to log in and test the application with different permissions.

## API endpoints

| Method | Endpoint                          | Controller / Description           | Access / Role    |
| ------ | --------------------------------- | ---------------------------------- | ---------------- |
| POST   | `/api/v1/registration`            | `RegistrationController::__invoke` | Public           |
| POST   | `/api/v1/login`                   | `LoginController::login`           | Public           |
| POST   | `/api/v1/forgot-password`         | `ForgotPasswordController`         | Public           |
| GET    | `/api/v1/users/{id}`              | `UserController`                   | Protected        |
| GET    | `/api/v1/users/{id}/vehicles`     | `UserController::getUserVehicles`  | Protected        |
| GET    | `/api/v1/users/role`              | `UserController::getRole`          | Protected        |
| POST   | `/api/v1/users/vehicles/follow`   | `UserController::follow`           | Buyer / Merchant |
| POST   | `/api/v1/users/vehicles/unfollow` | `UserController::unfollow`         | Buyer / Merchant |
| GET    | `/api/v1/users/vehicles/followed` | `UserController::listFollowed`     | Buyer / Merchant |
| GET    | `/api/v1/vehicles`                | `VehicleController::index`         | Protected        |
| GET    | `/api/v1/vehicles/{id}`           | `VehicleController::show`          | Protected        |
| POST   | `/api/v1/vehicles`                | `VehicleController::store`         | Merchant only    |

