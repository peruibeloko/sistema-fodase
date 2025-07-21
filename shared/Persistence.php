<?php

class Persistence {
  private $path;

  function __construct(private $repo) {
    $fullpath = __DIR__ . "/data";
    if (!file_exists($fullpath)) {
      mkdir($fullpath);
    }
    $this->path = $fullpath;
  }

  private function data_file() {
    return $this->path . "/$this->repo.json";
  }

  private function read_data_file() {
    if (!file_exists($this->data_file())) {
      $result = file_put_contents($this->data_file(), json_encode([]));
      if ($result === false) {
        return false;
      }
    }
    return json_decode(file_get_contents($this->data_file()));
  }

  private function write_data_file(mixed $data) {
    return file_put_contents($this->data_file(), json_encode($data));
  }

  /** Creates a new entry in the repo data file
   * @param mixed $data The value to write
   * @return mixed The new entry's ID (index), or `false` on faliure
   */
  function create(mixed $data) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) {
      $result = $this->write_data_file([$data]);
      if ($result === false) {
        return false;
      }
      return 0;
    }

    $current_size = count($stored_data);
    $new_data = [...$stored_data, $data];
    $result = $this->write_data_file($new_data);
    if ($result == false) {
      return false;
    }
    return $current_size;
  }

  /** Reads an entry from the datafile
   * @param int $id The entry index
   * @return mixed Either the entry on success or `null` otherwise
   */
  function read(int $id) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) {
      return null;
    }

    if ($id >= count($stored_data)) {
      return null;
    }

    return $stored_data[$id];
  }

  /** Replaces an entry in the datafile
   * @param int $id The entry index
   * @param mixed $data The new entry data
   * @return boolean If the operation succeded
   */
  function replace(int $id, mixed $data) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) {
      return false;
    }

    if ($id >= count($stored_data)) {
      return false;
    }

    $stored_data[$id] = $data;
    $this->write_data_file($stored_data);
    return true;
  }

  /** Removes an entry from the datafile
   * @param int $id The entry index
   * @return boolean If the operation succeded
   */
  function delete(int $id) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) {
      return false;
    }

    if ($id >= count($stored_data)) {
      return false;
    }

    $new_data = [...array_slice($stored_data, 0, $id), ...array_slice($stored_data, $id)];
    $result = $this->write_data_file($new_data);
    if ($result === false) {
      return false;
    }
    return true;
  }
}
