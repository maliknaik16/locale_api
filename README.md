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
