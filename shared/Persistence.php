<?php

class Persistence {
  private $path;

  private function id() {
    return bin2hex(random_bytes(16));
  }

  function __construct(private $repo) {
    $fullpath = __DIR__ . "/../data";

    if (!file_exists($fullpath)) mkdir($fullpath);

    $this->path = $fullpath;
  }

  private function data_file() {
    return $this->path . "/$this->repo.json";
  }

  private function read_data_file() {
    if (!file_exists($this->data_file())) {
      $result = file_put_contents($this->data_file(), "");

      if ($result === false) return false;
    }

    return json_decode(file_get_contents($this->data_file()), true);
  }

  private function write_data_file(mixed $data) {
    return file_put_contents($this->data_file(), json_encode($data));
  }

  /** Creates a new entry in the repo data file
   * @param mixed $data The value to write
   * @return mixed The new entry"s ID, or `false` on faliure
   */
  function create(mixed $data) {
    $stored_data = $this->read_data_file();

    $id = $this->id();

    if ($stored_data === null) {
      $result = $this->write_data_file([$id => $data]);

      if ($result === false) return false;

      return $id;
    }

    $new_data = [...$stored_data, $id => $data];
    $result = $this->write_data_file($new_data);

    if ($result == false) return false;

    return $id;
  }

  /** Reads an entry from the datafile
   * @param string $id The entry ID
   * @return mixed Either the entry on success or `null` otherwise
   */
  function read(string|null $id) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) return null;
    if ($id === null) return $stored_data;
    if (!array_key_exists($id, $stored_data)) return false;

    return $stored_data[$id];
  }

  /** Replaces an entry in the datafile
   * @param string $id The entry ID
   * @param mixed $data The new entry data
   * @return boolean If the operation succeded
   */
  function replace(string $id, mixed $data) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) return false;
    if (!array_key_exists($id, $stored_data)) return false;

    $stored_data[$id] = $data;
    $this->write_data_file($stored_data);

    return true;
  }

  /** Removes an entry from the datafile
   * @param string $id The entry ID
   * @return boolean If the operation succeded
   */
  function delete(string $id) {
    $stored_data = $this->read_data_file();

    if ($stored_data === false) return false;
    if (!array_key_exists($id, $stored_data)) return false;

    unset($stored_data[$id]);
    $result = $this->write_data_file($stored_data);

    if ($result === false) return false;

    return true;
  }
}
