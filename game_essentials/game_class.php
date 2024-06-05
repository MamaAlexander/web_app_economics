<?php
session_start();


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

  function set_error($error) {
    try {
      $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
      $id = $_SESSION['count_id'];
      $sth = $dbh->prepare("UPDATE country_data SET error = :error WHERE `country_id` = :id");
      $sth->execute(array('error' => $error, 'id' => $id));
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
      $id = $_SESSION['count_id'];
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
    $this->set_message("Ошибка подключения: " . $e->getMessage());
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
  $this->set_country_data('gdp', 1000);
  $this->set_country_data('credits', 20);
  $this->set_country_data('num_of_steps', 100);
  $this->set_country_data('gov_budget', 'balanced');
  $this->set_country_data('inf_rate', 5);
  $this->set_country_data('unemploym_rate', 5);
  $this->set_country_data('message', $message);
  $this->set_country_data('error', '');
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
      $this->set_message("Ошибка подключения: " . $e->getMessage());
      die($e->getMessage());
      return null;
    } finally {
      $dbh = null;
      $sth = null;
    }
  }
  
}

?>