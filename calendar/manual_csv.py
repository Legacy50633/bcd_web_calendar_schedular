import pandas as pd
import mysql.connector
from mysql.connector import Error

# Database configuration
DB_CONFIG = {
    'host': 'localhost',      # Database host
    'database': 'timebase_sys',  # Database name
    'user': 'root',  # Database username
    'password': ''  # Database password
}

# Function to insert data into the database
def insert_data(df):
    try:
        # Establish the database connection
        connection = mysql.connector.connect(**DB_CONFIG)
        cursor = connection.cursor()

        # Prepare the insert SQL query
        insert_query = """
        INSERT INTO taskmanager (
            event_id, message, startdate, enddate, notallowed, timing, colour, days, 
            audio, audioname, paulid, adhikaramid, thirukkuralid, bellid
        ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        # Iterate through the DataFrame and insert each record
        for index, row in df.iterrows():
            # Prepare data for insertion
            event_id = row['event_id']
            message = row['message']
            startdate = row['startdate']
            enddate = row['enddate']
            notallowed = row.get('notallowed', None)  # Use None if the column doesn't exist
            timing = row['timing']
            colour = row.get('colour', None)  # Default to None if not provided
            days = row.get('days', None)
            audio = row.get('audio', None)
            audioname = row.get('audioname', None)
            paulid = row.get('paulid', None)
            adhikaramid = row.get('adhikaramid', None)
            thirukkuralid = row.get('thirukkuralid', None)
            bellid = row.get('bellid', None)

            # Count existing entries for the date
            count_query = "SELECT COUNT(*) FROM taskmanager WHERE startdate = %s"
            cursor.execute(count_query, (startdate,))
            existing_count = cursor.fetchone()[0]

            # Check if the limit of 16 entries is reached
            if existing_count < 16:
                cursor.execute(insert_query, (
                    event_id, message, startdate, enddate, notallowed, timing, colour, days,
                    audio, audioname, paulid, adhikaramid, thirukkuralid, bellid
                ))
                print(f"Inserted entry for {startdate}: {message}")
            else: 
                print(f"Skipped insertion for {startdate}: limit of 16 entries reached.")

        # Commit the changes to the database
        connection.commit()
        print("Data insertion completed.")

    except Error as e:
        print(f"Error: {e}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

# Read the CSV file into a DataFrame
csv_file_path = '../../full_year.xlsx'  # Replace with your CSV file path
df = pd.read_csv(csv_file_path)

# Call the insert_data function
insert_data(df)
