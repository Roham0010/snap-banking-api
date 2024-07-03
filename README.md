# For Code Reviewer

## Instructions to setup and run the project

-   Run cp .env.example .env
-   Change the .env file variable if needed
-   Run composer install
-   Run php artisan key:generate
-   I have put two phone numbers for simplicity of testing the project and receiving SMS as PHONE1 and PHONE2 change them to your preferences.
-   Create a database on mysql database name snap_banking(or whatever you wish but don't forget to change the name in .env too).
-   Run php artisan migrate
-   Run php artisan db:seed
-   Run php artisan route:list to see the routes and test the project
-   Rup php artisan test for tests

## Sample Rquest data:

-   New Card Transaction:
    URL:
    api/cards/transfer
    Data:
    destination_card_number:4919767217411798
    amount:5000
    source_card_number:6011581798668227

-   Get top 3 users:
    URL: api/users/top-users

### Notes:

-   I have tested both SMS services here is the kavenegar panel [report](https://prnt.sc/-fUGpvJqBc5f)
-   There was an issue regarding this version of Laravel-Carbon I am using that I had to use the UTC timezone [Reported it Here](https://github.com/laravel/framework/issues/51997)
-   Despite that the document specified the transaction fee is on the bank, but I asume based on the reality should be deducted from the source card acount and the enaugh balance validation should also consider the fee too.
-   It wasn't explained if a user can transfer money between it's own cards, I consider yes and consider the fee happens on there too.
-   I asumed we should be okay with dashed credit numbers like 1111-1111-1111-1111
