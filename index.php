<?

$test_dictionary_array = array(
'Fernando'=>array('Abad'),
'Abad'=>array('Fernando'),
'Matt'=>array('Barnes'),
'Barnes'=>array('Matt'),
'Clay'=>array('Buccholz'),
'Buchholz'=>array("Clay"),
'Roenis'=>array('Elias'),
'Elias'=>array('Roenis'),
'Craig'=>array('Kimbrel'),
'Kimbrel'=>array('Craig'),
'Drew'=>array('Pomeranz'),
'Pomeranz'=>array('Drew'),
'Rick'=>array('Porcello'),
'Porcello'=>array('Rick'),
'David'=>array('Price', 'Ortiz'),
'Price'=>array('David'),
'Eduardo'=>array('Rodriguez'),
'Rodriguez'=>array('Eduardo'),
'Robbie'=>array('Ross Jr.'),
'Ross Jr.'=>array('Robbie'),
'Junichi'=>array('Tazawa'),
'Tazawa'=>array('Junichi'),
'Steven'=>array('Wright'),
'Wright'=>array('Steven'),
'Brad'=>array('Ziegler'),
'Ziegler'=>array('Brad'),
'Bryan'=>array('Holaday'),
'Holaday'=>array('Bryan'),
'Sandy'=>array('Leon'),
'Leon'=>array('Sandy'),
'Xander'=>array('Bogaerts'),
'Bogaerts'=>array('Xander'),
'Aaron'=>array('Hill'),
'Hill'=>array('Aaron'),
'Dustin'=>array('Pedroia'),
'Pedroia'=>array('Dustin'),
'Hanley'=>array('Ramirez'),
'Ramirez'=>array('Hanley'),
'Travis'=>array('Shaw'),
'Shaw'=>array('Travis'),
'Andrew'=>array('Benintendi'),
'Benintendi'=>array('Andrew'),
'Mookie'=>array('Betts'),
'Betts'=>array('Mookie'),
'Jackie'=>array('Bradley Jr.'),
'Bradley Jr.'=>array('Jackie'),
'Brock'=>array('Holt'),
'Holt'=>array('Brock'),
'Ortiz'=>array('David'),
);


// PASS ALREADY SUGGESTED TERM INTO THIS FUNCTION TO GET SUGGESTIONS FOR NEXT WORD
function related_terms($query, $dictionary){
  if (!isset($dictionary[$query])) {
    return false;
  }
  else{
    return $dictionary[$query];
  }
}

function spell_check($query, $dictionary, $acceptableDistance = 2){
  $shortest = -1;
  $closest = [];
  $lower_query = trim(strtolower($query));

  foreach ($dictionary as $word=>$value) {
    $lower_word = strtolower($word);
    $lev_distance = levenshtein($lower_query, $lower_word);

    // if exact match
    if ($lev_distance == 0) {
      $closest = ["terms"=>array($word)];
      $shortest = 0;
      break;
    }

    // if this matches or eclipses shortest distance
    if ($lev_distance <= $shortest || $shortest < 0) {
      // eclipses
      if($lev_distance < $shortest) {
        $closest = ["terms"=>array($word)];
      }
      // matches
      else{
        array_push($closest['terms'], $word);
      }
      $shortest = $lev_distance;
     }
  }

  if($shortest == 0){
    $closest['exact'] = true;
  }
  else{
    $closest['exact'] = false;
  }
  // if the query is close enough to a word
  if ($shortest <= $acceptableDistance) {
    return $closest;
  }
  else{
    return false;
  }

}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Levenshtein Example</title>
  </head>
  <body>
    <form class="" action="" method="post">
      <label for="query">Input string to compare against Red Sox Roster names.</label><br>
      <input type="text" name="query" id="query" autofocus value="<? echo $_POST['query'] ?>">
      <input type="submit">
    </form>
    <br>
    <?
      if (isset($_POST['query'])) {
        $query = $_POST['query'];
        echo "Input word: ". $query."<br>";
        $spell_check = spell_check($query, $test_dictionary_array, 2);
        if ($spell_check) {
          if ($spell_check['exact']) {
            echo 'Exact match:<br>';
          }
          else {
            echo 'Potential matches:<br>';
          }
          foreach ($spell_check["terms"] as $word) {
            echo $word."<br>";
          }
        }
        echo '<br>';
        if ($spell_check['exact']) {
          $related_terms = related_terms($spell_check["terms"][0], $test_dictionary_array);
          if ($related_terms) {
            echo 'Related Terms:<br>';
            foreach ($related_terms as $word) {
              echo $word."<br>";
            }
          }
        }
      }
    ?>
  </body>
</html>
