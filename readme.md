# Registration Block
A new, laravel-ly application that allows users to check if they have blocks on their college account.
This application serves as a simple front end for the [Data API](https://github.com/bellevuecollege/data-api), pulling data from the `student` endpoint.

## Dependencies ⛓
This project requires access to the following resources: 
1. Access to the [BC Data API](https://github.com/bellevuecollege/data-api)
2. [SimpleSAMLphp](https://simplesamlphp.org/) must be installed and configured on the same server on which this project is installed.
3. [Globals v3.x](https://github.com/bellevuecollege/globals) must be available locally

## Setting up a local development environment 👨🏼‍💻
Using Laravel's [Homestead VM](https://laravel.com/docs/5.8/homestead) is a great way to get this up and running in a local environment.

You can also use Laravel's `php artisan serve` command, but I have not found a good way to make Globals load properly, so you may need to find workarounds to get this method to work.

1. Install [Homestead](https://laravel.com/docs/5.8/homestead) and set it up to serve both your application and Globals.  
  Example partial config file:
  ```yaml
    folders:
        - map: ~/GitProjects/registrationblock
          to: /home/vagrant/code/registrationblock

        - map: ~/GitProjects/globals/g
          to: /home/vagrant/code/g

    sites:
        - map: registrationblock.test
          to: /home/vagrant/code/registrationblock/public
          php: "7.1"

        - map: globals.test
          to: /home/vagrant/code/g
          php: "7.1"
  ```
2. [Install Laravel](https://laravel.com/docs/5.7/installation). At this time, the command is `composer global require laravel/installer`

3. Copy .env.example to .env - this is your local configuration file, and should never be committed

4. Run `php artisan key:generate` to generate a local app key

5. Run `composer install` to load dependencies 

6. Complete the .env config file with the following attributes:

    1. `APP_ENV` should generally be `local` for local development. This will disable the SimpleSAMLphp login system, and instead pull data for the test user hardcoded in `app/Http/Middleware/SimpleSAMLphp.php`. `staging` should be used for staging/test, and `production` for production.
    2. `APP_KEY` should be already set for you by step 4
    3. APP_URL` should be set to match your Homestead config (step 1)
    4. `GLOBALS_PATH` should match the globals path in your Homestead config (step 1)
    5. `GLOBALS_URI` should be the URI of globals used to fetch stylesheets, etc. 
    6. `GLOBALS_VERSION` is a cache-buster, and can be set to whatever you want
    7. `DATAAPI_CLIENT_ID` and `DATAAPI_CLIENT_KEY` can be generated through the Data API's admin interface.
    8. `DATAAPI_BASE_URI` should be the full base URL of the API endpoints, something like <https://protected.example.com/data/api/v1/internal/>
    7. All `SIMPLESAMLPHP_*` options can be left blank, as login is disabled for local environments.
    8. Other options can be left at default, as they are not directly used.

## Production Deployment 🌐
At Bellevue College this is set up to deploy through Azure DevOps Pipelines. If you are manually deploying, keep the following in mind:

1. Run `composer install --no-dev` to remove dev-only dependencies before you deploy
1. The main application code should be deployed in a directory that is not served
1. The contents of the `public` folder should be deployed to a publicly available folder on the web server, and the paths in public/index.php should be adjusted to point to the directory configured in step 1. 
1. Make sure your .env file is set up for production
    1. `APP_ENV` should be set to `production` to enable sign on
    1. `SIMPLESAMLPHP_PATH` should point to the filesystem path of the SimpleSAMLphp library on the server, aka `/var/simplesaml/lib/_autoload.php`. Note that SimpleSAMLphp must be fully installed and operational before first.
    1. `SIMPLESAML_SP` should be set as the Service Provider name used- currently this is `bc-adfs-sp`
    1. `SIMPLESAML_ATTR_USERNAME` should be set to the key that contains the username of the user in the SAML claim information. 

## Build Status 🚀
| Master | Dev |
|---|---|
| [coming soon] | [![Build status](https://dev.azure.com/bcintegration/Registration%20Block/_apis/build/status/registrationblock-dev)](https://dev.azure.com/bcintegration/Registration%20Block/_build/latest?definitionId=21) |

## The BadgeZone 💫
[![emoji-log](https://cdn.rawgit.com/ahmadawais/stuff/ca97874/emoji-log/flat-round.svg)](https://github.com/ahmadawais/Emoji-Log/)

