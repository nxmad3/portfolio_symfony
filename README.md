# Pause jusqu'au 20 aout :)

# portfolio_symfony

# <ins>[[portfolio_symfony](https://github.com/nxmad3/portfolio_symfony.git)]

## Information :

### Goal : 

Create a cooperative Portfolio .

### Used technologies: 

[SYMFONY](https://symfony.com/) | [HTML](https://developer.mozilla.org/fr/docs/Web/HTML) | [CSS](https://developer.mozilla.org/fr/docs/Web/CSS) | [PHP](https://www.php.net/) | [BOOTSTRAP](https://getbootstrap.com/) | [JavaScripts](https://developer.mozilla.org/fr/docs/Web/JavaScript) | [MySQL](https://www.mysql.com/fr/)

### Realization period: 

start 29/03/2022

## How to launch the project ?
  
clone the project 
  
        git clone https://github.com/nxmad3/portfolio_symfony.git
        cd portfolio_symfony

type this command to install and build the project

        composer install

If the database wasn't create run 

        php bin/console doctrine:database:create

To fill the database run

        php bin/console doctrine:schema:update --dump-sql --force
        php bin/console doctrine:fixtures:load

After making sure that the database has been filled and the project has been built you can type

        symfony server:start

  
## to access at the admin page tape on the url /admin and connect with email root@root.fr and password root
