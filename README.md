# RoomService
This project is made for RE course of Innopolis, it is the room cleaning service.


Cleaning Room Service on Demand

The paper presented below explains the operation and development of a Cleaning Room Service on-demand application.

After living a couple of weeks in our first-class university, we have noticed a problem. There is no option to request cleaning for our rooms in case of them being extremely dirty, or due to an unexpected situation.

With the development of this application, with a couple of taps, you can request a cleaning room service.

How's it works?
    • Pick a time: Select the date and time for your service and get instant, affordable pricing 
    • Book instantly: The app will confirm your appointment and take care of the payment electronically and securely 
    • Cleaning room service: an experienced, fully-equipped professional will show up on time at your doorstep

The application must contain:
    • Administrator module to make all the necessary configurations for the correct operation, establishment of cleaning schedules, number of rooms and buildings, estimated waiting times. 
    • GUI available for IOS, Android, and website.

The development of the application will be through the use of the following technologies:
    • MySQL
    • PHP


# Instructions to install Roomservice web application

Info:
This is Codeigniter based framework, written in PHP

Prerequisites:
- MySQL Server
- Local PHP server (Openserver or Xampp/MAMP(for Mac)) 
- PHP v5.6 
- SMTP (Gmail or Mailtrap)

1. Create Mysql database with name "roomservice"
2. Find the "roomservice.sql" file inside database folder and import that file to recently created roomservice database
3.  Create "env.development" file based on ''.env.example"
4. Edit "env.development" file:
   1. Edit user name, password and host for mysql server
   2. For main notofocation edit EMAIL_HOST, EMAIL_USER, EMAIL_PASS, EMAIL_PORT, EMAIL_CRYPTO.
5. Install Composer dependencies "composer install"
6. If you have Openserver, create domain "room.lc" and put all folders and files inside Roomservice folder into domain folder
7. Check url "room.lc" from browser, that's all!

If any problems, write to @bzimor_inno or @valeriayurinskaya via telegram or check Codeigniter online documentation: https://codeigniter.com/user_guide/installation/index.html

You can check the working prototype via "http://roomserviceinnopolis.ru"

Admin user:
email: admin@roomserviceinnopolis.com
password: admin1234

Student user:
you can register and login, no email verification required


