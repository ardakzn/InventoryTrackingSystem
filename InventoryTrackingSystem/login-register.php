<?php 
  if(isset($_GET['exit'])){
    session_start(); //to ensure you are using same session
    session_destroy();//SESSION KILL WHEN LOGOUT
  }

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Ancrow - Register Page</title>
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/login-register.css">
  
  <script type="text/javascript" src="script/script.js"></script>
</head>
<body style="overflow: hidden;" 
onload='<?php 
if(isset($_POST['name'])){//If anyone post some information at register panel
    $info=json_encode($_POST);//this function converts the array into a format that javascript can understand.
    $info=addslashes($info);//this fuction acts as a separator with '/'
    echo 'warning("'.$info.'")';//fuction named 'warning' call when page load 
}?>'>
<?php 
  $msg='';//error message when reg
  $msgLog='';//error message when login
  $panel='l';//default panel when page load 'l' for login panel 'r' for register panel

  if ($_SERVER["REQUEST_METHOD"]=="POST") {//if post any form
    defineDb();//define database information
    switch($_POST['submit']){//switch is submit button's value
    case 'LOGIN':$msgLog= login(); $panel="l";//if value is login stay login panel and call function login()
    
    break;
    case 'REGISTER': $msg=reg();  $panel="r";//if value is register stay register panel call function reg()
    
    break;
  }
  
}
function defineDb(){//constant variables for connecting to database 
    define('DB_SERVER','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_DATABASE','its_db');
}
function login(){//when click submit button on login panel
    $id=$_POST["id"];// post value of id
    $pass=$_POST["password"];// post value of password
     if(!($database=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE))){//if can not connect database
      die("Could not connect to database</body></html>");
    }   
    else{//if can connect database..
    $query="SELECT*FROM user WHERE student_id='$id' and password='$pass' and confirmed='1'";//query of who confirmed user with input id and password
        if(!($result=mysqli_query($database,$query))){//if query give an error
          print("Could not execute query!<br>");
          die("</body></html>");
        }
        else{
          if(mysqli_num_rows($result)==1){//if there is a user who confirming the conditions
            session_start();//start a session
            $_SESSION["userid"]=$id;//assign this id to array of session
            header("Location: userpanel.php");//redirect to userpanel
              
          }
          else {
            if ($id=="admin" & $pass=="admin") {//if it is admin
              session_start();
              $_SESSION["userid"]=$id;//assign this id to array of session
              header("Location: adminpanel.php");//redirect to adminpanel
              die();
            }
            else // if anything else happened give an error message 
              $msgLog='Wrong Password or Username';

          }
    }
  }
  return $msgLog;
}
function reg(){// register function
    //assign post values from registration form to variables
    $name=$_POST["name"];
    $sname=$_POST["surname"];
    $faculty=$_POST["faculty"];
    $department=$_POST["department"];
    $email=$_POST["email"];
    $id=$_POST["id"];
    $pass=$_POST["Password"];
    $phone=$_POST["phone"];

    if(!($database=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE))){//if can not connect to database give an error
      die("Could not connect to database</body></html>");
    }   
    else{//if can connect to database..
        $query="SELECT*FROM user WHERE student_id=$id or email='$email' or phone='$phone'";//query checks is there anyone in database have these information(id,email,phone)
        if(!($result=mysqli_query($database,$query))){//if query give an error
          print("Could not execute query!<br>");
          die("</body></html>");
        }
        else{
          if(mysqli_num_rows($result)==0){//if there is noone in database have these given input
            $query = "INSERT INTO user ".
            "(student_id, password, name, surname, faculty, department ,email, phone)". "VALUES ('$id','$pass', '$name','$sname', '$faculty', '$department','$email','$phone')";
            if ( !( $result = mysqli_query( $database,$query))){//if query does not work give an error
              print("<p>Could not execute query!</p>" );
              die();}
            else {//Insertion data to 'user' table in database
                header("Location: http://localhost/InventoryTrackingSystem/login-register.php");//redirect to login-register page again to wait admin confirmation.
                die();
              }  
          }
          else{// if anything else happened give an error message 
            $msg='There is already a user on this system. Please change your (ID or E-mail or Phone Number)';
          }
        mysqli_close($database);//close db
      
    }
}
     return $msg;   
      }
    ?>


    <div id="bg_image"></div><!-- background image -->

    <div class="centered_panel"><!-- centered panel for login -->
      <div id="login" class="panel <?php if($panel=="r"){//if has been clicked to register panel this panel would be hidden
        echo 'hidden';}?> ">
        
        <h2 class="selected"> Login </h2>
        <h2 class="non-selected"><a id="toRegister" href="#">Register</a></h2><!-- if you click this button this form would be hidden and it shows register page -->
        <hr>
   
        <form id="loginform" method="post" autocomplete="on" onsubmit="" action="" ><!-- login form with post method -->
          <input type="text" id="username" class="fullSize"  name="id" placeholder="Student ID" required autofocus >
          <input type="password" id="l_password" class="fullSize"  name="password" placeholder="Password" required> 
          <?php echo "<p class='warning'>$msgLog</p>";?><!-- give an error message to login -->
         
          <input type="submit" name="submit"  value="LOGIN" onclick="">
          <input type="reset"  value="CLEAR">
          
        </form>
        <hr>
        <a class="forgotpass" href="#">Forgot Password?</a>
      </div>
      <div id="register" class="panel <?php if($panel=="l"){//if has been clicked to register panel this panel would be hidden
        echo 'hidden';}?>"  >
        <h2 class="non-selected"><a id="toLogin" href="#"> Login </a></h2><!-- if you click this button this form would be hidden and it shows login page -->
        <h2 class="selected">Register</h2>
        <hr>
        <form id="registerform" method="post" autocomplete="on" action="" ><!-- register form with post method -->
        
          <input type="text" id="name" class="halfSize" name="name" placeholder="Name" required autofocus>
          <input type="text" id="surname" class="halfSize" name="surname" placeholder="Surname" required> 
          <select id="faculty" name="faculty" onChange="fieldDep(this);checkDepartment();checkFaculty();" ></select><!-- onChange means when value change, 
                                                                                          these functions for checking values if select wrongly. and field blanks again -->
          <select id="department" class="hidden fullSize" name="department" ></select><br>
          <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" id="phone" class="fullSize" name="phone" placeholder="Phone Number '512-345-6789'" required><br>
          <input type="email" id="email" class="fullSize" name="email" placeholder="E-Mail Address" required  ><br>
          <input type="text" id="id" class="fullSize" name="id" placeholder="Student ID" required autofocus>
          <input type="password" id="r_password" class="halfSize" name="Password" placeholder="Password" onChange='checkPassword()' required>
          <input type="password" id="password_repeat" class="halfSize" name="password_repeat" placeholder="Repeat Password" onChange='checkPassword();' required>
          <input type="submit" name="submit"  value="REGISTER" onClick="checkDepartment();checkFaculty();">
          <input type="reset"  value="CLEAR" onClick="showOrHide(true,'department');" ><!-- when reset form hide selector of department -->
          <?php echo "<p class='warning'>$msg</p>";?><!-- give an error message to register -->
          
			    <br><br>
        </form>
        
        
      </div>
    </div>
  <footer>
    <h3 class="copyright" style="position: fixed;">&copy;All rights Reserved by Ancrow.</h3>
  </footer>
</body>
</html>
