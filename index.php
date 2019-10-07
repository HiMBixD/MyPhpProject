<!DOCTYPE html>
<html>
<body>

<h1>My first PHP page</h1>


<?php
	echo "Show every from database";
	$db = parse_url(getenv("DATABASE_URL"));
	
	$pdo = new PDO("pgsql:" . sprintf(
	    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
	    $db["host"],
	    $db["port"],
	    $db["user"],
	    $db["pass"],
	    ltrim($db["path"], "/")
									)
				);
?>
<form action="/index.php">
ID: <input type="text" name="ID" value=""><br>
Name: <input type="text" name="Name" value=""><br>
Name Course: <input type="text" name="Course" value=""><br>
Dob: <input type="text" name="Dob" value=""><br>
Gender: <input type="text" name="Gender" value=""><br>
Fav: <input type="text" name="Fav" value=""><br>
<input type="submit" value="Submit">
</form>
<?php

	
	$sql= "SELECT * FROM RegisterCourse";

	$stmt= $pdo->prepare($sql);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stmt->execute();
	$resultSet= $stmt->fetchAll();
?>
<ul>
	<?php 
		foreach ($resultSet as $row) {
			echo "<li>". $row["studentname"] . '--' . $row["course"] . '--' . $row["dob"] . '--' . $row["gender"] . '--' . $row["fav"] . "</li>";
		}
	 ?>
</ul>
</body>
</html>
