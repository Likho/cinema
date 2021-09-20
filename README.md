# cinema
A symfony movie booking application. I have used the framework Symfony 5 and mariaDb.
My reasons for using symfony are 
- it supports the repository pattern by default and creates repositories with basic methods 
for each entity. 
- It has easy to implement security which manages user authentication and authorization out of the box.

<h4>Requirements</h4>
I used php7.3 . If you are using an earlier version please download <strong>Docker</strong> in order to run this application

>> Docker  --hard requirement for running app

<h4>Setup instructions </h4>

After cloning the repo, open the project folder on the terminal: 

>
>>$ cd docker
>
>>$ docker-compose build
>
>>$ docker-compose up
> 
> After docker-compose up has completed open another terminal window and navigate to the docker directory of your repo. 
> You will now migrate the db and populate test data. Run the instructions below. 
> <strong>Please note</strong> You have to have your app still running docker to execute the below instructions. 
> 
>>$ docker-compose exec php bin/console doctrine:database:create
>
>>$ docker-compose exec php bin/console doctrine:fixtures:load
