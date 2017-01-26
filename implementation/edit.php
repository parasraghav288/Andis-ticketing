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


        
        <!-- Page Features -->
        <div class="row">

           <?php 
	           $mysqli = new mysqli("localhost", "dakesch_andis", "92jsadf8c3c", "dakesch_andis");
				if(isset($_POST['submitter']) AND $_GET['id'] != 0){
					$p = $_POST;
					
				
					$error = false;
					$errorFields = array();
					foreach($p as $value){
						if($value == NULL){
							$error = true;
						}
					}
					if($error == false){
						$stmt = $mysqli->prepare("SELECT version FROM ticket WHERE id = ?");
						$stmt->bind_param('i', $_GET['id']);
						$stmt->execute();
						$version = $stmt->get_result();
						
						$vers = 0;
						
						while($row = $version->fetch_assoc()){
							$vers = $row['version'];
						}
						
						
						
						/* check connection */
						if (mysqli_connect_errno()) {
						    printf("Connect failed: %s\n", mysqli_connect_error());
						    exit();
						}
	
						
						/* Prepare an insert statement */
						$query = "UPDATE ticket SET title = ?, description = ?, datum = ?, fk_assignee = ?, fk_reporter = ?, commands = ?, fk_priority = ?, fk_status = ?, fk_type = ?, version = ? WHERE id = ?";
						$stmt = $mysqli->prepare($query);
						
						$version = $vers + 1;
						
						$rc = $stmt->bind_param("sssiisiiiii", $p['title'], $p['description'], $p['enddate'], $p['assignee'], $p['reporter'], $p['commands'], $p['priority'], $p['status'], $p['type'], $version, $_GET['id']);
						if(false ===$rc){
							die('bind_param() failed: '.htmlspecialchars($stmt->error));
						}
	
						/* Execute the statement */
						$stmt->execute();
						
						/* close statement */
						$stmt->close();
						
						print "Ticket editteteteteteteted";
						
						
						header("Location:index.php");
					}else{
						print 'fill in something in every field you little cunt';
					}
					
				}
				
				if($_GET['id'] != 0){
					$stmt = $mysqli->prepare("
					SELECT title, description, datum, fk_assignee, fk_reporter, commands, fk_priority, fk_status, fk_type, version 
					FROM ticket WHERE id = ?");
					$stmt->bind_param('i', $_GET['id']);
					$stmt->execute();
					$res = $stmt->get_result();
		
					
					while($row = $res->fetch_assoc()){
						$ud = $row;
					}
				}
				
				
				$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM person");
				$stmt->execute();
				$person = $stmt->get_result();
				
				$stmt = $mysqli->prepare("SELECT id, firstname, lastname FROM person");
				$stmt->execute();
				$person2 = $stmt->get_result();
	
				$stmt = $mysqli->prepare("SELECT id, name FROM dimPriority");
				$stmt->execute();
				$priority = $stmt->get_result();
				
				$stmt = $mysqli->prepare("SELECT id, name FROM dimStatus");
				$stmt->execute();
				$status = $stmt->get_result();
				
				$stmt = $mysqli->prepare("SELECT id, name FROM dimType");
				$stmt->execute();
				$type = $stmt->get_result();
				
				
				
				$stmt->close();
			?>
				<!-- Title -->
		        <div class="row">
		            <div class="col-lg-12">
		                <h3>Edit ticket</h3>
		            </div>
		        </div>
		        <!-- /.row -->

				<form method="post" action="/edit.php?id=<?php print $_GET['id']; ?>">
					<table id="createTable">
						<tr>
							<th>Title*</th>
							<td><input type="text" name="title" class="xxl" value="<?php print $ud['title']; ?>"/></td>
						</tr>
						<tr>
							<th>Description*</th>
							<td><textarea name="description"><?php print $ud['description']; ?></textarea></td>
						</tr>
						<tr>
							<th>Enddate*</th>
							<td><input type="text" name="enddate" class="xxl" value="<?php print $ud['datum']; ?>"/>(yyyy-mm-dd)</td>
						</tr>
						<tr>
							<th>Assignee*</th>
							<td>
								<select name="assignee">
									<option value="0">Choose</option>
									<?php
										while($row = $person->fetch_assoc()){
											if($row['id'] == $ud['fk_assignee']){
												print '<option value="'.$row['id'].'" selected="selected">'.$row['lastname'].' '.$row['firstname'].'</option>';
											}else{
												print '<option value="'.$row['id'].'">'.$row['lastname'].' '.$row['firstname'].'</option>';
											}
											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Reporter*</th>
							<td>
								<select name="reporter">
									<option value="0">Choose</option>
									<?php
										while($row = $person2->fetch_assoc()){
											if($row['id'] == $ud['fk_reporter']){
												print '<option value="'.$row['id'].'" selected="selected">'.$row['lastname'].' '.$row['firstname'].'</option>';
											}else{
												print '<option value="'.$row['id'].'">'.$row['lastname'].' '.$row['firstname'].'</option>';
											}
											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Commands*</th>
							<td><textarea name="commands"><?php print $ud['commands']; ?></textarea></td>
						</tr>
						<tr>
							<th>Priority*</th>
							<td>
								<select name="priority">
									<option value="0">Choose</option>
									<?php
										while($row = $priority->fetch_assoc()){
											if($row['id'] == $ud['fk_priority']){
												print '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
											}else{
												print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Status*</th>
							<td>
								<select name="status">
									<option value="0">Choose</option>
									<?php
										while($row = $status->fetch_assoc()){
											if($row['id'] == $ud['fk_status']){
												print '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
											}else{
												print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Type*</th>
							<td>
								<select name="type">
									<option value="0">Choose</option>
									<?php
										while($row = $type->fetch_assoc()){
											if($row['id'] == $ud['fk_type']){
												print '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
											}else{
												print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
											
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th></th>
							<td><input type="submit" name="submitter" value="submit" /></td>
						</tr>
					</table>
				</form>

        </div>
        <!-- /.row -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/blockBottom.php'); ?>
	
</body>
</html>
