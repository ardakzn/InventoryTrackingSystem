<?php 
session_start();
if(isset($_SESSION["userid"])){
  ?>
<?php 

define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DATABASE','its_db');

if(isset($_GET['eq_id'])){
  $f_startDate="";
  $f_releaseDate="";
  if(isset($_POST["startDate"]) and isset($_POST["releaseDate"])){
    $f_startDate=$_POST["startDate"];
    $f_releaseDate=$_POST["releaseDate"];
  }
  if(isset($_SESSION["item_cart"]))  
      {  
        
           $item_array_id = array_column($_SESSION["item_cart"], "item_id");  
           if(!in_array($_GET["eq_id"], $item_array_id))  
           {  
                $count = count($_SESSION["item_cart"]);
                $item_array = array(  
                  'item_id'               =>     $_GET["eq_id"],
                  'item_name'               =>     $_POST["name"],  
                  'item_faculty'          =>     $_POST["faculty"],  
                  'item_imageNo'          =>     $_POST["imageNo"],
                  'item_categoryName'          =>     $_POST["categoryName"],
                  'item_details'          =>     $_POST["details"],
                  'item_startDate'             =>$f_startDate,
                  'item_releaseDate'             =>$f_releaseDate
     
                );  
                $_SESSION["item_cart"][$count] = $item_array;  
           }  
      }  
      else  
      {  
           $item_array = array(  
            'item_id'               =>     $_GET["eq_id"],
            'item_name'               =>     $_POST["name"],  
            'item_faculty'          =>     $_POST["faculty"],  
            'item_imageNo'          =>     $_POST["imageNo"],
            'item_categoryName'          =>     $_POST["categoryName"],
            'item_details'          =>     $_POST["details"],
            'item_startDate'             =>$f_startDate,
            'item_releaseDate'             =>$f_releaseDate

           );  
           $_SESSION["item_cart"][0] = $item_array;  
      }  
}
 //For Rooms
 if(isset($_GET['r_id'])){
  $f_startDate="";
  $f_releaseDate="";
  if(isset($_POST["startDate"]) and isset($_POST["releaseDate"])){
    $f_startDate=$_POST["startDate"];
    $f_releaseDate=$_POST["releaseDate"];
  }
  if(isset($_SESSION["room_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["room_cart"], "room_id");  
           if(!in_array($_GET["r_id"], $item_array_id))  
           {  
                $count = count($_SESSION["room_cart"]);  
                $item_array = array(  
                  'room_id'               =>     $_GET["r_id"],
                  'room_name'               =>     $_POST["name"],  
                  'room_faculty'          =>     $_POST["faculty"],
                  'room_startDate'             =>$f_startDate,
                  'room_releaseDate'             =>$f_releaseDate
                );  
                $_SESSION["room_cart"][$count] = $item_array;  
           }   
      }  
      else  
      {  
           $item_array = array(  
            'room_id'               =>     $_GET["r_id"],
            'room_name'               =>     $_POST["name"],  
            'room_faculty'          =>     $_POST["faculty"],
            'room_startDate'             =>$f_startDate,
            'room_releaseDate'             =>$f_releaseDate
           );  
           $_SESSION["room_cart"][0] = $item_array;  
      }  
}

//Delete process
if(isset($_POST["delete-from-cart"]))
 {
  if($_GET["action"] == "delete")
  {
  if(isset($_GET['r_id'])){
           foreach($_SESSION["room_cart"] as $keys => $values)
           {
                if($values["room_id"] == $_GET["r_id"])
                {
                    array_splice($_SESSION["room_cart"],$keys,1);
                    echo '<script>window.location="userpanel.php?seg=1"</script>';
                }
           }
      }     
   if(isset($_GET['eq_id'])){

    foreach($_SESSION["item_cart"] as $keys => $values)
    {
        if($values["item_id"] == $_GET["eq_id"])
        {
            array_splice($_SESSION["item_cart"],$keys,1);
            echo '<script>window.location="userpanel.php?seg=0"</script>';
        }
    }
   }
  }
 }
 include "dbConn.php"; // Using database connection file here
 if(isset($_POST["submit_items"])){
  foreach($_SESSION["item_cart"] as $keys => $values){
    $values["item_startDate"]=$_POST["startDate".$values["item_id"]];
    $values["item_releaseDate"]=$_POST["releaseDate".$values["item_id"]];
    $query="INSERT INTO requested_items(u_id, i_id,startDate,releaseDate,requestDate,reason) VALUES (".$_SESSION["userid"].",".$values["item_id"].",STR_TO_DATE('".$values["item_startDate"]."','%m/%d/%YT%h:%i'),
    STR_TO_DATE('".$values["item_releaseDate"]."','%m/%d/%YT%h:%i')
    ,NOW(),'".$_POST["reason"]."')";
    if(!mysqli_query($database,$query))
        echo "Error rejecting record"; // display error message if not delete
  }
  mysqli_close($database); // Close connection
  header("location:userpanel.php"); // redirects to all records page
  exit;
 
}
if(isset($_POST["submit_rooms"])){
  foreach($_SESSION["room_cart"] as $keys => $values){
    $values["room_startDate"]=$_POST["startDate".$values["room_id"]];
    $values["room_releaseDate"]=$_POST["releaseDate".$values["room_id"]];
    $query="INSERT INTO requested_rooms(u_id, room_id,startDate,releaseDate,requestDate,reason) VALUES (".$_SESSION["userid"].",".$values["room_id"].",STR_TO_DATE('".$values["room_startDate"]."','%Y-%m-%dT%h:%i'),
    STR_TO_DATE('".$values["room_releaseDate"]."','%Y-%m-%dT%h:%i')
    ,NOW(),'".$_POST["reason"]."')";
      
    if(!mysqli_query($database,$query))
        echo "Error rejecting record"; // display error message if not delete
  }
  mysqli_close($database); // Close connection
  header("location:userpanel.php"); // redirects to all records page
  exit;
 
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ancrow - User Panel</title>
  <link rel="stylesheet" type="text/css" href="css/interface.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="script/userscript.js"></script>
</head>

<body>

  <div class="left_panel ">
    <div id="menu">
      <ul>
        <li class="pp">
          <a href="https://www.hku.edu.tr/">
            <img  src="images/pp.png">
          </a>
        </li>
        <div class="navbar" >
            <li><a id="toRequests" style="color: black;" href="#"><img src="images/logout.png">
            Send Request</a></li>

            <hr><li><a id="toProfile" style="color: #c2c2c2;" href="#"><img  src="images/logout.png">
            My Profile</a></li>
            <li><a style="color: #c2c2c2;" href="http://localhost/InventoryTrackingSystem/login-register.php?exit=1"><img src="images/logout.png">
            Logout</a></li>
          </div>
      </ul>
          
          
          
        <span class="copyright">
          <h3>&copy;All rights Reserved by Ancrow.</h3>
        </span>
    </div>
  </div>
    
    
  </div>
  
    
    <div id="bg_image"></div>
    <!--1st Page-->

    <div id="requests" class="body_panel">
      
      <div id="Equipment" class="<?php 
          if (isset($_GET['seg'])) {
            if($_GET['seg']==1){
                echo "hidden";
            }
          }
          ?>" >
        <div class="container ">
          <table class="items" >
            <caption>
              <h2 class="selected">
                Equipment
              </h2>
              <h2 class="non-selected"> 
                <a id="toRoom" href='#'>Room </a>
              </h2>
            </caption>
            <thead>
              
              <tr >
                <th >Image</th>
                <th>Name</th>
                <th>Faculty</th>
                <th>Category</th>
                <th>Details</th>
                <th>Add to Cart</th>

                
              </tr>
            </thead>
            <tbody>
            <?php 
            
            
                
                
                if(!($database=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE))){
                    die("Could not connect to database</body></html>");
                }   
                else{
                    
                      $query= "SELECT items.id, model.imageNo, model.name, items.faculty, model.details, category.categoryName 
                      FROM items 
                      INNER JOIN model ON items.m_id=model.id INNER JOIN category ON model.c_id=category.id";
                      if(!($result=mysqli_query($database,$query))){
                          print("Could not execute query!<br>");
                          die("</body></html>");
                      }
                      else{
                          while($row=mysqli_fetch_array($result)){
                              
                              ?>
                              
                              <form method="post" action="userpanel.php?action=add&seg=0&eq_id=<?php echo $row["id"]; ?>">  
                              <tr>
                                  <td><img class="logo" src="images/items/<?php echo $row["imageNo"]; ?>.jpg"></td>
                                  <td><?php echo $row['name']; ?></td>
                                  <td><?php echo $row['faculty']; ?></td>
                                  <td><?php echo $row['categoryName']; ?></td>
                                  <td><?php echo $row['details']; ?></td>
                              
                                <input type="hidden" name="name" value="<?php echo $row["name"]; ?>" />  
                                <input type="hidden" name="imageNo" value="<?php echo $row["imageNo"]; ?>" />  
                                <input type="hidden" name="faculty" value="<?php echo $row["faculty"]; ?>" /> 
                                <input type="hidden" name="categoryName" value="<?php echo $row["categoryName"]; ?>" /> 
                                <input type="hidden" name="details" value="<?php echo $row["details"]; ?>" />
                            
                                <td><input type="submit" name="add_to_cart" style="margin-top:5px;" value="  Add  " /></td>   
                              </tr> 
                     </form>
                          <?php
                              }
                              
                      }
                      mysqli_close($database);
                }
              ?>
            </tbody>
            <tfoot>
              <tr></tr>
            </tfoot>
            
          </table>
        </div>
          

        <div class="container">
        
          <table class="items" >
            <caption>
              <h2 >
                Shopping Cart for Equipments
              </h2>
            </caption>
            <thead>
              
              <tr >
                <th >Image</th>
                <th>Name</th>
                <th>Faculty</th>
                <th>Category</th>
                <th>Details</th>
                <th>Start Date</th>
                <th>Release Date</th>
                <th>Delete from Cart</th>               
              </tr>
            </thead>
            <tbody>
              
            <?php 
            function dateDefiner($i_id) {
              include "dbConn.php";
              $query="SELECT DATE_FORMAT(startDate,'%m-%d-%Y') AS start_date, DATE_FORMAT(releaseDate,'%m-%d-%Y') AS release_date FROM requested_items WHERE (SELECT count(r_id) FROM used_items WHERE used_items.r_id=requested_items.id )=0 AND i_id=$i_id;";
              $disableDate = array(array());
              if(!($result=mysqli_query($database,$query))){
               print("Could not execute query!<br>");
               die("</body></html>");
             }
             else{
               $i=0;
               while($row = mysqli_fetch_array($result))
               {
                 $disableDate[$i][0]= $row["start_date"];
                 $disableDate[$i][1]= $row["release_date"];
                 $i++;
               }
           }
           $disableDate=addslashes(json_encode($disableDate));
           mysqli_close($database);   
              return $disableDate;
            }
             
            if(isset($_SESSION["item_cart"])){
              foreach($_SESSION["item_cart"] as $keys => $values)
                  {
                    ?>
                     <form method="post" action="userpanel.php?action=delete&eq_id=<?php echo $values['item_id']; ?>">
                    <tr>
                    <?php
                      $a=dateDefiner($values['item_id']) ;
                    ?>
                    <td><img class="logo" src="images/items/<?php echo $values["item_imageNo"]; ?>.jpg"></td>
                        <td><?php echo $values["item_name"]; ?></td> 
                        <td><?php echo $values["item_categoryName"]; ?></td>
                        <td><?php echo $values["item_faculty"]; ?></td> 
                        <td><?php echo $values["item_details"]; ?></td>
                        <td>Start Date: <input type="text" <?php echo 'name="startDate'.$values['item_id'].'" '?> <?php echo 'id="startDate'.$values['item_id'].'" '?> <?php echo "onchange='endDateloader(\"".$values['item_id']."\",\"$a\");'" ?>  <?php echo "onclick='dateLoader(\"$a\",\"".'Date'.$values['item_id']."\");'" ?> readonly></td>
                        <td>Release Date: <input type="text" <?php echo 'id="releaseDate'.$values['item_id'].'" '?> <?php echo 'name="releaseDate'.$values['item_id'].'" '?>  readonly></td>
                        <td><input type="submit" name="delete-from-cart" style="margin-top:5px;"  value="Delete" /></td>
                    </tr>
                    
                    
                    <?php
                }
              }
              ?>

            </tbody>
            <tfoot>
            
              <tr>

              <td colspan='7'><input type="text" name="reason" style="width:50%;float:left"  placeholder="Input your reason here" /></td>
              <td><input type="submit" name="submit_items"  value="Submit Items" onclick="" /></td>
              
                
              </tr>
              </form>
            </tfoot>
          </table>
          
          
        </div>
    
      </div>
        

      <div id="Room" class="<?php 
        if (!isset($_GET['seg'])) {
          echo 'hidden';
        } 
        else{
          if($_GET['seg']==0){
              echo "hidden";
          }
        }
        ?>" >
        <div class="container">
            <table class="items">
              <caption>
                <h2 class="non-selected">
                  <a id="toEquipment" href='#'>Equipment </a>
                </h2>
                <h2 class="selected"> 
                Room
                </h2>
              </caption>
              <thead>
                
                <tr >
                  <th>Name</th>
                  <th>Faculty</th>
                  <th>Add to room cart</th>
                  
                </tr>
              </thead>
              <tbody>
              <?php                 
                if(!($database=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE))){
                    die("Could not connect to database</body></html>");
                }   
                else{                 
                      $query= "SELECT*FROM rooms";
                      if(!($result=mysqli_query($database,$query))){
                          print("Could not execute query!<br>");
                          die("</body></html>");
                      }
                      else{
                        while($row = mysqli_fetch_array($result))
                        {
                        ?>
                          <form method="post" action="userpanel.php?action=add&seg=1&r_id=<?php echo $row["id"]; ?>">
                              <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['faculty']; ?></td>                          
                                <input type="hidden" name="name" value="<?php echo $row["name"]; ?>" />
                                <input type="hidden" name="faculty" value="<?php echo $row["faculty"]; ?>" /> 
                                <td><input type="submit" name="add_to_room" style="margin-top:5px;"  value="Add" /></td>
                              </tr> 
                     </form>
                        <?php
                        }
                      }
                      mysqli_close($database);               
                }
              ?>
              </tbody>
              
            </table>
        </div>
                  
        <div  class="container">
            <table class="items">
              <caption>
                <h2>
                  Room Cart
                </h2>    
              </caption>
              <thead>      
                <tr >
                  <th >Name</th>
                  <th>Faculty</th>
                  <th>Start Date</th>
                  <th>Release Date</th>
                  <th>Delete from Cart</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              if(isset($_SESSION["room_cart"])){
                    foreach($_SESSION["room_cart"] as $keys => $values)
                    {
                    ?>
                     <form method="post" action="userpanel.php?action=delete&r_id=<?php echo $values['room_id']; ?>">
                    <tr>
                        <td><?php echo $values["room_name"]; ?></td> 
                        <td><?php echo $values["room_faculty"]; ?></td> 
                        
                        <td><input type="date" <?php echo 'name="startDate'.$values['room_id'].'" '?> /></td>
                        <td><input type="date" <?php echo 'name="releaseDate'.$values['room_id'].'" '?> /></td>
                        <td><input type="submit" name="delete-from-cart" style="margin-top:5px;"  value="Delete" /></td>
                    </tr>
                    
                    <?php
                  }
                }
              ?>
              </tbody>
              <tfoot>
            
              <tr>

              <td colspan='4'><input type="text" name="reason" style="width:80%;float:left"  placeholder="Input your reason here" /></td>
              <td><input type="submit" name="submit_rooms"  value="Submit Rooms" onclick="" /></td>
              
                
              </tr>
              </form>
            </tfoot>
            </table>
        </div>
      </div>
      
    </div>
        
    
       
      
      <!--5th Page-->
    <div id="profile" class="body_panel hidden">
        <div class="container">
          <table class="items">
            <caption>
              <h2 >
                PROFILE
              </h2>
            </caption>
            <thead>
              
              <tr >
                <th >ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Faculty</th>
                <th>Department</th>
                <th>Phone Number</th>
                <th>E-mail</th>
                <th>Confirmation</th>
                
              </tr>
            </thead>
            <tbody>
            <?php 
                if(!($database=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE))){
                    die("Could not connect to database</body></html>");
                }   
                else{
                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                      $query= "SELECT student_id,name,surname,faculty,department,phone,email FROM user";
                      if(!($result=mysqli_query($database,$query))){
                          print("Could not execute query!<br>");
                          die("</body></html>");
                      }
                      else{
                          while($row=mysqli_fetch_row($result)){
                              echo "<tr>";
                              foreach($row as $key=>$value)
                                  print("<td> $value</td>");
                                print("<td><a href='https://www.google.com'>Accept</a>/<a href='https://www.youtube.com'>Reject</a></td>");
                                
                              echo "</tr>" ;
                          } 
                      }
                      mysqli_close($database);
                  }  
                }
              ?>
            </tbody>
          </table>
        </div>
      
        <div class="container">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe, aliquid voluptatum, nostrum dicta nobis earum similique neque, consequuntur ipsam harum adipisci. Animi facere expedita veritatis cumque. Rem, unde delectus. Beatae perferendis maxime quam illum eveniet est ratione adipisci impedit cupiditate dolores, doloribus sint nemo sit? Corporis reprehenderit eaque velit eos suscipit id tenetur qui pariatur exercitationem ipsa nobis alias ipsam maiores necessitatibus soluta veritatis non, sint neque ut? Labore atque magnam minima, facilis optio ipsam, sit sapiente saepe earum nostrum, possimus suscipit libero fuga animi. Provident dolores labore sequi debitis aliquid libero ducimus eveniet. Debitis illum harum error tempore porro!</div>
        
    </div>
  
</body>
</html>
<?php }else{
  header("Location: http://localhost/InventoryTrackingSystem/login-register.php");
}
?>