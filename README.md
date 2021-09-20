# Cinema
A Symfony movie booking application. I have used the framework Symfony 5 and mariaDb.
My reasons for using Symfony are
- It supports the repository pattern by default and creates repositories with basic methods
  for each entity.
- It has easy to implement security which manages user authentication and authorization out of the box.

### Requirements
I used PHP 7.3. If you are using an earlier version please download **Docker** in order to run this application

**NB: Docker is a hard requirement for running app**

### Setup instructions

After cloning the repo, open the project folder on the terminal and run the following commands:

```
cd docker
docker-compose build
docker-compose up -d
docker-compose run php composer install
```

After `composer install` has completed you will now migrate the db and populate test data.

Run the instructions below.

**NB: You have to have docker still running in a separate terminal to execute the below instructions.**

```
docker-compose exec php bin/console doctrine:database:create
docker-compose exec php bin/console doctrine:migrations:migrate
docker-compose exec php bin/console doctrine:fixtures:load
```
