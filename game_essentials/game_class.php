<?php
session_start();


class Country {
  // Properties
  public $name;
  public $gdp;
  public $gov_budget;
  public $actions;
  public $actions_finance_market;
  public $actions_households;
  public $actions_firms;
  public $inf_rate;
  public $unemploym_rate;
  public $num_of_steps;
  public $error;

  public $percent_rate;
  public $reservation_rate;
  public $hh_transferts;
  public $hh_taxes;
  public $f_transferts;
  public $f_taxes;
  public $fixed_bonds;
  public $variable_bonds;
  public $indexed_bonds;
  public $amortisation_bonds;
  public function __construct() {
    
  }
  function set_fields($count_id) {
    $array = $this->get_country_data($count_id);
    $this->name = $array["name"];
    $this->gdp = $array["gdp"];
    $this->gov_budget = $array["gov_budget"];
    $this->inf_rate = $array["inf_rate"];
    $this->unemploym_rate = $array["inf_rate"];
    $this->num_of_steps = $array["num_of_steps"];
    $this->percent_rate = $array["percent_rate"];
    $this->reservation_rate = $array["reservation_rate"];
    $this->hh_transferts = $array["hh_transferts"];
    $this->hh_taxes = $array["hh_taxes"];
    $this->f_transferts = $array["f_transferts"];
    $this->f_taxes = $array["f_taxes"];
    $this->fixed_bonds = $array["fixed_bonds"];
    $this->variable_bonds = $array["variable_bonds"];
    $this->indexed_bonds = $array["indexed_bonds"];
    $this->amortisation_bonds = $array["amortisation_bonds"];
  }
  function set_new_string($count_name) {
    try {
      $count_id = md5(microtime(true));
      $_SESSION['count_id'] = $count_id;
      $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
      $sth = $dbh->prepare("INSERT INTO country_data (country_id, name) VALUES (:cid, :cname)");
      $sth->execute(array('cid' => $count_id, 'cname' => $count_name));

      $sth = $dbh->prepare("UPDATE web_session SET country_id = :count_id WHERE user_id = :user_id and cookie_id = :session_id;");
      $user_id = $_SESSION['user_id'];
      $session_id = $_SESSION['session_id'];
      $sth->execute(array('count_id' => $count_id, 'user_id' => $user_id, 'session_id' => $session_id));

    } catch (PDOException $e) {
        $error = "Ошибка: " . $e->getMessage();
        return $error;
    } finally {
        $dbh = null;
        $sth = null;
    }
  }

  function set_country_data($field, $value) {
  try {
    $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
    $sql = "UPDATE country_data SET $field = :value WHERE country_id = :id";
    $sth = $dbh->prepare($sql);
    $id = $_SESSION['count_id'];
    $sth->execute(['value' => $value, 'id' => $id]);
  } catch (PDOException $e) {
    error_log("Ошибка подключения: " . $e->getMessage());
    die($e->getMessage());
    return null;
  } finally {
    $dbh = null;
    $sth = null;
  }
}

function set_new_country($name) {
  $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
  $sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
  $session_id = $_SESSION['session_id'];
  $user_id = $_SESSION['user_id'];
  $sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
  $array = $sth->fetch(PDO::FETCH_ASSOC);
  if ($array['country_id'] != 0) {
    $flag =  1;
  } else {
    $flag = 0;
  }
  if (!$flag) {
  $message = 'Your country is ' . '<b>' . $name . '</b>' . ' with indicators located above';
  $this->set_new_string($name);
  $this->set_country_data('gdp', 20000);
  $this->set_country_data('credits', 20);
  $this->set_country_data('num_of_steps', 100);
  $this->set_country_data('gov_budget', 'balanced');
  $this->set_country_data('inf_rate', 2);
  $this->set_country_data('unemploym_rate', 5);
  $this->set_country_data('message', $message);
  $this->set_country_data('percent_rate', 3);
  $this->set_country_data('reservation_rate', 10);
  $this->set_country_data('hh_transferts', 1000);
  $this->set_country_data('hh_taxes', 15);
  $this->set_country_data('f_transferts', 5000);
  $this->set_country_data('f_taxes', 20);
  $this->set_country_data('fixed_bonds', 1);
  $this->set_country_data('variable_bonds', 0);
  $this->set_country_data('indexed_bonds', 0);
  $this->set_country_data('amortisation_bonds', 1);
  }
}
function get_country_data($count_id) {
    try {
      $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
      $sth = $dbh->prepare("SELECT * FROM country_data WHERE `country_id` = :id");
      $sth->execute(array('id' => $count_id));
      $array = $sth->fetch(PDO::FETCH_ASSOC);
      return $array;
    } catch (PDOException $e) {
      error_log("Ошибка подключения: " . $e->getMessage());
      die($e->getMessage());
      return null;
    } finally {
      $dbh = null;
      $sth = null;
    }
  }

  // function modify_country_data() {
    
  // }
  
}

?>