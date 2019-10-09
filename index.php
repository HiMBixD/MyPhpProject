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
<form method="post">
ID: <input type="text" name="ID" value=""><br>
Name: <input type="text" name="Name" value=""><br>
Name Course: <input type="text" name="Course" value=""><br>
Dob: <input type="text" name="Dob" value=""><br>
Gender: <input type="text" name="Gender" value=""><br>
Fav: <input type="text" name="Fav" value=""><br>
<input type="submit" value="Submit">
</form>
<?php
	if(isset($_POST['Name']))
	{

		$add=[$_POST['ID'],$_POST['Name'],$_POST['Course'],$_POST['Dob'],$_POST['Gender'],$_POST['Fav']];
		$sql1= "INSERT INTO RegisterCourse values ($add[0],'$add[1]','$add[2]','$add[3]','$add[4]','$add[5]')";
		$stmt1= $pdo->prepare($sql1);
		$stmt1->setFetchMode(PDO::FETCH_ASSOC);
		$stmt1->execute();
	}
	if(isset($_POST['bDelete']))
	{
		$IDt2=(int)$_POST['ID2'];
		$sql2= "DELETE FROM RegisterCourse WHERE id=$IDt2";
		$stmt2= $pdo->prepare($sql2);
		$stmt2->setFetchMode(PDO::FETCH_ASSOC);
		$stmt2->execute();
	}
	$sql= "SELECT * FROM RegisterCourse";

	$stmt= $pdo->prepare($sql);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stmt->execute();
	$resultSet= $stmt->fetchAll();
?>
<ul>
	<?php 
		foreach ($resultSet as $row) {
			echo "<li>". $row["id"] . '--' . $row["studentname"] . '--' . $row["course"] . '--' . $row["dob"] . '--' . $row["gender"] . '--' . $row["fav"] . "</li>";
	?>
		<form method="post">
		ID: <input type="text" name="ID2" value="<?=$row["id"]?>" method="post"><br>
		<input type="submit" name="bDelete"  value="Delete">
		</form> 
	<?php					
		}
	 ?>
</ul>


</body>
</html>
