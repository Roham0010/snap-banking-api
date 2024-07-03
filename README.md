# For Code Reviewer

## Instructions to setup and run the project

-   Run `cp .env.example .env`
-   Change the .env file variables if needed
-   Run `composer install`
-   Run `php artisan key:generate`
-   I have put two phone numbers for simplicity of testing the project and receiving SMS as PHONE1 and PHONE2 in the .env file, change them to your preferences.
-   Create a MySQL database named snap_banking(or whatever you wish but don't forget to change the name in .env too).
-   Run `php artisan migrate`
-   Run `php artisan db:seed`
-   Run `php artisan route:list` to see the routes and test the project
-   Rup `php artisan test` for tests

## Sample Request data:

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
-   In the real world because it's a full API I would do it with Lumen, but for a test project, I just preferred Laravel.
-   I have tested both SMS services here is the Kavenegar panel [report](https://prnt.sc/-fUGpvJqBc5f)
-   There was an issue regarding this version of Laravel-Carbon I am using that I had to use the UTC timezone. [Reported it Here](https://github.com/laravel/framework/issues/51997)
-   Despite that the document specified the transaction fee is on the bank, I assume based on reality should be deducted from the source card account and the enough balance validation should also consider the fee.
-   It wasn't explained if a user can transfer money between their cards, I consider yes and consider the fee happens on there too.
-   I assumed we should be okay with dashed credit numbers like 1111-1111-1111-1111
