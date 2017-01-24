<!DOCTYPE html>
<html>
	<head>
		<title>Andis Ticketing</title>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');?>
	</head>
	<body>
		<div id="blockMain">
			<div id="blockTop">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/blockTop.php');?>
			</div>
			<h1>Andis ticketing - Dashboard</h1>
			<table border="1">
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
				</tr>
			<?php 
				$mysqli = new mysqli("localhost", "dakesch_andis", "92jsadf8c3c", "dakesch_andis");
	
				$stmt = $mysqli->prepare("
				SELECT ticket.title,ticket.description,ticket.datum,person1.short AS assignee,person2.short AS reporter,ticket.commands,dimPriority.name AS priority,dimStatus.name AS status,dimType.name AS type,ticket.version 
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
					foreach($row as $data){
						print '<td>'.$data.'</td>';
					}
					print '</tr>';
					
				}
				
				$stmt->close();
				/* close connection */
				$mysqli->close();
			?>
			</table>
		</div>
	</body>
</html>