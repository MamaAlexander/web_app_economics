<?php
session_start();

class Country {
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
      $dbh = new PDO('mysql:host=localhost;dbname=web_app_econ', 'root', '');
      $count_id = md5(microtime(true));
      $_SESSION['count_id'] = $count_id;
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
    $dbh = new PDO('mysql:host=localhost;dbname=web_app_econ', 'root', '');
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
  $dbh = new PDO('mysql:host=localhost;dbname=web_app_econ', 'root', '');
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
  $this->set_country_data('gdp', 5000);
  $this->set_country_data('credits', 20);
  $this->set_country_data('num_of_steps', 10);
  $this->set_country_data('gov_budget', 'balanced');
  $this->set_country_data('inf_rate', 2);
  $this->set_country_data('unemploym_rate', 5);
  $this->set_country_data('message', $message);
  $this->set_country_data('percent_rate', 3);
  $this->set_country_data('reservation_rate', 10);
  $this->set_country_data('hh_transferts', 100000);
  $this->set_country_data('hh_taxes', 15);
  $this->set_country_data('f_transferts', 100000);
  $this->set_country_data('f_taxes', 20);
  $this->set_country_data('fixed_bonds', 1);
  $this->set_country_data('variable_bonds', 0);
  $this->set_country_data('indexed_bonds', 0);
  $this->set_country_data('amortisation_bonds', 1);
  }
}
function get_country_data($count_id) {
  $dbh = new PDO('mysql:host=localhost;dbname=web_app_econ', 'root', '');
  // Ensure the database connection is set
  if (!isset($dbh) || $dbh === null) {
      error_log("Database connection is not set.");
      die("Database connection is not set.");
  }

  try {
      $sql = "SELECT * FROM country_data WHERE `country_id` = :id";
      $sth = $dbh->prepare($sql);
      $sth->execute(array('id' => $count_id));
      $array = $sth->fetch(PDO::FETCH_ASSOC);
      return $array;
  } catch (PDOException $e) {
      error_log("Ошибка подключения: " . $e->getMessage());
      die("Ошибка подключения: " . $e->getMessage());
  } finally {
      // It's not recommended to set $dbh to null here as it will close the connection
      // $dbh = null;
      $sth = null;
  }
}


  function modify_country_data($data, $flag = 0) {
    foreach ($data as $key => $val) {
      $this->set_country_data($key, $val);
    }
    $this->set_fields($_SESSION['count_id']);
    $num_of_steps = 0;
    $count_data = $this->get_country_data($_SESSION['count_id']);
    if ($flag) {
      $num_of_steps = $count_data['num_of_steps'] - 1;
    }

    $Current_Expenditures = 0.3 * $data['hh_transferts'] - $data['indexed_bonds'] * rand(0, 10) * 0.3 + $data['amortisation_bonds'] * rand(0, 10) * 0.3;
    $Capital_Expenditures = 0.03 * $data['f_transferts'] - 0.04 * $data['percent_rate'] + $this->gdp * ($data['percent_rate']/100) * $data['fixed_bonds'];
    $Defense_Expenditures = 0.05 * ($data['hh_taxes'] / 100) + 0.04 * ($data['f_taxes'] / 100) + 0.1 * $data['hh_transferts'];
    $Social_Programs_Expenditures = 0.2 * $data['hh_transferts'] + 0.1 * ($data['hh_taxes'] / 100);

    $G = $Current_Expenditures + $Capital_Expenditures + $Defense_Expenditures + $Social_Programs_Expenditures;
    $C = -0.4 * $this->gdp + 0.3 * $data['hh_transferts'] * (1 - $data['hh_taxes'] / 100) + $data['variable_bonds'] * (rand(1, 50)/100) * $this->gdp;
    $I = -0.3 * $this->gdp - 0.05 * $data['percent_rate']/100 + 0.02 * $data['f_transferts'] - 0.1 * $data['f_taxes'] + $data['variable_bonds'] * (rand(1, 50)/100) * $this->gdp;

    $gdp = $C + $G + $I;

    $ind_gov_budget = (1250 - (rand(100, 1000) - $this->gdp / 100)) * ($this->gdp / 1250) * $data['hh_taxes'] / 100 - $G;
    if ($ind_gov_budget <= 5000 && $ind_gov_budget >= - 5000) {
        $gov_budget = 'balanced';
    } elseif ($ind_gov_budget > 5000) {
        $gov_budget = 'surplus';
    } else {
        $gov_budget = 'deficit';
    }    

    $CPI_cur = ($gdp / $this->gdp) * 100;
    $inf_rate = ($CPI_cur - 100) / 100 + $data['fixed_bonds'] * (rand(1, 3)/100) - $data['indexed_bonds'] * rand(0, 10)/1000;

    $unemploym_rate = 0.046 + ($inf_rate - $this->inf_rate) * 0.02;

    $this->set_country_data('gdp', $gdp);
    $this->set_country_data('gov_budget', $gov_budget);
    $this->set_country_data('inf_rate', $inf_rate);
    $this->set_country_data('unemploym_rate', $unemploym_rate);
    $this->set_country_data('num_of_steps', $num_of_steps);
    $this->set_fields($_SESSION['count_id']);
  }

  function check_winner($count_id, $op_count_id) {
    $country_data = $this->get_country_data($count_id);
    $op_country_data = $this->get_country_data($op_count_id);

    if ($country_data['gov_budget'] == 'deficit') {
      $my_budget_status = 0;
    } else if ($country_data['gov_budget'] == 'surplus')  {
      $my_budget_status = 1;
    } else {
      $my_budget_status = 2;
    }

    if ($op_country_data['gov_budget'] == 'deficit') {
      $op_budget_status = 0;
    } else if ($op_country_data['gov_budget'] == 'surplus')  {
      $op_budget_status = 1;
    } else {
      $op_budget_status = 2;
    }

    $my_est = 0.2 * $country_data['gdp'] + 0.4 * $my_budget_status + 0.3 * $country_data['inf_rate'] + 0.3 * $country_data['unemploym_rate'];
    $op_est = 0.2 * $op_country_data['gdp'] + 0.4 * $op_budget_status + 0.3 * $op_country_data['inf_rate'] + 0.3 * $op_country_data['unemploym_rate'];
    if ($my_est > $op_est) {
      return 1;
    } else {
      return 0;
    
  }
}
}

?>