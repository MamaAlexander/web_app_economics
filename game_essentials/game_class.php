<?php
function getCountryIdFromFile() {
  $filename = __DIR__ . '/country_id.txt';
  if (!file_exists($filename)) {
      echo "File not found: $filename";
      return false;
  }
  
  $text = file_get_contents($filename);
  $text = trim($text); // Trim whitespace
  
  if ($text === '') {
      echo "File is empty";
      return false;
  }
  return $text;
}
class Country {
  // Properties
  public $name;
  public $gdp;
  public $credits;
  public $gov_budget;
  public $actions;
  public $actions_finance_market;
  public $actions_households;
  public $actions_firms;
  public $inf_rate;
  public $unemploym_rate;
  public $message;
  public $error;
  public $num_of_steps;
  public function __construct() {
    $this->message = '';
    $this->error = '';
    $this->num_of_steps = 100;
    $this->gdp = 1000;
    $this->gov_budget = 'balanced';
    $this->credits = 20;
    $this->inf_rate = 5;
    $this->unemploym_rate = 5;
    $this->actions = ['Finance market', ['Rate percent', 'Reservation rate', 'Issue of government bonds'],
                      'Households', ['Transferts', 'Taxes'],
                      'Firms', ['Transferts', 'Taxes'],
                      'Another world', ['Embargo', 'Duties']];
    $this->actions_finance_market = [ 'Rate percent', ['Increase', 'Decrease'],
                                      'Reservation rate', ['Increase', 'Decrease'],
                                      'Issue of government bonds', ['Release more long-term bonds', 'Release more short-term bonds']];
    $this->actions_households = [ 'Transferts', ['Increase', 'Decrease'],
                                  'Taxes', ['Increase', 'Decrease']];
    $this->actions_firms = [ 'Transferts', ['Increase', 'Decrease'],
                                  'Taxes', ['Increase', 'Decrease']];

  }
  function is_file_empty() { // Methods
    $filename = __DIR__ . '/country_id.txt';
    $text = file_get_contents($filename);
    if ($text == '') {
      $this->error = 'Game session is not started!';
      return 0;
    } else {
      return $text;
    }
  }
  function set_name($name) {
    $this->name = $name;
  }
  function set_gdp($gdp) {
    $this->gdp = $gdp;
  }
  function set_gov_budget($gov_budget) {
    $this->gov_budget = $gov_budget;
  }
  function set_inf_rate($inf_rate) {
    $this->inf_rate = $inf_rate;
  }
  function set_unemploym_rate($unemploym_rate) {
    $this->unemploym_rate = $unemploym_rate;
    $conn = new mysqli("localhost", "root", "", "web_app_econ");
    if ($conn->connect_error) {
      $this->error = "Ошибка: " . $conn->connect_error;
      return 1;
    }
    $id = getCountryIdFromFile();
    $sql = "UPDATE country_data SET unemploym_rate = '$unemploym_rate' WHERE id = '$id'; ";
    $result = $conn->query($sql);
    if (!$result) {
      $this->error = "Ошибка: " . $conn->error;
      return 1;
    }
    return 0;
  }
  function set_error($error) {
    try {
      $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
      $id = getCountryIdFromFile();
      $sth = $dbh->prepare("UPDATE country_data SET error = :name WHERE `country_id` = :id");
      $sth->execute(array('name' => $error, 'id' => $id));
    } catch (PDOException $e) {
        $this->error = "Ошибка: " . $e->getMessage();
        return 1;
    } finally {
        $dbh = null;
        $sth = null;
    }
  }
  function set_message($message) {
    try {
      $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
      $id = getCountryIdFromFile();
      $sth = $dbh->prepare("UPDATE country_data SET message = :message WHERE `country_id` = :id");
      $sth->execute(array('message' => $message, 'id' => $id));
    } catch (PDOException $e) {
        $this->error = "Ошибка: " . $e->getMessage();
        return 1;
    } finally {
        $dbh = null;
        $sth = null;
    }
}
function get_country_data() {
  try {
    $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
    $sth = $dbh->prepare("SELECT * FROM country_data WHERE `country_id` = :id");
    $id = getCountryIdFromFile();
    $sth->execute(array('id' => $id));
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    return $array;
  } catch (PDOException $e) {
    error_log("Ошибка подключения: " . $e->getMessage());
    $this->set_message("Ошибка подключения: " . $e->getMessage());
    die($e->getMessage());
    return null;
  } finally {
    $dbh = null;
    $sth = null;
  }
}
  function decrease_credits($cr) {
    if ($this->credits >= $cr) {
      $this->credits -= $cr;
    } else {
      $this->message = "You don't have anymore credits";
    }
  }
  // function start_new_game($country_name) {
  //   $conn = new mysqli("localhost", "root", "", "web_app_econ");
  //   if ($conn->connect_error) {
  //     $this->error = "Ошибка: " . $conn->connect_error;
  //   }
  //   $_message = 'Your country is ' . $this->get_name() . ' with ' . $this->get_gdp() . 
  //                    ' GPD, ' . $this->get_inf_rate() . '% of inflation, ' . $this->get_unemploym_rate() . 
  //                    '% unemployment rate and ' . $this->get_gov_budget() . ' budget policy.';
  //   $id = getCountryIdFromFile();
  //   $sql = "INSERT INTO country_data VALUES ('$id', '$country_name', 1000, 20, 'balanced', 5, 5, '$_message', '', 100);";
  //   $result = $conn->query($sql);
  //   if (!$result) {
  //     $this->error = "Ошибка: " . $conn->error;
  //   }
  // }
}
?>