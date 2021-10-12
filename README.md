# Bill the Investor Rest API

This is a restful API for the dashboard of Bill the Investor.

## Prerequisites

For technical requirements, visit [Symfony Setup Requirements](https://symfony.com/doc/current/setup.html#technical-requirements)

## How to start

In the project directory:

1. Rename `.env.sample` to `.env` and update the ENV variables to that of yours.
2. Run the following commands one by one: 
   1. > `composer install`
   2. > `php bin/console doctrine:database:create`
   3. > `php bin/console doctrine:migrations:migrate`
3. To load dummy data, run the following command:
   1. > `php bin/console doctrine:fixtures:load`
4. To start the server, run the following command:
   1. > `symfony server:start`
