<?php

$error = '';
// function sexit($a):
//     if (a == 'exit'){
//         print(colored('GAME OVER', 'red'));
//         sys.exit();
//     }



class country {
  // Properties
  public $name;
  public $gpd;
  public $credits;
  public $gov_budget;
  public function __construct() {
    $this->gpd = 1000;
    $this->gov_budget = 100000000000;
    $this->credits = 20;
  }

  // Methods
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
  function get_gpd() {
    return $this->gpd;
  }
  function get_gov_budget() {
    return $this->gov_budget;
  }
}

$your_country = new country();
$your_country->set_name($_POST['name']);


?>