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
   *
   * @var \Locale\Database
   */
  protected $db_connection;

  /**
   * Name of the table where rides data is stored
   *
   * @var string
   */
  protected $table_name;

  /**
   * Initializes the database connection
   *
   * @param \Locale\Database $database
   *  Database object
   * @param string $table_name
   *  Name of the table
   *
   */
  public function __construct(Database $database, $table_name) {
    $this->db_connection = $database;
    $this->table_name = $table_name;
  }

  /**
   * Returns the Latitude and Longitude
   *
   * @param string $lat_column
   *  Name of the latitude field
   * @param string $long_column
   *  Name of the longituede field
   * @param int $id
   *  ID of the row
   *
   * @return array
   */
  public function getLatLong($lat_column, $long_column, $id) {
    $query = "SELECT {$lat_column}, {$long_column} FROM {$this->table_name} WHERE id={$id}";

    $result = pg_query($this->db_connection->getConnection(), $query);

    $row = pg_fetch_row($result);

    return $row;
  }

  /**
   * Returns the rides by the travel type
   *
   * @param int $travel_type_id
   *  Type of travel (1=long distance, 2= point to point, 3= hourly rental).
   * @param array $fields
   *  Columns/Fields of the table
   *
   * @return array
   */
  public function getRidesByTravelType($travel_type_id, $fields = array()) {
    $c = '*';
    $result = array();
    if(!empty($fields)) {
      $c = implode(', ', $fields);
    }
    $query = "SELECT {$c} FROM {$this->table_name} WHERE travel_type_id={$travel_type_id}";
    $ret = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_assoc($ret)) {
      $result[] = $row;
    }

    return $result;
  }

  /**
   * Returns the rides travelled by the user
   *
   * @param int $user_id
   *  User id of the user
   *
   * @return array
   */
  public function getRidesByUserId($user_id) {
    $result = array();

    $query = "SELECT * FROM {$this->table_name} WHERE user_id={$user_id}";

    $ret = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_assoc($ret)) {
      $result[] = $row;
    }

    return $result;
  }

  /**
   * Returns the cancelled rides
   *
   * @return array
   *  Array of cancelled rides
   */
  public function getRidesCancelled() {
    $result = array();

    $query = "SELECT * FROM {$this->table_name} WHERE car_cancellation=1";

    $ret = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_assoc($ret)) {
      $result[] = $row;
    }

    return $result;
  }

  /**
   * Returns the rides other than cancelled rides
   *
   * @return array
   *  Array of not cancelled rides
   */
  public function getRidesNotCancelled() {
    $result = array();

    $query = "SELECT * FROM {$this->table_name} WHERE car_cancellation=0";

    $ret = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_assoc($ret)) {
      $result[] = $row;
    }

    return $result;
  }

  /**
   * Returns the rides by the vehicle model id
   *
   * @param int $vehicle_model_id
   *  ID of the Vehicle model
   *
   * @return array
   */
  public function getRidesByVehicleModelId($vehicle_model_id) {
    $result = array();

    $query = "SELECT * FROM {$this->table_name} WHERE vehicle_model_id={$vehicle_model_id}";

    $ret = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_assoc($ret)) {
      $result[] = $row;
    }

    return $result;
  }

  /**
   * Returns all the rides
   *
   * @param array $fields
   *  Columns/Fields of the table
   *
   * @return array
   */
  public function getAllRides($fields = array()) {
    $result = array();
    $c = '*';
    if(!empty($fields)) {
      $c = implode(', ', $fields);
    }

    $query = "SELECT {$c} FROM {$this->table_name}";

    $ret = pg_query($this->db_connection->getConnection(), $query);

    while($row = pg_fetch_assoc($ret)) {
      $result[] = $row;
    }

    return $result;
  }
}
