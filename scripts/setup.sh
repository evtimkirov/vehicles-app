#!/bin/bash
set -e

echo "Copy .env file..."
cp .env.example .env

echo "Installing PHP dependencies..."
composer install

echo "Cleaning the old and creating the new one database..."
php bin/console doctrine:database:drop --force || true
php bin/console doctrine:database:create

echo "Run the migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Load the fixtures..."
php bin/console doctrine:fixtures:load --no-interaction

echo "Generate the JWT keys..."
php bin/console lexik:jwt:generate-keypair --overwrite <<< "mysecretpass"$'\n'"mysecretpass"

echo "Installing frontend dependencies..."
cd assets
npm install
npm run dev &

echo "Starting Symfony server..."
cd ..
symfony server:start
