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


  function set_fields($count_id) { // Поля класса подгружаются из базы данных где ID = $count_id
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
  function set_new_string($count_name) { // Создание новой строки в таблице country_data, используется в методе для создания новой страны
    try {
      $dbh = new PDO('mysql:host=80.85.153.48;dbname=web_app_econ', 'remboplas', '053107720User!');
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
        $sth = null;
    }
  }

  function set_country_data($field, $value) { // Обновление данных в таблице: $field - название столбца, $value - значение
  try {
    $dbh = new PDO('mysql:host=80.85.153.48;dbname=web_app_econ', 'remboplas', '053107720User!');
    $sql = "UPDATE country_data SET $field = :value WHERE country_id = :id";
    $sth = $dbh->prepare($sql);
    $id = $_SESSION['count_id'];
    $sth->execute(['value' => $value, 'id' => $id]);
  } catch (PDOException $e) {
    error_log("Ошибка подключения: " . $e->getMessage());
    die($e->getMessage());
    return null;
  } finally {
    $sth = null;
  }
}

function set_new_country($name) { // Создание новой страны с названием $name
  $dbh = new PDO('mysql:host=80.85.153.48;dbname=web_app_econ', 'remboplas', '053107720User!');
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
  $this->set_country_data('gdp', 1521071);
  $this->set_country_data('credits', 20);
  $this->set_country_data('num_of_steps', 10);
  $this->set_country_data('gov_budget', 'deficit');
  $this->set_country_data('inf_rate', 16);
  $this->set_country_data('unemploym_rate', 4);
  $this->set_country_data('message', $message);
  $this->set_country_data('percent_rate', 3);
  $this->set_country_data('reservation_rate', 3);
  $this->set_country_data('hh_transferts', 7500000000000);
  $this->set_country_data('hh_taxes', 17);
  $this->set_country_data('f_transferts', 19500000);
  $this->set_country_data('f_taxes', 30);
  $this->set_country_data('fixed_bonds', 0);
  $this->set_country_data('variable_bonds', 0);
  $this->set_country_data('indexed_bonds', 0);
  $this->set_country_data('amortisation_bonds', 0);
  }
}
function get_country_data($count_id) { // Возвращение словаря {column_name: value} для страны с ID = $count_id
  $dbh = new PDO('mysql:host=80.85.153.48;dbname=web_app_econ', 'remboplas', '053107720User!');
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
      $sth = null;
  }
}

  function modify_country_data($data, $flag = 0) { // перед переходом к новому раунду подсчитываются значения ввп, инфляции, безработицы, бюджета
    foreach ($data as $key => $val) {              // $data - словарь индикаторов с новыми значениями, которые нужно посчитать
      $this->set_country_data($key, $val);         // если $flag == 1, то количество шагов уменьшается на 1
    }
    $this->set_fields($_SESSION['count_id']);
    $num_of_steps = 0;
    $count_data = $this->get_country_data($_SESSION['count_id']);
    $num_of_steps = $count_data['num_of_steps'];
    if ($flag) {
      $num_of_steps = $count_data['num_of_steps'] - 1;
    }

    $Capital_Expenditures = 4000000000000; //0.03 * $data['f_transferts']/25000000 - 0.04 * $data['percent_rate'] + $this->gdp * ($data['percent_rate']/100) * $data['fixed_bonds'];
    $Defense_Expenditures = 11000000000000;
    $Social_Programs_Expenditures = $data['hh_transferts'] + $data['f_transferts'];

    $G = $Capital_Expenditures + $Defense_Expenditures + $Social_Programs_Expenditures;
    $C = (1 - $data['hh_taxes'] / 100)*0.0004*0.33*$this->gdp * (1 + $this->inf_rate/100);//-0.4 * $this->gdp + 0.3 * $data['hh_transferts'] * (1 - $data['hh_taxes'] / 100)/1460000 + $data['variable_bonds'] * (rand(1, 50)/100) * $this->gdp;
    $I = (1 - $this->percent_rate/100)*(1 - $data['f_taxes']/100)*(1/$data['reservation_rate'])*((1 - $data['hh_taxes'] / 100)*0.0004*0.66*$this->gdp * (1 + $this->inf_rate/100) + 0.33*$this->gdp*2500000);//-0.3 * $this->gdp - 0.05 * $data['percent_rate']/100 + 0.02 * $data['f_transferts']/25000000 - 0.1 * $data['f_taxes'] + $data['variable_bonds'] * (rand(1, 50)/100) * $this->gdp;

    $gdp = ($C + $G + $I)/1460000;

    $ind_gov_budget = 1460000*0.0004*$this->gdp*(1 - $data['hh_taxes']/100) + 25000000*2666666*0.0004*$this->gdp*(1 - $data['f_taxes']/100) - $G;
    if ($ind_gov_budget <= 100000 && $ind_gov_budget >= - 100000) {
        $gov_budget = 'balanced';
    } elseif ($ind_gov_budget > 100000) {
        $gov_budget = 'surplus';
    } else {
        $gov_budget = 'deficit';
    }    

    $CPI_cur = ($gdp / $this->gdp) * 100;
    $inf_rate = ($CPI_cur - 100) / 100 + $data['fixed_bonds'] * (rand(1, 3)/100) - $data['indexed_bonds'] * rand(0, 3)/100;

    $unemploym_rate = 0.046 + ($inf_rate - $this->inf_rate) * 0.02;

    $this->set_country_data('gdp', $gdp);
    $this->set_country_data('gov_budget', $gov_budget);
    $this->set_country_data('inf_rate', $inf_rate);
    $this->set_country_data('unemploym_rate', $unemploym_rate);
    $this->set_country_data('num_of_steps', $num_of_steps);
    $this->set_fields($_SESSION['count_id']);
  }

  function check_winner($count_id, $op_count_id) {            // метод определения победителя, выдает булевое значение: 1 - если id страны выигрышный, 0 иначе
    $country_data = $this->get_country_data($count_id);       // для победы нужно чтобы индекс моей страны был больше индекса страны противника
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