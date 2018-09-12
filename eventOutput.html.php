<!doctype html>
<html>
	<head>
		<title>Output</title>
		  <meta charset="UTF-8">
          
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>    
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
<link rel='stylesheet' type='text/css' href='style.php'>
</head>

<body >
<?php
        $self = htmlentities($_SERVER['PHP_SELF']);
		echo "<form action = '$self' method='POST'> ";
    ?>
<?php
include 'connect.inc.php';

//Establish connection to he network

try
    {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $userMS, $passwordMS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

       //echo "Connected<br/>";
    }

catch (PDOException $e)
    {
        $error = 'Connection to database failed';
        include 'error.html.php';
        exit();
    }
$eventSelect="";
// QUERING DATA
try
    {
		if(isset($_POST['list']))
		{
			// echo $_POST['list'];
			$eventSelect=$_POST['list'];
			//echo '<pre>'; print_r($_POST); echo '</pre>';
			$selectString="SELECT medalists.firstName AS first, medalists.lastName AS last,event,concat(sport,'  ',event) AS event1,image
			FROM medalists,event 
				WHERE medalists.eventId=event.eventId
				AND concat(sport,' ',event) =\"$eventSelect\"
					ORDER BY event";
					
	$medalistEventQuery = $pdo->query($selectString);
		}


    }

catch (PDOException $e)
    {
        $error = 'Select statement error';
        include 'error.html.php';
        exit();
    }
?>
<div class="flex-container">
	<img src="photos/rioOlympics.png" class="img-rounded" alt="">
	
	<div class="container">
	<h2 class="text-center">Rio Olympics Database</h2>
    
<!-- Table containing Medalist and Event details -->
<div class="flex-container">
         
	<table class="table table-bordered table-striped">
	<thead class="thead-dark">
			<tr>	
			<th>Name</th><th>Sport Event</th><th>Photo</th>
			</tr>
	</thead>
<?php
foreach ($medalistEventQuery as $row) 
{
    echo(
		"<tr>
		<td>$row[first] $row[last]</td>
        <td>$row[event1]</td>
		<td><img src='photos/$row[image]' alt='' class='rounded-top'></td>
		</tr>
		");
}
?>
</table>
<footer>
<div class="flex-container">
<input type='submit' class="btn btn-info" name='Cancel' value='Back'>
</div>
</footer>

</div>
</body>