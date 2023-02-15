<?PHP
function word_checker($pending_word)
{
    require("conn.php");
    include("usd_converter.php");

    $user_input = $pending_word;

    $ones_word_arr = array(0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five", 6 => "six", 7 => "seven", 8 => "eight",
                    9 => "nine", 10 => "ten", 11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen", 16 => "sixteen",
                    17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20  => "twenty", 30 => "thirty", 40 => "fourty", 50 => "fifty", 60 => "sixty", 
                    70 => "seventy", 80 => "eighty", 90 => "ninety");

    $levels = array("1" => "and", "100" => "hundred", "1000" => "thousand", "1000000" => "million", "1000000000" => "billion");

    //make the words into an array every space is a value
    $split_words = explode(" ", strtolower($pending_word));

    $i=0;

    $SINGLE = 0;

    $thousand_up = 0;

    $final_output = '';

    //loop in every word
    foreach($split_words as $word){
        //ZERO
        if(array_search($word, $ones_word_arr) == 0){
          $final_output = '0';
        }
        //if the word is in array 
        elseif(array_search($word, $ones_word_arr) && $word!="zero"){
          $SINGLE += (int)array_search($word, $ones_word_arr);
        
        }
        //if the word contains hundred just multiply by 100
        elseif($word=="hundred"){
          $SINGLE *= (int)array_search($word, $levels);
        }
        //if the word is in levels array and it is not hundred
        elseif(array_search($word, $levels) && $word!="hundred"){
          //checker
          $i++;
          $thousand_up = $thousand_up + (int)($SINGLE) * (int)array_search($word, $levels);
          $SINGLE=0;
        }
        //if the word is not in array
        else{
          $final_output = "INVALID INPUT";
        }
    }

    //if the output is invalid
    if($final_output=='INVALID INPUT'){
      echo $final_output;
    }
    //add
    else {
      $final_output = $thousand_up + $SINGLE;
      echo number_format($final_output);
    }

    //insert in database
    if(!is_null($final_output)){
      $sql = "INSERT INTO user_input (input, user_output) VALUES ('$user_input', '$final_output')";
      mysqli_query($con, $sql);
      usd_converter($final_output);
  }
}

?>