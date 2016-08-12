<?

$testDictionaryArray = array(
'Fernando',
'Abad',
'Matt',
'Barnes',
'Clay',
'Buchholz',
'Roenis',
'Elias',
'Craig',
'Kimbrel',
'Drew',
'Pomeranz',
'Rick',
'Porcello',
'David',
'Price',
'Eduardo',
'Rodriguez',
'Robbie ',
'Ross Jr.',
'Junichi',
'Tazawa',
'Steven',
'Wright',
'Brad',
'Ziegler',
'Bryan',
'Holaday',
'Sandy',
'Leon',
'Xander',
'Bogaerts',
'Aaron',
'Hill',
'Dustin',
'Pedroia',
'Hanley',
'Ramirez',
'Travis',
'Shaw',
'Andrew',
'Benintendi',
'Mookie',
'Betts',
'Jackie ',
'Bradley Jr.',
'Brock',
'Holt',
'David',
'Ortiz',
);


function findClosestWord($query, $dictionary, $acceptableDistance = 2){
  $shortest = -1;

  $closest = [];

  $lower_query = trim(strtolower($query));

  foreach ($dictionary as $word) {
    $lower_word = strtolower($word);
    $lev = levenshtein($lower_query, $lower_word);

    // echo $word . ': ' . $lev."<br>";

    // if exact match
    if ($lev == 0) {

      $closest = [$word];
      $shortest = 0;

      break;
    }

    // if this distance is less than the next found shortest
    // distance, OR if a next shortest word has not yet been found
    if ($lev <= $shortest || $shortest < 0) {
      if($lev < $shortest) {
        $closest = [$word];
        // array_push($closest, $word);
      }
      else{
        array_push($closest, $word);

      }
        $shortest = $lev;
     }
  }

  echo "Input word: ". $query."<br>";

  // if the query is close enough to a word
  if ($shortest <= $acceptableDistance) {
    if ($shortest == 0) {
      echo "Exact match found: ". $closest[0]."<br>";
    }
    else {
      echo "Here are ".count($closest)." close matches:<br>";
      foreach ($closest as $word) {
          echo $word."<br>";
      }
    }
  }
  else{
    echo "no close matches";
  }

  echo '<br>';
  echo '<br>';


}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Levenshtein</title>
  </head>
  <body>
    <?
      if (isset($_POST['query'])) {
        $query = $_POST['query'];
        findClosestWord($query, $testDictionaryArray, 2);
      }
    ?>

    <form class="" action="" method="post">
      <label for="query">Input string to compare against Red Sox Roster names.</label><br>
      <input type="text" name="query" id="query" autofocus>
      <input type="submit">
    </form>
  </body>
</html>
