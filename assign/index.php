<!-- 
/*
 *	This content is generated from the PSD File Info.
 *	(Alt+Shift+Ctrl+I).
 *
 *	@desc 		
 *	@file 		frame_1
 *	@date 		Wednesday 15th of February 2023 03:28:05 AM
 *	@title 		Page 1
 *	@author 	
 *	@keywords 	
 *	@generator 	Export Kit v1.3.figma
 *
*/
 -->

 <?php
 session_start();
 include("conn.php");
 include("functions.php");
 include("words.php");
 $final_output = '';
 

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<meta http-equiv="content-type" content="text/html" charset="utf-8" />
		<title>Converter</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="" >
		<link rel="StyleSheet" href="fname_1.css" />
		<script src="https://secure.exportkit.com/cdn/js/ek_googlefonts.js?v=6"></script>
		<!-- Add your custom HEAD content here -->

	</head>
	<body>
		<div id="content-container" >
			<div id="page_frame_1_ek1"  >
				<div id="_bg__frame_1_ek2"  ></div>
				<div id="background"  ></div>
				<img src="skins/shadow_box.png" id="shadow_box" />
				<div id="converter" >
					CONVERTER
				</div>
				<div id="input_box"  ></div>
				<form action="" method="POST">

					<input type = "text" name = "user_input" id="input_textt">
	
					<input type = "submit" name = "Submit" value="CONVERT" id="button">
					
				</form>

				<div id="input_text_or_numbers" >
					INPUT TEXT OR NUMBERS
				</div>
				<div id="history" >
					HISTORY
				</div>
				<div id="result_" >
					RESULT:
				</div>
				<div id="result__ek1" >
					<?php
					if($_SERVER["REQUEST_METHOD"] == "POST"){

						$input = $_POST['user_input'];
	
						if(is_numeric($input)){
							if((int)($input)<0 || (int)($input)>999999999999){
								echo $error = "INVALID INPUT";
                                $sql = "INSERT INTO user_input (input, user_output) VALUES ('$input', '$error')";
                                mysqli_query($con, $sql);
							}
							else{
							    number_checker($input);
							}
						}
						else{
							word_checker($input);
						}
					}
					?>
				</div>
				<div id="dollar_value_" >
					DOLLAR VALUE:
				</div>
				<div id="__" >
                    <?php echo (isset($_SESSION['usd']) ? '$'.number_format($_SESSION['usd'],2) : ''); session_unset();?>
				</div>
				
				<table class="sql_table">
					<tr>
					<div style="font-size: 20px;margin: 10px;color: black;"><th>User Input</th></div>
					<div style="font-size: 20px;margin: 10px;color: black;"><th>Output</th></div>
					
					<?php
					$sql_u = "SELECT * FROM user_input";
					$res_u = mysqli_query($con, $sql_u);
				
					if (mysqli_num_rows($res_u) > 0) {
		
						if(mysqli_num_rows($res_u) > 5){
							$row_check = mysqli_fetch_array($res_u);
							$sql = "DELETE FROM user_input WHERE input_id ='".$row_check['input_id']."'";
							mysqli_query($con, $sql);
						}
		
		
						while($row_data = mysqli_fetch_array($res_u)){
							echo "<tr><td>".$row_data["input"]."</td><td>".$row_data["user_output"]."</tr>";
						}
					}
					
					?>
					</tr>
					</table>

			</div>
		</div>
	</body>
</html>