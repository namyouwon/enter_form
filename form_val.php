
<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" href="index.css">
</head>
<body>  

<?php
// define variables and set to empty values
//date_default_timezone_set("Asia/Ho_Chi_Minh");
$invalid_data = TRUE; 
$nameErr=$emailErr=$idErr=$genderErr="";
$name=$email=$id=$comment=$gender="";
function validateName($name){
  return preg_match("/^[a-zA-Z-' ]*$/",$name);
}
function validateId($id){
  return preg_match("/^[0-9]+$/", $id);
}
function validateEmail($email){
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function test_input($data){
  $data=trim($data);
  $data=stripslashes($data);
  $data=htmlspecialchars($data);
  return $data;
} 
if($_SERVER["REQUEST_METHOD"]=="POST"){
  //name
  if(empty($_POST["name"])){
    $nameErr="Name is required";
    $invalid_data = FALSE;
  } 
  else{
    $name = test_input($_POST["name"]);
    if (validateName($name)==FALSE) {
      $nameErr = "Only letters and white space allowed";
      $invalid_data = FALSE;
    }
  }  
  //email
  if(empty ($_POST["email"])){
    $invalid_data = FALSE;
    $emailErr="Email is required";
  } 
  else {
    $email = test_input($_POST["email"]);
    if (validateEmail($email)==FALSE) {
      $emailErr = "Invalid email format";
      $invalid_data = FALSE;
    }
  }
  //id
  if(empty ($_POST["id"])){
    $invalid_data = FALSE;
    $idErr="Id is required";
  } 
  else{
    $id = test_input($_POST["id"]);
    if (validateId($id)==FALSE) {
      $idErr = "Only number allowed";
      $invalid_data = FALSE;
    }
  }
  //comment
  $comment=test_input($_POST["comment"]);
  //gender
  if(empty($_POST["gender"])){
    $invalid_data = FALSE;
    $genderErr ="Genfer is required";   
  } 
  else{
    $gender=test_input($_POST["gender"]);
  } 
  if($invalid_data==TRUE){
    $conn = new mysqli('localhost','root','','test');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        $ret_sql = "SELECT * FROM reg WHERE email='".$id."'";
        $result = $conn->query($ret_sql);
      if ($result->num_rows > 0)
        echo "Email has been used";
      else{
        $sql =$conn->prepare("INSERT INTO reg (name, email, id,comment,gender)
        VALUES (?,?,?,?,?)");
        $sql->bind_param("sssss",$name,$email,$id,$comment,$gender);
        $sql->execute();
        $conn->close(); 
      }
        
    }
  }
}

?>
<div class="logo">
<a href="https://furucrm.com/vn/" target="_blank">
  <img class="logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkakKT2e0_H-2AGJRzE-KhuX4Dal-Z_9W4KaIyLq_I1KznfROLkQk4w280qzKk7Z4kDM4&usqp=CAU" alt="furuCRM">
</a>
</div>


<form class="find" action="retrieve_bd.php" method="post">
  <input type="text" name="name" placeholder="Searching name "></input>
  <button type="submit" id="Find">Find</button>
</form>


<div class="input">
  <h2 class="sign_in">Enter information</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <h3>Name:</h3>
    <div class="textInput">
      <input type="text" name="name" size='30' value="<?php echo $name;?>"> 
      <span class="error">*<?php echo $nameErr?></span>
    </div>
    <h3 >ID:</h3>
    <div class="textInput">
      <input type="text" name="id" size='30' value="<?php echo $id?>">
      <span class="error">*<?php echo $idErr?> </span>
    </div>
    <h3 >E-mail:</h3> 
    <div class="textInput">
      <input type="text" name="email" size='30' value="<?php echo $email?>">
      <span class="error">*<?php echo $emailErr?> </span>
    </div>
    <h3 >Comment:</h3>
    <div class="commentInput">
      <textarea name="comment" rows="5" cols="40" value="<?php echo $comment?>"></textarea>
    </div>
    <h3 >Gender:</h3>
    <div class="genderInput">
      <input type="radio" name="gender" value="female" checked>Female
      <input type="radio" name="gender" value="male" >Male
      <input type="radio" name="gender" value="other" >Other
    </div>
    <br><br>
    <input class="submit" type="submit" name="submit" value="Submit">  
  </form>
</div>




</body>
</html>