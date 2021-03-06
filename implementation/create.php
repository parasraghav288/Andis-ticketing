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
				if(isset($_POST['submitter'])){
					$p = $_POST;
					
				
					$error = false;
					$errorFields = array();
					foreach($p as $key=>$value){
						if($value == NULL){
							$error = true;
							$errorFields[] = $key;
						}
					}
					
					if($error == false){
						$mysqli = new mysqli("localhost", "dakesch_andis", "92jsadf8c3c", "dakesch_andis");
				
						/* check connection */
						if (mysqli_connect_errno()) {
						    printf("Connect failed: %s\n", mysqli_connect_error());
						    exit();
						}
	
						
						/* Prepare an insert statement */
						$query = "INSERT INTO ticket(title,description,datum,fk_assignee,fk_reporter,commands,fk_priority,fk_status,fk_type,version) VALUES (?,?,?,?,?,?,?,?,?,?)";
						$stmt = $mysqli->prepare($query);
						
						$version = '1';
						
						$rc = $stmt->bind_param("sssiisiiii", $p['title'], $p['description'], $p['enddate'], $p['assignee'], $p['reporter'], $p['commands'], $p['priority'], $p['status'], $p['type'], $version);
						if(false ===$rc){
							die('bind_param() failed: '.htmlspecialchars($stmt->error));
						}
	
						/* Execute the statement */
						$stmt->execute();
						
						/* close statement */
						$stmt->close();
						
						print "Ticket created";
						header("Location:index.php");
					}else{
						print 'fill in something in every field you little cunt';
					}
					
				}else{
					
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
		                <h3>Create ticket</h3>
		            </div>
		        </div>
		        <!-- /.row -->

				<form method="post" action="">
					<table id="createTable">
						<tr>
							<th>Title*</th>
							<td><input type="text" name="title" class="xxl" /></td>
						</tr>
						<tr>
							<th>Description*</th>
							<td><textarea name="description"></textarea></td>
						</tr>
						<tr>
							<th>Enddate*</th>
							<td><input type="text" name="enddate" class="xxl" />(yyyy-mm-dd)</td>
						</tr>
						<tr>
							<th>Assignee*</th>
							<td>
								<select name="assignee">
									<option value="0">Choose</option>
									<?php
										while($row = $person->fetch_assoc()){
											print '<option value="'.$row['id'].'">'.$row['lastname'].' '.$row['firstname'].'</option>';
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
											print '<option value="'.$row['id'].'">'.$row['lastname'].' '.$row['firstname'].'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Commands*</th>
							<td><textarea name="commands"></textarea></td>
						</tr>
						<tr>
							<th>Priority*</th>
							<td>
								<select name="priority">
									<option value="0">Choose</option>
									<?php
										while($row = $priority->fetch_assoc()){
											print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
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
											print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
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
											print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
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
