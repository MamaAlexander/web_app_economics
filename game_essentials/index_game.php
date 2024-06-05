<?php
session_start();
include_once('game_class.php');
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION["user_id"];
$game_id = $_SESSION['game_id'];
$message = '';
$error = '';
$your_country = new Country();
$op_country = new Country();

$dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
$sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
$session_id = $_SESSION['session_id'];

$sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
$array = $sth->fetch(PDO::FETCH_ASSOC);


if ($array['country_id'] == 0) {
  $your_country->set_new_country($_GET['country_name']);
}

$sth = $dbh->prepare("SELECT * FROM game_sessions WHERE game_id = :game_id");
$sth->execute(array('game_id' => $game_id));
$array2 = $sth->fetch(PDO::FETCH_ASSOC);

if ($array2['country1_id'] == 0 and $array2['country2_id'] == 0) {
  $country = $your_country->get_country_data($_SESSION["count_id"]);
  $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
  $query = "UPDATE game_sessions SET country1_id = :value WHERE game_id = :id";
  $sth = $dbh->prepare($query);
  $sth->execute(array('value' => $country['country_id'], 'id' => $game_id));
} else if ($array2['country1_id'] != $_SESSION['count_id'] and $array2['country2_id'] == 0) {
  $country = $your_country->get_country_data($_SESSION["count_id"]);
  $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
  $query = "UPDATE game_sessions SET country2_id = :value WHERE game_id = :id";
  $sth = $dbh->prepare($query);
  $sth->execute(array('value' => $country['country_id'], 'id' => $game_id));
} else {
  $country = $your_country->get_country_data($_SESSION["count_id"]);
}

// Determine the opponent country ID
if ($country['country_id'] == $array2['country1_id']) {
  $opponent_country_id = $array2['country2_id'];
} else {
  $opponent_country_id = $array2['country1_id'];
}
if ($array2['country2_id'] != 0 and $array2['country1_id'] != 0) {
  $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
  $sth = $dbh->prepare("SELECT * FROM country_data WHERE `country_id` = :id");
  $sth->execute(array('id' => $opponent_country_id));
  $array6 = $sth->fetch(PDO::FETCH_ASSOC);
  $opponent_country = $array6;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="index.css">
</head>
<style>
  body {
    margin: 0;
    padding: 0;
    background-image: url(../v904-nunny-012.jpg);
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 100vh;
  }
  input {
    border-radius: 10px; 
    overflow: hidden; 
    min-heigt: 40px; 
    outline: 4px black solid;
  }
  #resized {
    border-radius: 10px; 
    overflow: hidden; 
    min-heigt: 40px; 
    outline: 4px black solid;
  }
  .input-container, .summary-container {
      margin: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 45%;
  }
  .summary-container {
      overflow-y: auto;
      max-height: 400px;
  }
  .summary-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 5px 0;
      padding: 5px;
      border: 1px solid #ddd;
      border-radius: 3px;
  }
  .summary-item button {
      margin-left: 10px;
      padding: 3px 6px;
  }
  .submitButton {
      display: inline-block;
      font-weight: 400;
      text-align: center;
      vertical-align: middle;
      float: right;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: 20px;
      transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      color: #212529;
      background-color: #f8f9fa;
      border-color: #f8f9fa;
  }
</style>
<body>
<div style='margin-left: 10px; margin-top: -40px; float: left;'><h4><?php echo 'game code: ' . $_SESSION['game_id']; ?></h4></div>
<div style="margin-top: -40px; margin-right: 15px; float: right;" id="resized"><a href="../profile/profile.php"><input type="button" name="login" class="btn btn-light" value="Go to profile"></a></div>

<div class="container" style="margin-top: 60px; padding-top: 30px;"> 
<h4>Your country:</h4>
  <div class="card text-dark bg-light mb-3" id ="resized" style="border-radius: 15px; outline: 4px black solid;">  
    <div class="row" style="align-items: center;">
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 15px; margin-right: 8px;">
        <?php
        echo '<b>' . $country['name'] . '</b>';
        ?>
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 8px;">
        <?php
        echo '<b>' . "GDP" . '</b>' ."<br>" . $country['gdp'];
        ?>
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 8px;">
        <?php
        echo '<b>' . "State budget status" . '</b>' . "<br>" . $country['gov_budget'];
        ?>
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 8px;">
        <?php
        echo '<b>' . "Rate of inflation" . '</b>' . "<br>" . $country['inf_rate'] . '%';
        ?>
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 15px;">
        <?php
        echo '<b>' . "Unemployment rate" . '</b>' . "<br>" . $country['unemploym_rate'] . '%';
        ?>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($opponent_country)) {
  echo '
<div class="container" style="margin-top: 30px; padding-top: 30px;"> 
<h4>Opponent country:</h4>
  <div class="card text-dark bg-light mb-3" id ="resized" style="border-radius: 15px; outline: 4px black solid;">  
    <div class="row" style="align-items: center;">
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 15px; margin-right: 8px;">';
        echo "<b>" . $opponent_country["name"] . "</b>" . '
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 8px;">';
        echo "<b>" . "GDP" . "</b>" ."<br>" . $opponent_country["gdp"] . '
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 8px;">';
        echo "<b>" . "State budget status" . "</b>" . "<br>" . $opponent_country["gov_budget"] . '
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 8px;">';
        echo "<b>" . "Rate of inflation" . "</b>" . "<br>" . $opponent_country["inf_rate"] . "%" . '
      </div>
      <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 8px; margin-right: 15px;">';
        echo "<b>" . "Unemployment rate" . "</b>" . "<br>" . $opponent_country["unemploym_rate"] . "%" . '
      </div>
    </div>
  </div>
</div>';
} else {
  echo 
  '<div class="container" style="margin-top: 30px; padding-top: 30px;"> 
    <h4>Opponent country:</h4>
    <div class="card text-dark bg-light mb-3" id ="resized">  
      <div class="row" style="align-items: center;">
        <div class="col" style="margin-top: 20px; margin-bottom: 20px; margin-left: 15px; margin-right: 8px;">
          Opponent is not loggined yet <3 <br>
          Wait him to login and reload the page
        </div>
      </div>
    </div>
  </div>';
}
?>

<!-- Error reciever -->
<div>
  <?php
  $error = $country['error'];
    if($error != '') {
        echo '<div class="alert alert-danger">'.$error.'</div>';
        $your_country->set_country_data('error', '');
        $error = '';
    }
  ?>

</div>

<!-- Message reciever -->
<div>
<?php
$message = $country['message'];
  if($message != '') {
    echo '<div class="alert alert-info" style="margin-right: 30px; margin-left: 30px;">'.$message.'</div>';
    $your_country->set_country_data('message', '');
    $message = '';
  } 
  if (isset($_GET['game_id'])) {
    echo '<div class="alert alert-info" style="margin-right: 30px; margin-left: 30px;">' . 'You started the game. Provide this number to Player 2:' . $_GET['game_id'] . '</div>';
  }
?>
</div>

<!-- <div style="margin-right: 20px; margin-top: 10px;">
    <p style="text-align:right;">
        Credits last <br>
        <b id="credits"></b>
    </p>
</div> -->

<div style="margin-right: 20px; margin-top: 10px;">
    <p style="text-align:right;">
        Credits last <br>
        <b id="credits"></b>
    </p>
</div>
<p id="errorMessage" style="color: red; text-align: right;"></p>




<div style="margin-right: 20px; margin-top: 10px;">
<p style="text-align:right;">
  <?php
  echo "Num of steps last" . "<br> <b>" . $country['num_of_steps'] . '</b>';
  ?>
  </p>
</div>


<div class="container" style="display: flex; padding-bottom: 40px">
    <div class="actions-container" style="flex: 1; margin-right: 20px;">
        <h3>Actions:</h3>
        <div class="row">
            <div class="col" style="margin-left: 20px">
                <details>
                    <summary class="no-marker" style="margin-top: 20px; width: fit-content;"><h4>Finance market</h4></summary>
                    <div class="input-group">
                        <label for="financeInput">Change percent rate</label>
                        <input type="number" id="change_percent_rate" name="Change percent rate in finance market" class="form-control" style="border-radius: 15px;"/>
                        <button class="submitButton" id="4">Submit</button>
                    </div>
                    <div class="input-group">
                        <label for="reservationInput">Change reservation rate</label>
                        <input type="number" id="change_reservation_rate" name="Change reservation rate in finance market" class="form-control" style="border-radius: 15px;"/>
                        <button class="submitButton" id="5">Submit</button>
                    </div>
                    <div class="input-group">
                        <label for="bond-select">Issue of government bonds</label>
                        <select name="Issue of government bonds in finance market" id="bond-select" class="form-control" style="">
                            <option value="0" id="0">-- Choose bonds type --</option>
                            <option value="Fixed coupon bonds" id="fixed_bonds">Fixed coupon bonds</option>
                            <option value="Variable coupon bonds" id="variable_bonds">Variable coupon bonds</option>
                            <option value="Bonds with indexed par value" id="indexed_bonds">Bonds with indexed par value</option>
                            <option value="Bonds with debt amortization" id="amortisation_bonds">Bonds with debt amortization</option>
                        </select>
                        <button class="submitButton" id="5">Submit</button>
                    </div>
                </details>
                <details>
                    <summary class="no-marker" style="margin-top: 10px; width: fit-content;"><h4>Households</h4></summary>
                    <div class="input-group">
                        <label for="transfersInput">Transfers</label>
                        <input type="number" id="households_transfers" name="Households transfers" class="form-control" style="border-radius: 15px;"/>
                        <button class="submitButton" id="3">Submit</button>
                    </div>
                    <div class="input-group">
                        <label for="taxesInput">Taxes</label>
                        <input type="number" id="households_taxes" name="Households taxes" class="form-control" style="border-radius: 15px;"/>
                        <button class="submitButton" id="5">Submit</button>
                    </div>
                </details>
                <details>
                    <summary class="no-marker" style="margin-top: 10px; width: fit-content;"><h4>Firms</h4></summary>
                    <div class="input-group">
                        <label for="firmTransfersInput">Transfers</label>
                        <input type="number" id="firm_transfers" name="Firm transfers" class="form-control" style="border-radius: 15px;"/>
                        <button class="submitButton" id="4">Submit</button>
                    </div>
                    <div class="input-group">
                        <label for="firmTaxesInput">Taxes</label>
                        <input type="number" id="firm_taxes" name="Firm taxes" class="form-control" style="border-radius: 15px;"/>
                        <button class="submitButton" id="6">Submit</button>
                    </div>
                </details>
            </div>
        </div>
    </div>
    <div class="summary-container" style="flex: 1; border: 4px solid black; border-radius: 10px; background-color: white;">
        <h2 style="display: flex; justify-content: center;">Changes</h2>
        <div id="summaryList"></div>
    </div>
</div>

<script>
    var credits = 20;
    document.getElementById('credits').textContent = credits;
    var commands = {};
    document.querySelectorAll('.submitButton').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const num = Number(this.id);
            if (credits >= num) {
                let userInput = input.value;
                const input_name = input.name;
                const input_id = input.id;
                
                
                if (input.tagName.toLowerCase() === 'select') {
                    userInput = input.options[input.selectedIndex].text;
                    commands[input.id] = input.value;
                    
                } else {
                    commands[input.id] = Number(input.value);
                }
                console.log(commands);
                if (userInput.trim() !== "" && userInput !== "-- Choose bonds type --") {
                    addSummaryItem(userInput, input_name, num, input_id);
                    credits -= num;
                    document.getElementById('credits').textContent = credits;

                    if (input.tagName.toLowerCase() === 'input') {
                        input.value = '';
                    } else if (input.tagName.toLowerCase() === 'select') {
                        input.selectedIndex = 0;
                    }
                }
                document.getElementById('errorMessage').textContent = ''; // Очистить сообщение об ошибке
            } else {
                document.getElementById('errorMessage').textContent = "All credits wasted";
            }
        });
    });

    function addSummaryItem(text, input_name, num, input_id) {
        const summaryList = document.getElementById('summaryList');
        const summaryItem = document.createElement('div');
        summaryItem.className = 'summary-item';
        summaryItem.name = num;
        summaryItem.id = input_id;

        const itemText = document.createElement('span');
        itemText.textContent = input_name + ': ' + text;
        summaryItem.appendChild(itemText);

        const removeButton = document.createElement('button');
        removeButton.innerHTML = '&times;';
        removeButton.className = 'remove-button';
        removeButton.addEventListener('click', function() {
            delete commands[summaryItem.id]; // Удаление из словаря commands
            credits += Number(summaryItem.name);
            document.getElementById('credits').textContent = credits;
            summaryList.removeChild(summaryItem);
            console.log(commands);
        });
        summaryItem.appendChild(removeButton);

        summaryList.appendChild(summaryItem);
    }
</script>

<style>
  .input-group {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-top: 10px;
  }

  .input-group label {
    margin-right: auto; 
  }

  .input-group input {
    max-width: 150px;
    margin-right: 10px;
  }

  details summary.no-marker {
    list-style: none;
  }
  
  details summary.no-marker::-webkit-details-marker {
    display: none;
  }

  .remove-button {
    background: none;
    border: none;
    color: red;
    font-size: 20px;
    cursor: pointer;
    margin-left: 10px;
  }

  .remove-button:hover {
    color: darkred;
  }
</style>

</body>
</html>