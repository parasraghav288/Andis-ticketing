<!DOCTYPE html>
<html lang="en">

<head>
	<title>Andis Ticketing</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
</head>

<body>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/blockTop.php'); ?>
	
    <!-- Page Content -->
    <div class="container">
        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>A Warm Welcome!</h1>
            <p>The great, wonderful, beautiful, spectacular, fancy ticketing system just for andi.</p>
			<p><a class="btn btn-primary btn-large" href="/create.php">Create a fuckin ticket!</a></p>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Dashboard</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row">

           <table class="table table-striped">
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Enddate</th>
					<th>Assignee</th>
					<th>Reporter</th>
					<th>Commands</th>
					<th>Priority</th>
					<th>Status</th>
					<th>Type</th>
					<th>Version</th>
					<th></th>
					<th></th>
				</tr>
			<?php 
				$mysqli = new mysqli("localhost", "dakesch_andis", "92jsadf8c3c", "dakesch_andis");
				
				if($_GET['id'] != 0){
					$query = "DELETE FROM ticket WHERE id = ?";
					$stmt = $mysqli->prepare($query);
					
					$stmt->bind_param("i", $_GET['id']);

					/* Execute the statement */
					$stmt->execute();	
				}
				
				
				$stmt = $mysqli->prepare("
				SELECT ticket.id, ticket.title,ticket.description,ticket.datum,person1.firstname AS assignee1, person1.lastname AS assignee2,person2.firstname AS reporter1,person2.lastname AS reporter2,ticket.commands,dimPriority.name AS priority,dimStatus.name AS status,dimType.name AS type,ticket.version 
				FROM ticket 
				LEFT JOIN person AS person1 ON ticket.fk_assignee = person1.id
				LEFT JOIN person AS person2 ON ticket.fk_reporter = person2.id
				LEFT JOIN dimPriority ON ticket.fk_priority = dimPriority.id
				LEFT JOIN dimStatus ON ticket.fk_status = dimStatus.id
				LEFT JOIN dimType ON ticket.fk_type = dimType.id");
				$stmt->execute();
				$res = $stmt->get_result();
	
				
				while($row = $res->fetch_assoc()){
					print '<tr>';
					print '<td>'.$row['title'].'</td>';
					print '<td>'.$row['description'].'</td>';
					print '<td>'.$row['datum'].'</td>';
					print '<td>'.$row['assignee1'].' '.$row['assignee2'].'</td>';
					print '<td>'.$row['reporter1'].' '.$row['reporter2'].'</td>';
					print '<td>'.$row['commands'].'</td>';
					print '<td>'.$row['priority'].'</td>';
					print '<td>'.$row['status'].'</td>';
					print '<td>'.$row['type'].'</td>';
					print '<td>'.$row['version'].'</td>';
					print '<td><a href="/index.php?id='.$row['id'].'" class="deleter">Delete</a></td>';
					print '<td><a href="/edit.php?id='.$row['id'].'" class="editer">Edit</a></td>';

					print '</tr>';
					
				}
				
				$stmt->close();
				/* close connection */
				$mysqli->close();
			?>
			</table>

        </div>
        <!-- /.row -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/blockBottom.php'); ?>
	
</body>
</html>
