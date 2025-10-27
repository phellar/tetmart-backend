This project is a mini multi vendor Backend Api project, which has the following features
1. Guest checkout
2. All fetched product were paginated for data clearity
3. vender(user) registration and login
4. create,update,view and delete of product and orders
5. Email Notification of orders for both customer and vendors who owns the products
6. Mails we queued for smooth runing of the api
7. Policies was enforce for Auth user(vendors) to only access their listed product and orders attached to their product.

TOOLS
1. Mysql Database
2. Laravel Sanctum for Middleware and Api Token
3. Laravel Mailable for Notifications
4. Mailtrap for testing email
5. Laravel Gate$Policies for user(vendor), product and order Policy

UP NEXT FEATURES
1. Payment Gateway integration
2. wrapping order creation function into Db Transaction for data consistency.


HOW TO RUN OR USE THE APPLICATION
1. clone this repo
2. set up a mysql database or any dabatase of your choice
3. use the .env.example file to create your .env file
4. fill in your database credentials in the db connection
5. set up your prefared mailer e.g SMTP in the .env
6. open the integrated terminal and run db migerations with "php artisan migrate" this will run the database migration files and create neccessarry tables in your database.
7. you can also check available api list with the comand line "php artisan route:list" or open the api.php file in the routes folder to check the routes and methods used.
8. serve/run the application with "php artisan serve" this willl give you localhost address. it will run on port 8000
9. you can add changes or tweak it to your preference
    
enjoy!!!!!!!!!!!!!!!!!!!!!!!!!!! 
11.  
 
