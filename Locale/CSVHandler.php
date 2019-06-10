<?php

/**
 * @file
 * Contains \Locale\CSVHandler
 */

namespace Locale;

/**
 * Defines methods to read the .csv file
 */
class CSVHandler {
  /**
   * CSV file name to parse
   */
  protected $file_name;

  /**
   * File pointer for the .csv file
   */
  protected $fp;

  /**
   * Initializes the $file
   */
  public function __construct($file_name) {
    $this->file_name = $file_name;
    if(file_exists($file_name)) {
      $this->fp = fopen($this->file_name, "r");
    }
  }

  /**
   * Returns if the file pointer is initialized
   */
  public function isFileOpen() {
    if(!$this->fp) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Converts the rows from the .csv file to array
   */
  public function toArray($num_rows = NULL, $omit_first_row = TRUE) {
    $count = 0;
    $result = array();
    if($omit_first_row) {
      fgetcsv($this->fp);
    }
    while(!feof($this->fp)) {
      $result[] = fgetcsv($this->fp);

      if(!is_null($num_rows) && is_integer($num_rows)) {
        if($count > $num_rows) {
          break;
        }
      }
      $count++;
    }
    return $result;
  }
}
