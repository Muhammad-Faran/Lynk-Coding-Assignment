
Thank you for the opportunity to submit my code assignment. Below are the steps to set up and run the project:

Step 1: Clone Repository

Step 2: Composer Install
Navigate to the project directory and install the required PHP dependencies using Composer:
composer install



Step 3: Set .env
Create a copy of the .env.example file and save it as .env. Update the configuration settings in the .env file, including database connection details.



Step 4: Generate Application Key
Generate a unique application key with the following artisan command:
php artisan key:generate



Step 5: Connect Local Database
Make sure your local database is set up and properly configured in the .env file. Update the database connection details accordingly.




Step 6: Run Migrations
Execute the following command to run the database migrations:
php artisan migrate




Step 7: Seed Database
There is a admin user and couple of customer users added in UserSeeder along with other required ones, run the following command for database seed:
php artisan db:seed




Step 8: NPM Install
Install the required Node.js dependencies for the project:
npm install




Step 9: Build Assets
Compile the project's assets using:
npm run dev




Step 10: Run Development Server
Start the development server with the following command:
php artisan serve




Your application should now be accessible at http://localhost:8000. Feel free to explore and test the functionality.

You can get login credentials from USerSeeder.



