<?php

/**
 * @file
 * Contains \Locale\CSVHandler
 */

namespace Locale;

/**
 * Defines methods for accessing the rides data from the Postgresql database
 */
class Rides {
  /**
   * The database connection
   */
  protected $db_connection;

  /**
   * Initializes the database connection
   */
  public function __construct(Database $database) {
    $this->db_connection = $database;
  }

  /**
   * Returns the Latitude and Longitude
   */
  public function getLatLong($table_name, $lat_column, $long_column, $id) {
    $query = "SELECT {$lat_column}, {$long_column} FROM {$table_name} WHERE id={$id}";

    $result = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_row($result)) {
      print_r($row);
    }
  }
}
