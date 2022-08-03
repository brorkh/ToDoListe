<?php 
	
	$errors = "";

	// connect to database
	include('db.php');

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {

		if (empty($_POST['task'])) {
			$errors = "Du must schon was reinschreiben!";
		}else{
			$task = $_POST['task'];
			$query = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $query);
			header('location: index.php');
		}
	}	

	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
		header('location: index.php');
	}

	// strike through
	if (isset($_GET['erledigt'])) {
		$id = $_GET['erledigt'];
		mysqli_query($db, "UPDATE tasks SET erledigt='fertig' WHERE id=".$id);
		header('location: index.php');
	}

	// unstrike through
	if (isset($_GET['unerledigt'])) {
		$id = $_GET['unerledigt'];
		mysqli_query($db, "UPDATE tasks SET erledigt='' WHERE id=".$id);
		header('location: index.php');
	}

	// select all tasks if page is visited or refreshed, ordered by id descending
	$tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY id DESC");

?>
<!DOCTYPE html>
<html>

<head>
	<title>ToDo Liste</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" href="./apple-touch-icon.png"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
</head>

<body onLoad="setTimeout(function() { window.scrollTo(0,1) }, 100);">

	<div class="heading">
		<h2><span class="rainbow">ToDo Liste</span></h2>
	</div>


	<form method="post" action="index.php" class="form">
		<?php if (isset($errors)) { ?>
			<p class="error"><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Neue Aufgabe</button>
	</form>


	<table class="table">
		<thead>
			<tr>
				<!--<th>Nr.</th>-->
				<th>Erledigt?</th>
				<th>Unerledigt?</th>
				<th>Aufgaben</th>
				<th>L&ouml;schen?</th>
			</tr>
		</thead>

		<tbody>
			<?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
				<tr>
					<td>
						<a href="index.php?erledigt=<?php echo $row['id'];?>" onClick="return confirm('Wirklich ERLEDIGT?')"><i class="far fa-check-circle"></i></a>
					</td>
					
					<td>
						<a href="index.php?unerledigt=<?php echo $row['id'];?>" onClick="return confirm('Wirklich UNERLEDIGT?')"><i class="far fa-circle"></i></a>
					</td>
					
					<!--<td> <?php //echo $i; ?> </td>-->
					<td class="task"><p class="<?php echo $row['erledigt'];?>"> <?php echo $row['task']; ?> </p></td>
					<td>
						<a href="index.php?del_task=<?php echo $row['id'];?>" onClick="return confirm('Wirklich L&Ouml;SCHEN?')"><i class="fas fa-trash"></i></a>
					</td>
				</tr>
			<?php $i++; } ?>	
		</tbody>
	</table>



</body>
</html>
