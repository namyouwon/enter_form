<?PHP
  $name = '';
if (!$_POST['name'])
  echo "Name is required";
else{
  $conn = new mysqli('localhost', 'root', '', 'test');
  $name = $_POST['name'];
  $sql = "SELECT * FROM reg WHERE name LIKE '%".$name."%'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<br> Name: ". $row["name"]. " - Email: ". $row["email"]. " - Gender: " . $row["gender"] . "<br>";
      }
  } else {
      echo "0 results";
  }
}
  
?>