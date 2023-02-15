<?php
function number_checker($pending_number){ 
    require("conn.php");
    include("usd_converter.php");

    $user_input = $pending_number;

    $ones_arr = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", 
    "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen");

    $bytens_arr = array("", "", "twenty", "thirty", "fourty", "fifty", "sixty", "seventy", "eighty", "ninety");

    $levels_arr  = array("", "thousand", "million", "billion");

    //get the length of the number
    $num_length = strlen($pending_number);
    $pending_number = intval($pending_number);

    //how many array it will make
    $dupli_levels = $levels = (int)(($num_length+2)/3);

    //exact digits of whole array
    $max_length = $levels * 3;
   
    //add 00 or 0 at the beginning if the maxlength is not occupied
    $pending_number = substr( '00'.$pending_number , -$max_length );
    

    //make the number to array that every index have three digits
    $num_levels = str_split($pending_number, 3);
    

    //check the split array of numbers
    foreach($num_levels as $num_levels_parts) {
        $levels--;
        //divide 100 to get the first number
        $hundreds = (int)($num_levels_parts / 100);

        //the result will be exact to the index of digit
        $hundreds = ($hundreds ? ' ' . $ones_arr[$hundreds] . ' hundred' . ' ' : '' );
        
        //remainder of the hundreds
        $tens=(int)($num_levels_parts % 100);
        
        $singles='';
        
        $zero='';

        //20 and above
        if ($tens>=20){
            //divide it to 10 to get the first number
            $tens = (int)($tens / 10);

            //the result will be exact to the index of digit of by tens array
            $tens = ($tens ? ' ' . $bytens_arr[$tens] . ' ' : '' );

            //remainder of by ten
            $singles=(int)($num_levels_parts % 10);

            $singles = ($singles ? ' ' . $ones_arr[$singles] . ' ' : '' );

        }
        //19 and below
        else {
            //if the input is only 0
            if ($dupli_levels==1 && substr($pending_number, 0, 3) == 0){
                $zero = $ones_arr[0];
                $tens = '';
            }
            else {
                $tens = ($tens ? $ones_arr[$tens] : '');
            }
        }
                                                            //check if the levels have still number and the current number is not only 0
        $output[] = $hundreds . $tens . $singles . $zero . ($levels && (int)($num_levels_parts) ? ' ' . $levels_arr[$levels] . ' ' : '');
    }

    strtoupper($final_output = implode( ' ' , $output));

    //insert in database
    if(!is_null($final_output)){
        $sql = "INSERT INTO user_input (input, user_output) VALUES ('$user_input', '$final_output')";
        mysqli_query($con, $sql);
        usd_converter($user_input);       
    }
    echo $final_output;
}