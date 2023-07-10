<?php
/*

Reads a CSV file in chunks of 10 lines at a time 
and returns them in an array of objects for processing.

Assumes the first line of the CSV file has headings 
that will be used as the object name for the item you are 
processing.  i.e. the heading is CurrentURL then refer to 
 $item->CurrentURL

*/


$filename = '/home1/zapbolib/public_html/hotel_master.tsv';
// Count them, then grab them in chunks of 10.

$rows = _csv_row_count($filename);
$items_per_run = 10;
for ($i=0; $i <= $rows; $i = $i+$items_per_run+1) {
  $chunk = _csv_slice($filename, $i, $items_per_run);
  foreach ($chunk as $item) {
    echo "$i - item category \n"; //Note CurrentURL is a case sensitive  
  }
}


/**
 * Count the number of rows in a CSV file excluding header row.
 *
 * @param string $filename
 *   CSV filename.
 *
 * @return int
 *   Number of rows.
 */
function _csv_row_count($filename) {
  ini_set('auto_detect_line_endings', TRUE);
  $row_count = 0;
  if (($handle = fopen($filename, "r")) !== FALSE) {
    while (($row_data = fgetcsv($handle, 2000, ",")) !== FALSE) {
      $row_count++;
    }
    fclose($handle);
    // Exclude the headings.
    $row_count--;
    return $row_count;
  }
}

/**
 * Load desired_count rows from filename starting at position start.
 *
 * @param string $filename
 *   CSV filename.
 * @param int $start
 *   Starting position in file.
 * @param int $desired_count
 *   Count of rows requested.
 *
 * @return array|bool
 *   Array of Objects or FALSE
 */
function _csv_slice($filename, $start, $desired_count) {
  $row = 0;
  $count = 0;
  $rows = array();
  if (($handle = fopen($filename, "r")) === FALSE) {
    return FALSE;
  }
  while (($row_data = fgetcsv($handle, 2000, ",")) !== FALSE) {
    // Grab headings.
    if ($row == 0) {
      $headings = $row_data;
      $row++;
      continue;
    }

    // Not there yet.
    if ($row++ < $start) {
      continue;
    }

    $rows[] = (object) array_combine($headings, $row_data);
    $count++;
    if ($count == $desired_count) {
      return $rows;
    }
  }
  return $rows;
}
?>