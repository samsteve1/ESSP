# System setup

## Clone project and build `Docker` images using `Laradock`

1. Ensure `Docker` and `git` are installed on the machine.
1. Clone the ESSP project by running `git clone --recursive https://github.com/samsteve1/ESSP.git` on the command terminal.
1. Open the cloned project with a code editor such as VS Code.
1. Navigate to the `laradock` directory in the project.
1. Rename the `.env.example` file to `.env`
1. Now open the `.env` file and make the following changes.

-   Set `COMPOSE_PROJECT_NAME` = `essp` on line 36
-   Set `PHP_VERSION` = `8.0` on line 42.

7. Now open the `docker-compose.yml` file in the `laradock` directory and make the following changes.

-   Modify the network settings for `NGINX` on line `416` like so:

```networks:
      frontend:
        aliases:
          - essp.test
       backend:
         aliases:
           - essp.test
```

8. Finally, in the `laradock` directory, run `docker-compose up -d --build nginx mysql` to build the needed images. Note, this will take some time initially, depending on download speeds.

## Configure MySQL database

After the docker images are built successfully, do the following:

1. Navigate to the laradock folder in the project directory, run `docker-compose exec MySQL bash` to enter the MySQL container.
   Once in the container run the following commands to create the database:

```
mysql -uroot -proot

create database essp

exit
```

## Configure Laravel App

1. Navigate to the ESSP project, rename the `.env.example` file at the root directory to `.env`
2. Open the `.env` file and make the following changes:

-   Set `APP_NAME` = ESSP
-   Set `APP_URL` = http://essp.test
-   Configure Database connection like so:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=essp
DB_USERNAME=root
DB_PASSWORD=root
```

3. Save the file and close it.

Now navigate to the `laradock` directory and run `docker-compose exec workspace bash` to enter the laravel app container
Once in the container run the following commands in sequence:

```
composer install
```

```
php artisan key:generate
```

```
php artisan migrate
```

```
npm install
```

```
npm run dev
```

```
exit
```

## Start the application

Navigate to the `laradock` directory and run the following commands to restart the application:

```
docker-compose stop

docker-compose up -d nginx mysql
```

## Final step: Configure virtual host

-   Update the hosts file on the machine, the file location is described below:

```
/etc/hosts (linux)
C:\Windows\System32\drivers\etc\hosts (Windows)
```

insert the line below and safe the file:

```
127.0.0.1 essp.test
```

Finally, our app is ready,
visit http://essp.test to view it.

# Seeding the database

To seed the database with sample data, follow the following steps:

1. Navigate to the `laradock` folder in the project root directory and run the command below :

```
docker-compose exec workspace bash
```

```
php artisan db:seed CampaignSeeder
```

wait for the seed to complete and run

```
exit
```

Now we have some data in the data store.

Refresh the app in the browser and you should see some records.

# Runnig Tests

Unit and Feature tests were written for the backend.
To run tests, navigate to the laradock folder in the project directory and run:

```
docker-compose exec workspace bash
```

```
php artisan test
```

The test output will be displayed in few seconds.

Many thanks!
