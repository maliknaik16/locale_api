<?php

/**
 * @file
 * Contains \Locale\Database
 */

namespace Locale;

/**
 * Provides the methods to store and retrieve data from postgresql
 */
class Database {

  /**
   * Provides the database connection
   *
   * @var object $db_connection
   */
  private $db_connection;

  /**
   * Instance of this class
   *
   * @var \Locale\Database $instance
   */
  private static $instance;

  /**
   * Makes this class Singleton by declaring it private
   */
  private function __construct() {
    $this->db_connection = NULL;
  }

  /**
   * Returns the status of the connection
   *
   * @return boolean
   *  Whether the connection is established or not
   */
  public function isConnectionEstablished() {
    if(!$this->db_connection) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Returns the instance of this class
   *
   * @return \Locale\Database
   *  Returns instance
   */
  public static function getInstance() {
    if( is_null(self::$instance) ) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Returns the Postgresql database connection
   *
   * @param string $connection_string optional
   *  Connection string to connect to postgres database
   *
   * @return object
   */
  public function getConnection($connection_string = '') {
    if(!empty($connection_string) && is_null($this->db_connection)) {
      $this->db_connection = pg_connect($connection_string);
    }

    return $this->db_connection;
  }

  /**
   * Defines the schema of the table
   *
   * @param string $table_name
   *  Name of the table to create
   * @param array $schema
   *  Array which defines the schema of the table
   *
   * @return boolean
   *  Returns TRUE when table created successfully
   */
  public function createTable($table_name, $schema) {
    $query = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' ( ';
    $numColumns = count($schema);
    $i = 0;

    // Assign default values
    $this->defaultSchema($schema);

    // Loop through every column/field
    foreach($schema as $column => $data) {
      $query .= $column . ' ' . $data['#type'] . ' ' . $data['#column_constraint'];

      if(++$i != $numColumns) {
        $query .= ', ';
      }
    }

    $query .= ');';

    if(pg_query($this->db_connection, $query)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Inserts multiples rows into the table
   *
   * @param string $table_name
   *  Name of the table where the data is stored
   * @param array $rows
   *  Array of values of the row
   *
   * @return boolean
   *  Returns TRUE when all the rows inserted successfully
   */
  public function insertRows($table_name, $rows) {
    print_r($rows);
    foreach($rows as $row) {
      if(!$this->insertRow($table_name, $row)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  /**
   * Inserts row into the table
   *
   * @param string $table_name
   *  Name of the table where the data is stored
   * @param array $row
   *  Values for the row
   *
   * @return boolean
   *  Returns TRUE when row inserted successfully
   */
  public function insertRow($table_name, $row) {
    $count = count($row);
    $i = 0;

    $query = 'INSERT INTO ' . $table_name . ' VALUES (';
    print_r($row);
    foreach($row as $value) {
      if(is_null($value) || $value == 'NULL') {
        $query .= 'NULL';
      }else if(is_string($value)){
        $query .= '\'' . $value . '\'';
      }else{
        $query .= $value;
      }

      if(++$i != $count) {
        $query .= ', ';
      }
    }
    $query .= ');';

    if(pg_query($this->db_connection, $query)) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Assigns the default value to schema if not present
   *
   * @param array $schema
   *  Array defining the schema of the table
   */
  public function defaultSchema(&$schema) {
    foreach($schema as $column => $data) {
      if(!array_key_exists('#type', $data)) {
        $schema[$column]['#type'] = 'varchar';
      }

      if(!array_key_exists('#column_constraint', $data)) {
        $schema[$column]['#column_constraint'] = '';
      }
    }
  }

  /**
   * Closes the connection
   */
  public function closeConnection() {
    pg_close($this->db_connection);
  }
}
