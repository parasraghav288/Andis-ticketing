<!DOCTYPE html>
<html>
	<head>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');?>
	</head>
	<body>
		<div id="blockMain">
			<div id="blockTop">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/blockTop.php');?>
			</div>
			<?php 
				if(isset($_POST['submitter'])){
					print "submitted<br>";
					print_r($_POST);
					$p = $_POST;
					
					
					$error = false;
					$errorFields = array();
					foreach($p as $key=>$value){
						if($value == ''){
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
						$query = "INSERT INTO ticket(title,description,datum,fk_assignee,fk_reporter,commands,fk_priority,fk_status,fk_type,version) VALUES (?,?,?,?,?,?,?,?,?)";
						$stmt = $mysqli->prepare($query);
						
						$stmt->bind_param("sssiisiiis", $p['title'], $p['description'], $p['enddate'], $p['assignee'], $p['reporter'], $p['commands'], $p['priority'], $p['status'], $p['type']);
	
						/* Execute the statement */
						$stmt->execute();
						
						/* close statement */
						$stmt->close();
						
						
					}else{
						echo '<pre>' . var_export($errorFields, true) . '</pre>';
						$mysqli = new mysqli("localhost", "dakesch_andis", "92jsadf8c3c", "dakesch_andis");
					}
					
				}else{
					$mysqli = new mysqli("localhost", "dakesch_andis", "92jsadf8c3c", "dakesch_andis");
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
			<div id="blockContent">
				<h1>Create ticket</h1>
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
		</div>
		<?php 
			
				$mysqli->close();
			
		?>
		
	</body>
</html>