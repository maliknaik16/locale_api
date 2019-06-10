# Locale API
Locale API is an Application Programming Interface(API) which provides methods and classes to stores and retrieves the rides data from the Postgresql database and is written in PHP.

# Locale\Database class
This is a Singleton class and provides the methods or functions to store and retrieve data from postgresql.
The functions provided by this class are
* getInstance() - Returns the instance of this class.
* getConnection() - Returns the database connection
* createTable() - Creates the table in Postgresql database by passing the schema of the table as an argument along with table name.
* insertRows() - Inserts multiple rows into the table and it takes two parameters one is the table name and other is the array of row arrays.
* insertRow() - Inserts single row into the table
* defaultSchema() - Adds default schema key/value pairs to the schema array.
* isConnectionEstablished() - Returns if the connection is successfully established.
* closeConnection() - Closes the connection
