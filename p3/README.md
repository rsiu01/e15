

# Project 3
+ By: Richard Siu
+ Production URL: <http://e15p3.rsiu01.me>

## Feature summary
*Temperature and humidity monitor is an application that handles, stores and displays data sent from a api request. Temperature and humidity data is displayed using Laravel Charts and Chart.js. 

+ Visitors can register/log in/log out
+ Users can add/update/delete devices (description, low temperature, high temperature, calibration offset, location, alarm)
+ Users can page through temperature and humidity readings data for each device and have it displayed on a graph rendered by Laravel Charts/Chart.js.  

  
## Database summary
*Describe the tables and relationships used in your database. Delete the examples below and replace with your own info.*

+ My application has 3 tables in total (`users`, `devices`, `readings`)
+ There's a one-to-many relationship between `devices` and `readings`

## Outside resources

+https://www.nicepng.com/maxp/u2w7t4r5w7q8i1t4/

+https://www.w3schools.com/charsets/ref_utf_letterlike.asp

+https://kit.fontawesome.com/a076d05399.js

+https://charts.erik.cat/

+https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js

+https://stackoverflow.com/questions/7231157/how-to-submit-form-on-change-of-dropdown-list

+https://github.com/fzaninotto/Faker/issues/914#issuecomment-565539803
## Notes for instructor

