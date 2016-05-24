
<?php

$serverName = "localHost";
$employeeID = "ID"
$employeeName = "employeeName";
$password = "password";
$dbName ="myDB";

$link = new mysqli($serverName, $employeeID, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//Employee Functions.

//Prints the shift times of the employee using getShifts, prints the shifts
readShift(){

  $resArray = getShiftsTime();
  $array_start = $resArray[0];
  $array_end = $resArray[1];

  for ($x = 0; $x <= count($array_start)-1; $x++) {
    echo $array_start[$x] . " - " . $array_end[$x] . "<br>";
  }

}

/*Prints the shift times of the employee using getShifts,
compares the times to other employees
*/
printPartners(){
  $resArray = getShiftsID();

  for ($x = 0; $x <= count($resArray)-1; $x++) {
    $query = mysqli_query($link, "SELECT User.name FROM User
                                  Left Join Shifts
                                  ON User.id = Shift.employee_id
                                  Where Shift.id = '$resArray[$x]'");

    while($row_data = $query->fetch_assoc($row_data)){
      if($row_data['name'] != this->$employeeName)
      echo "For Shift: "$resArray[$x] .
      "You will work with " . $row_data['name'] . "<br>";
    }
  }


}

//Prints the total hours for future shifts
printTotalHours(){
  $query = mysqli_query($link, "SELECT SUM(DATEDIFF(hh, start_time, end_time))
                                AS Total
                                From Shift
                                Where employee_ID = '$id'
                                And start_time >= CURDATE()");

  echo "Your Upcoming Workload is: " . $query . "Hours. <br>";
}

//Prints the manager of a shifts information
printManager(){
  $resArray = getShiftsID();

  for ($x = 0; $x <= count($resArray)-1; $x++) {
    $query = mysqli_query($link, "SELECT User.name, User.email, User.phone
                                  FROM User
                                  Left Join Shifts
                                  ON User.id = Shift.manager_id
                                  Where Shift.id = '$resArray[$x]'");

    while($row_data = $query->fetch_assoc($row_data)){
      if($row_data['name'] != this->$name)
      echo "For Shift: " . $resArray[$x] . "Your manager will be " .
      "Manager Name: " . $row_data['name'] .
      "<br>Email: " . $row_data['email'] . "<br>Phone: " .
      $row_data['phone'] . "<br>";
    }
  }
}

//Manager Functions.

//Create a shift
createShift(){

  $start = $_POST["start"];
  $end = $_POST["end"];

  $query = mysqli_query($link, "INSERT INTO Shift (manager_id, start_time,
                                end_time, created_at)
                                VALUES ('$id', '$start',
                                '$end', 'CURDATE()')");
}

//Add employee to existing shift
addEmployee(){

  $employee_id = $_POST["employee_id"];
  $shift_id =  $_POST["shift"];

  $query = mysqli_query($link, "INSERT INTO Shift (employee_id)
                                VALUES ('$employee_id')
                                WHERE Shift.id = '$shift_ID'");

}

//gets the shifts within an entered time period
printScheduleWithin(){

  $start = $_POST["start_time"];
  $end = $_POST["end_time"];

  $query = mysqli_query($link, "SELECT start_time, end_time
                                FROM Shift
                                Where start_time >= '$start'
                                AND end_time <= '$end'");

  echo "These are the Shifts in between" . $start . "and " . $end ": ";

  while($row_data = $query->fetch_assoc($row_data))
  {
    echo $row_data['id'];
  }

}

//changes an employees shift
changeShift(){

  $start = $_POST["start_time"];
  $end = $_POST["end_time"];
  $shiftID = $_POST["shiftID"];

  $query = mysqli_query($link, "UPDATE Shift
                                SET start_time = '$start', end_time ='$end'
                                WHERE id = '$shiftID'");

}

//Prints employee information for manager
printEmployee(){
  $employee = $_POST["employeeID"];

  $query = mysqli_query($link, "SELECT name, email, phone
                                FROM USER
                                WHERE id = '$employee'");

  echo "Employee Name: " . $row_data['name'] . "<br>Email: " .
  $row_data['email'] . "<br>" . "Phone: " . $row_data['phone'] . "<br>";
}

//GET functions

/* Gets the start and end time for given ID, places them into their own
arrays, returns an array of both.
*/
getShiftsTime(){

  $query = mysqli_query($link, "SELECT start_time, end_time
                                FROM Shift
                                Where employee_id = '$id'");
  $array_start[] = array();
  $array_end[] = array();

  while($row_data = $query->fetch_assoc($row_data))
  {
    $row_start_time = $row_data['start_time'];
    $row_end_time = $row_data['end_time'];
    array_push($array_start, $row_start_time);
    array_push($array_end, $row_end_time);
  }
  return array($array_start, $array_end);
}

// Gets the Shift IDs for a given employee
getShiftsID(){
  $query = mysqli_query($link, "SELECT id
                                FROM Shift
                                Where employee_id = '$id'");
  $array_shiftID[] = array();

  while($row_data = $query->fetch_assoc($row_data))
  {
    array_push($array_shiftID, $row_data['id'];);
  }
  return $array_shiftID;
}

$conn->close();

?>
