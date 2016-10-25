<?php
	if ( !class_exists( "utils" ) )
	{
		class utils {
			var $dbhost = "";
			var $dbuser = "";
			var $dbpass = "";
			var $dbname = "";

			var $errors = array();

			/*
			*  __construct
			*
			*  constructor function
			*
			*  @param	N/A
			*  @return	N/A
			*/
			//
			function __construct() {
				//if we are on localhost, use the local db credentials, otherwise use the live db credentials
				if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
					$this->dbhost = "localhost";
					$this->dbuser = "robots";
					$this->dbpass = "robots";
					$this->dbname = "robotCalendar";
				} else {
					$this->dbhost = "localhost";
					$this->dbuser = "bdee1_m5r0b01";
					$this->dbpass = "RMD9NFqxvjXF9K";
					$this->dbname = "bdee1_robots";
				}

			}

			/*
			*  db_connect
			*
			*  connect to the database
			*
			*  @param	N/A
			*  @return	$conn - the database connection object
			*/
			//
			function db_connect() {
				//connect to the database

				$conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

				//Test the db connection
				if (mysqli_connect_errno()) {
					die("Database connection failed: " .
						mysqli_connect_error() .
						" (" . mysql_connect_errno() . ")"
					);
					echo 'failed';
				}
				return $conn;
			}

			/*
			*  db_close
			*
			*  close the database connection
			*
			*  @param	$conn the database connection object to close
			*  @return	N/A
			*/
			//
			function db_close($conn) {
				//close db connection
				mysqli_close($conn);
			}

			/*
			*  getRequests
			*
			*  get all of the robot requests from  db.
			*
			*  @param	N/A
			*  @return	the query object with all the robot request data
			*/
			//
			function getRequests ($id = 0)
			{
				//connect to the database
				$conn = $this->db_connect();

				//build the query
				$qry = "SELECT rq.id, rq.requestor, rq.email, rq.gradeLevel, rq.district, rq.start_date, rq.end_date, rq.robotID, rb.title as robot, approved ";
				$qry .= "FROM tbl_requests rq ";
				$qry .= "INNER JOIN tbl_robots rb ";
				$qry .= "ON rq.robotID = rb.id ";
				if ($id > 0) {
					$qry .= "WHERE rq.id = " . $id;
				}
				$qry .= " ORDER BY start_date";

				$result = mysqli_query($conn, $qry);

				//close db connection
				$this->db_close($conn);

				if (!$result) {
					echo 'Error executing query for robot requests';
					return null;
				} else {
					return $result;
				}

			} // End Method getRobotTypes

			/*
			*  getRobotTypes
			*
			*  get the query object containing all the data for the robot types from the db.
			*
			*  @param	N/A
			*  @return	the query object with all the robot type data
			*/
			//
			function getRobotTypes ($id = 0)
			{
				//connect to the database
				$conn = $this->db_connect();

				//build the query
				$qry = "SELECT id, title, description, color ";
				$qry .= "FROM tbl_robots ";
				if ($id > 0) {
					$qry .= "WHERE id = " . $id;
				}
				$qry .= " ORDER BY title";

				$result = mysqli_query($conn, $qry);

				//close db connection
				$this->db_close($conn);

				if (!$result) {
					echo 'Error executing query';
					return null;
				} else {
					return $result;
				}

			} // End Method getRobotTypes


			/*
			*  getEventsJSON
			*
			*  get all the event data between the start and end date and return it as a json object
			*
			*  @param	$start - the start date
			*  @param	$end - the end date
			*  @return	$result - the json object with the event data
			*/
			//
			function getEventsJSON ($start, $end)
			{
				$start = (empty($start))?date('Y-m-01 00:00:00', strtotime('today midnight')):$start;
				$end   = (empty($end))?date('Y-m-t  00:00:00'):$end;

				//connect to the database
				$conn = $this->db_connect();

				//build the query
				$qry = "SELECT rq.id, rq.requestor, rq.gradeLevel, rq.district, rq.start_date, DATE_ADD(rq.end_date, INTERVAL 1 DAY) AS end_date, rq.robotID, rb.title, rb.color, rq.approved ";
				$qry .= "FROM tbl_requests rq ";
				$qry .= "INNER JOIN tbl_robots rb ";
				$qry .= "ON rb.id = rq.robotID ";
				//$qry .= "WHERE rq.approved = 1 ";
				$qry .= "AND rq.start_date BETWEEN '" . $start. "' AND '" . $end . "'";

				//echo $qry;

				$result = mysqli_query($conn, $qry);
				if (!$result) {
					die("Database query failed.");
				}

				$eventData = "";

				$arrevents = array();

				while ($row = mysqli_fetch_assoc($result)) {
					$arrevent = array("title"=>$row["district"] . ": " . $row["title"],
										"start"=>$row["start_date"],
										"end"=>$row["end_date"],
										"color"=>$row["color"],
										"allDay"=>"true",
										"requestor"=>$row["requestor"],
										"district"=>$row["district"],
										"gradeLevel"=>$row["gradeLevel"],
										"robot"=>$row["title"],
										"eventid"=>$row["id"]);

					$arrevents[] = $arrevent;
				}

				$eventData = json_encode($arrevents);

				//close db connection
				$this->db_close($conn);

				return $eventData;
			}

			/*
			*  insertRobotRequest
			*
			*  insert the robot request into the database
			*
			*  @param	$post - contains the post data from the form submission
			*  @return	N/A
			*/
			//
			function insertRobotRequest ($post)
			{
				//connect to the database
				$conn = $this->db_connect();

				$requestor = mysqli_real_escape_string($conn, $post['name']);
				$email = mysqli_real_escape_string($conn, $post['email']);
				$gradeLevel = mysqli_real_escape_string($conn, $post['gradeLevel']);
				$district = mysqli_real_escape_string($conn, $post['district']);

				$start_date = mysqli_real_escape_string($conn, date("Y-m-d H:i:s", strtotime($post['start_date'])));
				if (empty($post['end_date'])) {
					$end_date = $start_date;
				} else {
					$end_date = mysqli_real_escape_string($conn, date("Y-m-d H:i:s", strtotime($post['end_date'])));
				}
				//$start_date = mysqli_real_escape_string($conn, $post['start_date']);


				//build the query
				//loop over the submitted robot values and insert one event for each chosen robot.
				$qry = "INSERT INTO tbl_requests(requestor, email, gradeLevel, district, start_date, end_date, robotID, approved) ";
				$qryvalues = "";
				foreach ($post['robot'] as $robot) {
					if (! empty($qryvalues)) {
						$qryvalues .= ",";
					} else {
						$qryvalues .= "VALUES ";
					}
					$qryvalues .= " ( '{$requestor}', '{$email}', '{$gradeLevel}', '{$district}', '{$start_date}', '{$end_date}', {$robot}, 0) ";
				}
				$qry = $qry . $qryvalues;
				

				//execute the query
				if (!empty($qry)) {
					$result = mysqli_query($conn, $qry);
					if (!$result) {
						die("Database query failed.");
					}
				}
			}


			/*
			*  approveRequest
			*
			*  update the approved field for the given request id
			*
			*  @param	$id - the id of the record to update
			*  @param	$approved - the value for the approved field (0 or 1)
			*  @return	N/A
			*/
			//
			function approveRequest ($id, $approved)
			{
				//connect to the database
				$conn = $this->db_connect();

				$id = mysqli_real_escape_string($conn, $id);
				$approved = mysqli_real_escape_string($conn, $approved);

				//build the query
				$qry = "UPDATE tbl_requests ";
				$qry .= "SET approved = '{$approved}' ";
				$qry .= "WHERE id = {$id}";


				//execute the query
				$result = mysqli_query($conn, $qry);
				if (!$result) {
					die("Database query failed.");
				}
			}

			/*
			*  updateRobotRequest
			*
			*  update record for a robot Request
			*
			*  @param	$post - contains the post data from the form submission
			*  @return	N/A
			*/
			//
			function updateRobotRequest ($post)
			{
				//connect to the database
				$conn = $this->db_connect();

				$id = mysqli_real_escape_string($conn, $post['id']);
				$name = mysqli_real_escape_string($conn, $post['name']);
				$email = mysqli_real_escape_string($conn, $post['email']);
				$gradeLevel = mysqli_real_escape_string($conn, $post['gradeLevel']);
				$district = mysqli_real_escape_string($conn, $post['district']);
				$start_date = mysqli_real_escape_string($conn, date("Y-m-d H:i:s", strtotime($post['start_date'])));
				if (empty($post['end_date'])) {
					$end_date = $start_date;
				} else {
					$end_date = mysqli_real_escape_string($conn, date("Y-m-d H:i:s", strtotime($post['end_date'])));
				}
				$robot = mysqli_real_escape_string($conn, $post['robot']);
				$approved = mysqli_real_escape_string($conn, $post['approved']);

				//build the query
				$qry = "UPDATE tbl_requests ";
				$qry .= "SET requestor = '{$name}', ";
				$qry .= "email = '{$email}', ";
				$qry .= "gradeLevel = '{$gradeLevel}', ";
				$qry .= "district = '{$district}', ";
				$qry .= "start_date = '{$start_date}', ";
				$qry .= "end_date = '{$end_date}', ";
				$qry .= "robotID = '{$robot}', ";
				$qry .= "approved = '{$approved}' ";
				$qry .= "WHERE id = {$id}";


				//execute the query
				$result = mysqli_query($conn, $qry);
				if (!$result) {
					die("Database query failed.");
				}
			}

			/*
			*  updateRobot
			*
			*  update record for a robot
			*
			*  @param	$post - contains the post data from the form submission
			*  @return	N/A
			*/
			//
			function updateRobot ($post)
			{
				//connect to the database
				$conn = $this->db_connect();

				$id = mysqli_real_escape_string($conn, $post['id']);
				$title = mysqli_real_escape_string($conn, $post['title']);
				$description = mysqli_real_escape_string($conn, $post['description']);
				$color = mysqli_real_escape_string($conn, $post['color']);

				//build the query
				$qry = "UPDATE tbl_robots ";
				$qry .= "SET title = '{$title}', ";
				$qry .= "description = '{$description}', ";
				$qry .= "color = '{$color}' ";
				$qry .= "WHERE id = {$id}";



				//execute the query
				$result = mysqli_query($conn, $qry);
				if (!$result) {
					die("Database query failed.");
				}
			}

			/*
			*  insertRobot
			*
			*  insert the new robot into the database
			*
			*  @param	$post - contains the post data from the form submission
			*  @return	N/A
			*/
			//
			function insertRobot ($post)
			{
				//connect to the database
				$conn = $this->db_connect();

				$title = mysqli_real_escape_string($conn, $post['title']);
				$description = mysqli_real_escape_string($conn, $post['description']);
				$color = mysqli_real_escape_string($conn, $post['color']);

				//build the query
				$qry = "INSERT INTO tbl_robots(title, description, color) ";
				$qry .= "VALUES( '{$title}', '{$description}', '{$color}' )";


				//execute the query
				$result = mysqli_query($conn, $qry);
				if (!$result) {
					die("Database query failed.");
				}
			}

			/*
			*  deleteRobot
			*
			*  delete a robot from the database
			*
			*  @param	$id - the id of the robot to delete
			*  @return	$result - the results of the query
			*/
			//
			function deleteRobot ($id)
			{
				//connect to the database
				$conn = $this->db_connect();

				$id = mysqli_real_escape_string($conn, $id);

				//build the query
				$qry = "DELETE FROM tbl_robots ";
				$qry .= "WHERE( id = {$id} )"  ;

				echo $qry;

				//execute the query
				$result = mysqli_query($conn, $qry);
				if (!$result) {
					echo ("Database query failed while deleting robot.");
					return 0;
				} else {
					return mysqli_affected_rows($conn);
				}
			}

			/*
			*  deleteRobotRequest
			*
			*  delete a request from the database
			*
			*  @param	$id - the id of the robot to delete
			*  @return	$result - the results of the query
			*/
			//
			function deleteRobotRequest ($id)
			{
				//connect to the database
				$conn = $this->db_connect();

				$id = mysqli_real_escape_string($conn, $id);

				//build the query
				$qry = "DELETE FROM tbl_requests ";
				$qry .= "WHERE( id = {$id} )"  ;

				echo $qry;

				//execute the query
				$result = mysqli_query($conn, $qry);
				if (!$result) {
					echo ("Database query failed while deleting request.");
					return 0;
				} else {
					return mysqli_affected_rows($conn);
				}
			}

			/*
			*  redirect_to
			*
			*  redirect the browser to the given page
			*
			*  @param	$location - the location to redirect to
			*  @return	N/A
			*/
			//
			function redirect_to($location) {
				header('Location:'.$location);
				exit;
			}

			/*
			*  validate_required
			*
			*  check the passed fieldnames to make sure they have a value
			*
			*  @param	$fields - an array of the fieldnames which are required
			*  @return	N/A
			*/
			//
			function validate_required ($fields) {
				foreach($fields as $field) {
					$value = trim($_POST[$field]);
					if (!isset($value) || $value == "") {
						$this->errors[$field] = ucfirst($field) . " can't be blank";
					}
				}
			}

			/*
			*  validate_honeypot
			*
			*  check to make sure the honeypot field was not filled out
			*
			*  @param	$field - the name of the field to check
			*  @return	N/A
			*/
			//
			function validate_honeypot ($field) {
				$value = trim($_POST[$field]);
				if (isset($value) && $value != "") {
					$this->errors[$field] = "Sorry the form could not be submitted at this time";
				}
			}

			/*
			*  form_errors
			*
			*  build an html list of errord from form validaion.
			*
			*  @param	$errors - an array of errors to be output
			*  @return	$output  - html formatted list of errors to be displayed.
			*/
			//
			function form_errors($errors=array()) {
				$output = "";
				if (!empty($errors)) {
					$output .= "<div class=\"alert alert-danger\">";
					$output .= "Please fix the following errors:";
					$output .= "<ul>";
					foreach ($errors as $key => $error) {
						$output .= "<li>";
						$output .= htmlentities($error);
						$output .= "</li>";
					}
					$output .= "</ul>";
					$output .= "</div>";
				}
				return $output;
			}


			/*
			*  find_admin_by_username
			*
			*  Find a user in the database by the given username
			*
			*  @param	$username - the username to search for in the database
			*  @return	either the record from the found user in the database or null if no user is found
			*/
			//
			function find_admin_by_username ($username) {
				//connect to the database
				$conn = $this->db_connect();

				$safe_username = mysqli_real_escape_string($conn, $username);

				//build the query
				$qry = "SELECT id, name, username, password ";
				$qry .= "FROM tbl_users ";
				$qry .= "WHERE username = '{$safe_username}' ";
				$qry .= "LIMIT 1 ";

				$result = mysqli_query($conn, $qry);

				if (!$result) {
					die("Database query failed while finding admin by username");
				}

				if ($admin = mysqli_fetch_assoc($result)) {
					return $admin;
				} else {
					return null;
				}

				//close db connection
				$this->db_close($conn);

				return $result;
			}

			/*
			*  password_check
			*
			*  Verify the submitted password against the password stored in the database
			*
			*  @param	submitted - the password submitted by the user
			*  @param	stored - the password stored in the database for this uer
			*  @return	true or false
			*/
			//
			function password_check ($submitted, $stored) {
				if ( $submitted == $stored ) {
					return true;
				} else {
					return false;
				}
			}

			/*
			*  attempt_login
			*
			*  try to log in the user with their submitted username and password
			*
			*  @param	username - the username submitted by the user
			*  @param	password - the username submitted by the user
			*  @return	either the users record from the database or false if the user was nto found
			*/
			//
			function attempt_login ($username, $password) {
				$admin = $this->find_admin_by_username($username);
				if ($admin) {
					//found admin - now check password
					if ($this->password_check($password, $admin["password"])) {
						return $admin;
					} else {
						return false;
					}
				} else {
					//admin user not found
					return false;
				}
			}

			/*
			*  confirm_logged_in
			*
			*  confirm that the user is logged in and if not, redirect them to the login page.
			*
			*  @param	N/A
			*  @return	N/A
			*/
			//
			function confirm_logged_in () {
				if (!isset($_SESSION['admin_id'])) {
					$this->redirect_to("login.php");
				}
			}

		}// End Class
	}// End If

// Instantiating the Class
if (class_exists("utils")) {
	$utils = new utils();
}

?>
