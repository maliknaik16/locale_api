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
   *
   * @var string $file_name
   */
  protected $file_name;

  /**
   * File pointer for the .csv file
   *
   * @var FILE $fp
   */
  protected $fp;

  /**
   * Initializes the $file
   *
   * @param string $file_name
   *  Name of the .csv file
   */
  public function __construct($file_name) {
    $this->file_name = $file_name;
    if(file_exists($file_name)) {
      $this->fp = fopen($this->file_name, "r");
    }
  }

  /**
   * Returns if the file pointer is initialized
   *
   * @return boolean
   */
  public function isFileOpen() {
    if(!$this->fp) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Converts the rows from the .csv file to array
   * @param int $num_rows
   *  Limit the conversion to this number of rows
   * @param boolean $omit_first_row
   *  If TRUE then it omits the first row from the .csv file
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

  /**
   * Returns the header of the .csv file
   *
   * @return array
   *  Array containing the fields of the .csv file usually they are present at
   *  the first row.
   */
  public function getHeader() {
    fseek($this->fp, 0);

    return fgetcsv($this->fp);
  }
}
