# Rest Api for Ticket System

This application is use for ticket system


# Installation

-   Clone the Repo:  
    
-   > git clone  https://github.com/eminengul/TicketSystem.git
-   > cd Ticket
-   > composer install or composer update
-   > Set up .env file
-   > php artisan key:generate
-   > php artisan storage:link
-   > php artisan migrate:fresh --seed
-   > php artisan serve
-   [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

# Usage

-  > http://127.0.0.1:8000/api/users with POST method  create user
-  > http://127.0.0.1:8000/api/login  with GET method can be login
-  > http://127.0.0.1:8000/api/tickets with POST method can create ticket
-  > http://127.0.0.1:8000/api/tickets with GET method can list tickets
-  > http://127.0.0.1:8000/api/tickets/{id} with POST method can update ticket
