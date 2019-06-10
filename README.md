# Locale API
Locale API is an Application Programming Interface(API) which provides methods and classes to stores and retrieves the rides data from the Postgresql database and is written in PHP.

# \Locale\Database class
This is a Singleton class and provides the methods or functions to store and retrieve data from postgresql.
The functions provided by this class are:
* getInstance() - Returns the instance of this class.
* getConnection() - Returns the database connection
* createTable() - Creates the table in Postgresql database by passing the schema of the table as an argument along with table name.
* insertRows() - Inserts multiple rows into the table and it takes two parameters one is the table name and other is the array of row arrays.
* insertRow() - Inserts single row into the table
* defaultSchema() - Adds default schema key/value pairs to the schema array.
* isConnectionEstablished() - Returns if the connection is successfully established.
* closeConnection() - Closes the connection

# \Locale\CSVHandler class
This class provides methods to read the .csv file and convert the data from the .csv file to array. The constructor of this class takes the file name of the .csv file to process.
The functions provided by this class are:
* isFileOpen() - Returns TRUE when the file pointer to the .csv file is set.
* toArray() - Reads the .csv file and generates an array containing the .csv file data and it has two optional parameters ```$num_rows``` and ```$omit_first_row```. The ```$num_rows``` argument limits the number of rows of .csv file to convert and ```$omit_first_row``` specifies whether to omit reading the first row as most .csv file contains the header as the first row.

# \Locale\Rides class
This class provides methods necessary to fetch the required data from the database related to the rides. The constructor of this class takes the object of type ```\Locale\Database``` class.
The functions provided by this class are:
* getLatLong() - This function retrieves the latitude and longitude specified by the id.
* getAllRides() - Returns all the rides from the table and if we want to retrive the data by columns/fields then pass an array as argument with the column/fields names.
* getRidesByTravelType() - Returns the rows by travel type.
* getRidesByUserId() - Return all the rides travelled by the user
* getRidesCancelled() - Returns all the cancelled rides
* getRidesNotCancelled() - Returns all rides other than cancelled rides
* getRidesByVehicleModelId() - Returns all the rides by the vehicle_model_id

# How to use this API?
To use the Locale API from other sources like web and mobile applications we need to generate the reponse as JSON format.

The following snippet retrieves all the rides from the table 'rides' with the columns/fields as *id*, *user_id*, *travel_type_id*, *from_lat*, and *from_long* and generates the response of the format JSON.
```php
<?php

use Locale;

// Set content type to JSON
header('Content-Type: application/json');

$connection_string = '<CONNECTION_STRING_FOR_POSTGRESQUL>';
$fields = array('id', 'user_id', 'travel_type_id', 'from_lat', 'from_long');

$database = Database::getInstance();
$db_connection = $database->getConnection($connection_string);

$rides = new Rides($database, 'rides');

$result = $rides->getAllRides($fields);

echo json_encode($result);


```

# How to convert .csv file to array?
The CSVHandler class from the Locale namespace provides the method to convert the .csv file to array.

The following snippet shows how to convert .csv file to array:
```php
<?php

use Locale;

$csv = new CSVHandler('<CSV_FILE_NAME>');

// $result stores the .csv file in the form of an array
$result = $csv->toArray();


```

**NOTE**: For more information on the parameters of the functions refer to the doc block at the top of the function in the class.
