# bdc_web_calendar_schedular

INTRODUCTION

A project which plays 1330 thirukural and user defined audio files based on web and bcd switch inputs and schedules done by user
```Languages Used : Html,css,js,php,mysql and python```

FEATURES
```
1. Manual csv schedule upload 
2. Manual schedule with audio 
3. Manual thirukural Audio Player from 1 - 1330 and adhigaram 133
4. Audio controls like pause stop play
5. Customizable titles , background image
```


Prerequisites
```           
- PHP Version 7.3 or 8.0.30 
- Python (version 3.x recommended)
- pip (Python package manager)
- Xampp 7.3 or Xampp version > 7.3
```

### Installing

1. Clone the repository:

    ```bash
   https://github.com/Legacy50633/bdc_web_calendar_schedular.git
    cd bcd_web_calendar_Schedular
    python3 stepup_install.py or python stepup_install.py
    ```

2. Create a virtual environment:

    ```bash
    # Using venv (recommended)
    python -m venv venv

    # Activate the virtual environment
    # On Windows
    .\venv\Scripts\activate
    # On macOS/Linux
    source venv/bin/activate
    ```

3. Install the project dependencies:

    ```bash
    pip install -r requirements.txt
    ```
4. Rashberrypi Scanning

   ```bash
   (first get you ip address by typing)
   ipconfig
   nmap -sn 192.168.your_ipnumber.0/24
   (look for rashberrypi foundation)
   
   ```
5. Putty and Winscp Login
   ```
   (intsall putty exe)
   username : admin
   password: root
   ```   
6. Database Credentials
   ```
   Username = root
   Password = root
   Host = localhost
   Database = timebase_sys
   ```
7. Website app Login Credentials

   ```
   ADMIN Access
   Username:Goku
   Password:12345

   USER ACCESS
   Username: Vegeta
   Password:12345
   ```
     
8. API Documentation 


```
1.  localhost/calendar/config.php and localhost/calendar/Audio_Manager/callbacks/config.php - change ur database name in these files and check all the files inside localhost/calendar/Audio_Manager/callbacks
2.  localhost/calendar/Audio_Manager/callbacks/login.php - Handles the login request from starting page 
3.  localhost/calendar/Audio_Manager/callbacks/logout/php - Handles  logout from starting page
4.  localhost/calendar/backphp.php - Handles the new schedule creation
5.  localhost/calendar/csv_upload - Hanldes Csv or xlsx file upload
6.  localhost/calendar/delete.php - Handles event delete
7.  localhost/calendar/get_audio_test_api = fetch event close to current date and time sends the audio paths of the individual events  to the main.py
8.  localhost/calendar/fetchapi.php - sends audio paths of the event which is close to current date and time 
9.  localhost/calendar/popup.php -  gets and sends data for the popup in calendar
10. localhost/calendar/update_event - update the event for the particular day
11. localhost/calendar/updatefull_event - updates the whole schedule
12. localhost/calendar/Audio_Manager/callbacks/display.php - fetches the existing image url and sends back
13. localhost/calendar/Audio_Manager/callbacks/fetchdetail.php - fetches the titles and sends back
14. localhost/calendar/Audio_Manager/callbacks/initialize.php - initializes audio running status , pause , stop as zero
15. localhost/calendar/Audio_Manager/callbacks/select.php - selects the user defined input as audio file path
16. localhost/calendar/Audio_Manager/callbacks/upload.php - uploads the images to the database
17. localhost/calendar/Audio_Manager/callbacks/fetch.php - get the details of the designated thiurkural or adhigaram as texts from database


```
9. BCD PINS Integration pi model 3 B+ - 4 swithces
   ```
         switch1 = [6, 13, 19, 26]
         switch2 = [12, 16, 20, 21]
         switch3 = [24, 25, 8, 7]
         switch4 = [4, 17, 27, 22]
         differnce value to read pin value  = 15
         visit (https://pinout.xyz/) for full pinout details
   ```
10. Main Script

calendar/main.py - runs the main script which plays the audio files through the data sent by the appropriate end points if u want to change any logic regard audio play change this file 



## Contributing

If you'd like to contribute to this project, please follow these guidelines.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

