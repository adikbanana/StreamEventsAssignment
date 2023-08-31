# StreamEventsAssignment
 A dasbhoard to view event logs for streams.


LOCAL SETUP
1. Download Xampp.

2. Initialize Apache and Mysql.

3. Unarchive the attached zip file (StreamEventsAssignment) and place it in the htdocs folder of your Xampp installation directory.

4. Download Composer and open the project folder in IDE of choice.

5. Run ‘php artisan migrate’, followed by ‘php artisan serve’.

6. Register a user and then run ‘php artisan db: seed’, and it’s ready for testing.

Note: I recommend creating user(s) through the UI by running the app on a local server (the 'php artisan serve' step above) before seeding, as the ids will get assigned automatically and you will have data already available to test with when you log in as one of the users after seeding.

 
