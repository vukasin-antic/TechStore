# TechStore

Ovaj dokument opisuje sve potrebne korake da pokrenes moj projekat lokalno 

## 1. 
``` bash

composer install

```
## 2. 

```bash
cp .env.example .env
```
zatim promeniti u .env file za mail i za bazu:

- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=your_database`
- `DB_USERNAME=root`
- `DB_PASSWORD=`

- `MAIL_MAILER=smtp`
- `MAIL_HOST=smtp.gmail.com`
- `MAIL_PORT=587`
- `MAIL_USERNAME=your_email@gmail.com`
- `MAIL_PASSWORD=your_app_password`
- `MAIL_ENCRYPTION=tls`
- `MAIL_FROM_ADDRESS=your_email@gmail.com`
- `MAIL_FROM_NAME="TechStore"`

## 3.

```bash
php artisan key:generate
```

## 4. Promeniti ime za bazu i napraviti je u xampp

## 5.

```bash
php artisan migrate --seed

```

## 6.

```bash
php artisan storage:link
```

## 7.

```bash
php artisan serve
```

## 8. Kredencijali za admina i obicnog korisnika

admin@gmail.com
admin123

test@gmail.com
test1234