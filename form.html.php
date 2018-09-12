<!doctype html>
<html>
	<head>
	<title>Olympics</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><link rel='stylesheet' type='text/css' href='style.php'>

	</head>
<body >
    <?php
        include 'createAthletes.php';
        $self = htmlentities($_SERVER['PHP_SELF']);
		echo "<form action = '$self' method='POST'> ";
    ?>
	<div class="flex-container">
	<img src="photos/rioOlympics.png" class="img-rounded" alt="">
	
	<div class="container">
	<h2 class="text-center">Rio Olympics Database</h2>
    </div>
 <?php
$query = 'SELECT medalists.firstName AS first, medalists.lastName AS last,event,sport,image
FROM medalists,event 
    WHERE medalists.eventId=event.eventId
        ORDER BY sport';

$stmt  = $pdo->prepare($query);
$stmt->execute();

echo'<div class="form-group">';
echo '<label for="sel1">Select list:</label>';
echo '<select name="list" class="form-control" class="selectpicker" id="sel1">';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
echo '<option value="' . $row['sport'] .' ' . $row['event'] .'">' . $row['sport'] .' ' . $row['event'] .'</option>';
}
echo '</select>';
?>
</div>
<div class="flex-container">
<input type='submit' class="btn btn-info" name='submit' value='Search'>
</div>
<!-- <?php echo "<pre>"; print_r($_POST) ;  echo "</pre>";?>-->
</body>

