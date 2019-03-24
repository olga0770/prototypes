# Technology stack used

## Backend
Laravel PHP framework https://laravel.com/
composer https://getcomposer.org/
PHPUnit https://phpunit.de/

## Frontend
Vue https://vuejs.org/
yarn https://yarnpkg.com/en/
WebPack/LaraMix
Cypress https://www.cypress.io/

## Database
MySQL

## Version Control (VCS)
git, GitLab

## IDE's
WebStorm
PhpStorm

## Other
SonarQube



## To build:

$ yarn install && composer install && yarn run dev





## To deploy this web application:

Install the Homestead VM (HVM), see https://laravel.com/docs/5.8/homestead

Then e.g. if you downloaded bicycle-prototype to ~/code in the Homestead.yaml configuration file you
would write:

folders:
    - map: ~/code
      to: /home/vagrant/code

sites:
    - map: bicycle.test
      to: /home/vagrant/code/public
      
Also add this line to your hosts file (https://en.wikipedia.org/wiki/Hosts_(file))      
      
After starting the HVM, point a browser to http://bicycle.test



## Troubleshooting

If you change the sites property after provisioning the HVM, 
you should re-run 'vagrant reload --provision' to update the Nginx configuration 
on the virtual machine. This would also create any new databases.

If new databases are added, you also may need inside the HVM to run

$ php artisan migrate:fresh

to create the schema, and possibly

$ php artisan db:seed

to populate tables.
