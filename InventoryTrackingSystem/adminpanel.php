<?php 
session_start();
if(isset($_SESSION["userid"])){
  include "dbConn.php"; 
  $query= "INSERT INTO items_in_use(r_id) SELECT requested_items.id
  FROM requested_items 
  WHERE requested_items.confirmed=1  AND requested_items.startDate <= NOW() AND (SELECT count(r_id) FROM items_in_use WHERE items_in_use.r_id=requested_items.id )=0 
  AND (SELECT count(r_id) FROM used_items WHERE used_items.r_id=requested_items.id )=0";
  if(!($result=mysqli_query($database,$query))){
      print("Could not execute query!<br>");
      die("</body></html>");
  }

  $query= "INSERT INTO rooms_in_use(r_id) SELECT requested_rooms.id
  FROM requested_rooms 
  WHERE requested_rooms.confirmed=1  AND requested_rooms.startDate <= NOW() AND (SELECT count(r_id) FROM rooms_in_use WHERE rooms_in_use.r_id=requested_rooms.id )=0 
  AND (SELECT count(r_id) FROM used_rooms WHERE used_rooms.r_id=requested_rooms.id )=0";
  if(!($result=mysqli_query($database,$query))){
      print("Could not execute query!<br>");
      die("</body></html>");
  }
  ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ancrow - Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="css/interface.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  
  <script type="text/javascript" src="script/adminscript.js"></script>
</head>

<body  >

  <div class="left_panel ">
    <div id="menu">
      <ul>
        <li class="pp">
          <a href="https://www.hku.edu.tr/">
            <img  src="images/pp.png">
          </a>
        </li>
        <div class="navbar">
            <li><a id="toRegistrations" style="color: black;" href="#"><img src="images/logout.png">
            Registration Requests</a></li>
            <li><a id="toRequests" style="color: #c2c2c2;" href="#"><img src="images/logout.png">
            Equipment/Room Requests</a></li>
            <li><a id="toActiveOnes" style="color: #c2c2c2;" href="#"><img src="images/logout.png">
            Equipments/Rooms in Use</a></li>
            <li><a id="toHistoryR" style="color: #c2c2c2" href="#"><img src="images/logout.png">
            Request History</a></li>
            <li><a id="toHistoryD" style="color: #c2c2c2" href="#"><img src="images/logout.png">
            Deliveries History</a></li>
            <hr><li><a id="toProfile" style="color: #c2c2c2;" href="#"><img  src="images/logout.png">
            My Profile</a></li>
            <li><a style="color: #c2c2c2;" href="http://localhost/InventoryTrackingSystem/login-register.php"><img src="images/logout.png">
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

    <div id="registrations" class="body_panel ">
        <div class="container">
          <table class="items">
            <caption>
              <h2 >
                Registrations
              </h2>
            </caption>
            <thead>
              
              <tr >
                <th >ID</th>
                <th>Fullname</th>
                <th>Faculty</th>
                <th>Department</th>
                <th>Phone Number</th>
                <th>E-mail</th>
                <th>Confirmation</th>
                
              </tr>
            </thead>
            <tbody>
            <?php 
                include "dbConn.php"; 
                $query= "SELECT student_id,concat(name,' ',surname) as fullname,faculty,department,phone,email FROM user WHERE confirmed is null;";
                      if(!($result=mysqli_query($database,$query))){
                          print("Could not execute query!<br>");
                          die("</body></html>");
                      }
                      else{
                        while($data = mysqli_fetch_array($result))
                        {
                        ?>
                          <tr>
                            <td><?php echo $data['student_id']; ?></td>
                            <td><?php echo $data['fullname']; ?></td>
                            <td><?php echo $data['faculty']; ?></td>
                            <td><?php echo $data['department']; ?></td> 
                            <td><?php echo $data['phone']; ?></td> 
                            <td><?php echo $data['email']; ?></td>
                            <td><a href="registration.php?registration=accept&id=<?php echo $data['student_id']; ?>">Accept</a> / <a href="registration.php?registration=reject&id=<?php echo $data['student_id']; ?>">Reject</a></td>

                          </tr>
                        <?php
                        }

                      }
                      mysqli_close($database);

              ?>
            </tbody>
          </table>
        </div>
      
        <div class="container"></div>
        
    </div>
       
      <!--2nd Page-->
    
      <div id="requests" class="body_panel hidden">
        <div id="Equipment" class="container">
          <table class="items">
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
                <th>Image</th>
                <th>Fullname</th>
                <th>Start Date</th>
                <th>Release Date</th>
                <th>Request Date</th>
                <th>Reason</th>
                <th>Confirmation</th>
                
              </tr>
            </thead>
            <tbody>
            <?php 
            include "dbConn.php";
            $query= "SELECT requested_items.id,model.imageNo, Concat(user.name,' ',user.surname) AS fullname,requested_items.startDate,requested_items.releaseDate,requested_items.requestDate,requested_items.reason 
            FROM requested_items 
            INNER JOIN items ON items.id=requested_items.i_id INNER JOIN model ON model.id=items.m_id 
            INNER JOIN user ON user.student_id=requested_items.u_id WHERE requested_items.confirmed is null";
                if(!($result=mysqli_query($database,$query))){
                    print("Could not execute query!<br>");
                    die("</body></html>");
                }
                else{
                  while($row=mysqli_fetch_array($result)){
                    ?>
                      <tr>
                      <td><img class="logo" src="images/items/<?php echo $row['imageNo']; ?>.jpg"></td>
                      <td><?php echo $row['fullname']; ?></td>
                      <td><?php echo $row['startDate']; ?></td>
                      <td><?php echo $row['releaseDate']; ?></td>
                      <td><?php echo $row['requestDate']; ?></td>
                      <td><?php echo $row['reason']; ?></td>
                      <td><a href="registration.php?eq_conf=accept&id=<?php echo $row['id']; ?>">Accept</a> / <a href="registration.php?eq_conf=reject&id=<?php echo $row['id']; ?>">Reject</a></td>                            
                      </tr>  
                        <?php                           
                  } 
                  mysqli_close($database);
              }
              

      ?>
            </tbody>
          </table>
        </div>


        <div id="Room" class="container hidden">
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
                <th>Room Name</th>
                <th>Fullname</th>
                <th>Start Date</th>
                <th>Release Date</th>
                <th>Request Date</th>
                <th>Reason</th>
                <th>Confirmation</th>
                
                
              </tr>
            </thead>
            <tbody>
            <?php 
                
                include "dbConn.php";
                $query= "SELECT requested_rooms.id,rooms.name, Concat(user.name,' ',user.surname) AS fullname,requested_rooms.startDate,requested_rooms.releaseDate,requested_rooms.requestDate,requested_rooms.reason 
                FROM requested_rooms INNER JOIN rooms ON rooms.id=requested_rooms.room_id INNER JOIN user ON user.student_id=requested_rooms.u_id 
                WHERE requested_rooms.confirmed is null";
                if(!($result=mysqli_query($database,$query))){
                    print("Could not execute query!<br>");
                    die("</body></html>");
                }
                else{
                  while($row=mysqli_fetch_array($result)){
                    ?>
                      <tr>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['fullname']; ?></td>
                      <td><?php echo $row['startDate']; ?></td>
                      <td><?php echo $row['releaseDate']; ?></td>
                      <td><?php echo $row['requestDate']; ?></td>
                      <td><?php echo $row['reason']; ?></td>
                      <td><a href="registration.php?room_conf=accept&id=<?php echo $row['id']; ?>">Accept</a> / <a href="registration.php?room_conf=reject&id=<?php echo $row['id']; ?>">Reject</a></td>                            
                      </tr>  
                        <?php                           
                  } 
                  mysqli_close($database);
              }
              

      ?>
            </tbody>
          </table>
        </div>
       
        
        
    </div>

      <!--3rd Page-->

      <div id="active_ones" class="body_panel hidden">
        <div id="Equipment_inuse" class="container">
          <table class="items">
            <caption>
              <h2 class="selected">
                Equipment
              </h2>
              <h2 class="non-selected"> 
                <a id="toRoom_inuse" href='#'>Room </a>
              </h2>
            </caption>
            <thead>
              
              <tr >
                <th>Item Image</th>
                <th>Fullname</th>
                <th>Start Date</th>
                <th>Release Date</th>
                <th>Request Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Delivery</th>
                
                
              </tr>
            </thead>
            <tbody>
            <?php 
            include "dbConn.php"; 
            $query= "SELECT items_in_use.r_id,requested_items.id, model.imageNo, Concat(user.name,' ',user.surname) AS fullname,requested_items.startDate,requested_items.releaseDate,requested_items.requestDate,requested_items.reason 
            FROM requested_items 
            INNER JOIN items_in_use ON items_in_use.r_id=requested_items.id INNER JOIN items ON items.id=requested_items.i_id 
            INNER JOIN model ON model.id=items.m_id INNER JOIN user ON user.student_id=requested_items.u_id";
            if(!($result=mysqli_query($database,$query))){
                print("Could not execute query!<br>");
                die("</body></html>");
            }
            else{
              while($row=mysqli_fetch_array($result)){
                ?>
                <form method="post" action="registration.php?item_r_id=<?php echo $row["r_id"]; ?>">  
                  <tr>
                    <td><img class="logo" src="images/items/<?php echo $row['imageNo']; ?>.jpg"></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['startDate']; ?></td>
                    <td><?php echo $row['releaseDate']; ?></td>
                    <td><?php echo $row['requestDate']; ?></td>
                    <td><?php echo $row['reason']; ?></td>
                    <td><input type="text" name="status" placeholder="Plese enter status" /> </td>
                    <td><input type="submit" name="delivery" style="margin-top:5px;" value="Deliver" /></td>                           
                  </tr> 
                </form>
                    <?php                           
              } 
                mysqli_close($database);
            }
                    

            ?>
            </tbody>
          </table>
        </div>

        <div id="Room_inuse" class="container hidden">
          <table class="items">
            <caption>
              <h2 class="non-selected">
                <a id="toEquipment_inuse" href='#'>Equipment </a>
              </h2>
              <h2 class="selected"> 
               Room
              </h2>
            </caption>
            <thead>
              
              <tr >
                <th>Room Name</th>
                <th>Fullname</th>
                <th>Start Date</th>
                <th>Release Date</th>
                <th>Request Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Delivery</th>
                
              </tr>
            </thead>
            <tbody>
       
            <?php 
                include "dbConn.php"; 
                $query= "SELECT rooms_in_use.r_id,requested_rooms.id, rooms.name,Concat(user.name,' ',user.surname) AS 
                fullname,requested_rooms.startDate,requested_rooms.releaseDate,requested_rooms.requestDate,requested_rooms.reason 
                FROM requested_rooms INNER JOIN rooms_in_use ON rooms_in_use.r_id=requested_rooms.id 
                INNER JOIN rooms ON rooms.id=requested_rooms.room_id INNER JOIN user ON user.student_id=requested_rooms.u_id;";
                if(!($result=mysqli_query($database,$query))){
                    print("Could not execute query!<br>");
                    die("</body></html>");
                }
                else{
                  while($row = mysqli_fetch_array($result))
                  {
                  ?>
                    <form method="post" action="registration.php?room_r_id=<?php echo $row["r_id"]; ?>">  
                      <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['startDate']; ?></td>
                        <td><?php echo $row['releaseDate']; ?></td>
                        <td><?php echo $row['requestDate']; ?></td>
                        <td><?php echo $row['reason']; ?></td>
                        <td><input type="text" name="status" placeholder="Plese enter status" /> </td>
                        <td><input type="submit" name="delivery" style="margin-top:5px;" value="Deliver" /></td>                           
                      </tr> 
                  </form>
                  <?php
                  }

                    mysqli_close($database);
                }
                
             
              ?>
            </tbody>
          </table>
        </div>
        
      </div>
    
      <!--4th Page-->
                
      <div id="request_history" class="body_panel hidden">
        <div class="container">
          <table class="items">
            <caption>
              <h2 >
                Equipment Requests
              </h2>
            </caption>
            <thead>
              <tr >
                <th>Image</th>
                <th>User Name</th>           
                <th>Confirmation</th> 
                <th>Start Date</th> 
                <th>Release Date</th> 
                <th>Request Date</th> 
                <th>Reason</th>
        
              </tr>
            </thead>
            <tbody>
            <?php 
                include "dbConn.php"; 
                      $query= "SELECT model.imageNo, Concat(user.name,' ',user.surname) AS fullname,requested_items.confirmed,requested_items.startDate,requested_items.releaseDate,requested_items.requestDate,requested_items.reason 
                      FROM requested_items 
                      INNER JOIN items ON items.id=requested_items.i_id 
                      INNER JOIN model ON model.id=items.m_id INNER JOIN user ON user.student_id=requested_items.u_id WHERE requested_items.confirmed is not null";
                      if(!($result=mysqli_query($database,$query))){
                          print("Could not execute query!<br>");
                          die("</body></html>");
                      }
                      else{
                          while($row=mysqli_fetch_array($result)){
                            ?>
                              <tr>
                              <td><img class="logo" src="images/items/<?php echo $row['imageNo']; ?>.jpg"></td>
                              <td><?php echo $row['fullname']; ?></td>
                              <?php if($row['confirmed']==1){
                                        print("<td style='color:green'> Accepted </td>");  
                                      }
                                      else{
                                        print("<td style='color:red'> Rejected </td>");
                                      }?>
                              <td><?php echo $row['startDate']; ?></td>
                              <td><?php echo $row['releaseDate']; ?></td>
                              <td><?php echo $row['requestDate']; ?></td>
                              <td><?php echo $row['reason']; ?></td>
                           
                              </tr>  
                                <?php                           
                          } 
                          mysqli_close($database);
                      }
                      
  
              ?>
            </tbody>
          </table>
        </div>
      
        <div class="container"><table class="items">
            <caption>
              <h2 >
                Room Requests
              </h2>
            </caption>
            <thead>
              <tr >
                <th>Room Name</th>
                <th>User Name</th>           
                <th>Confirmation</th> 
                <th>Start Date</th> 
                <th>Release Date</th> 
                <th>Request Date</th> 
                <th>Reason</th>                 
              </tr>
            </thead>
            <tbody>
            <?php 
            include "dbConn.php"; 
            $query= "SELECT rooms.name,Concat(user.name,' ',user.surname) AS fullname,requested_rooms.confirmed,requested_rooms.startDate,requested_rooms.releaseDate,requested_rooms.requestDate,requested_rooms.reason, used_rooms.status FROM requested_rooms 
            INNER JOIN rooms ON rooms.id=requested_rooms.room_id 
            INNER JOIN user ON user.student_id=requested_rooms.u_id INNER JOIN used_rooms ON used_rooms.r_id=requested_rooms.id WHERE requested_rooms.confirmed is not null";
            if(!($result=mysqli_query($database,$query))){
                print("Could not execute query!<br>");
                die("</body></html>");
            }
            else{
              while($row=mysqli_fetch_array($result)){
                ?>
                  <tr>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <?php if($row['confirmed']==1){
                            print("<td style='color:green'> Accepted </td>");  
                          }
                          else{
                            print("<td style='color:red'> Rejected </td>");  
                            
                          } ?>
                  <td><?php echo $row['startDate']; ?></td>
                  <td><?php echo $row['releaseDate']; ?></td>
                  <td><?php echo $row['requestDate']; ?></td>
                  <td><?php echo $row['reason']; ?></td>                            
                  </tr>  
                    <?php                           
              } 
              mysqli_close($database);
            }
                   
              ?>
            </tbody>
          </table></div>
        
    </div>
    <!--5th Page-->
                
    <div id="deliveries_history" class="body_panel hidden">
        <div class="container">
          <table class="items">
            <caption>
              <h2 >
                Equipment Requests
              </h2>
            </caption>
            <thead>
              <tr >
                <th>Image</th>
                <th>User Name</th>            
                <th>Start Date</th> 
                <th>Release Date</th> 
                <th>Reason</th>
                <th>Status</th>          
              </tr>
            </thead>
            <tbody>
            <?php 
                include "dbConn.php"; 
                      $query= "SELECT model.imageNo,used_items.releaseDate, Concat(user.name,' ',user.surname) AS fullname,requested_items.startDate,requested_items.reason,used_items.status
                      FROM requested_items 
                      INNER JOIN items ON items.id=requested_items.i_id INNER JOIN model ON model.id=items.m_id INNER JOIN user ON user.student_id=requested_items.u_id 
                      INNER JOIN used_items ON used_items.r_id=requested_items.id";
                      if(!($result=mysqli_query($database,$query))){
                          print("Could not execute query!<br>");
                          die("</body></html>");
                      }
                      else{
                          while($row=mysqli_fetch_array($result)){
                            ?>
                              <tr>
                              <td><img class="logo" src="images/items/<?php echo $row['imageNo']; ?>.jpg"></td>
                              <td><?php echo $row['fullname']; ?></td>
                              <td><?php echo $row['startDate']; ?></td>
                              <td><?php echo $row['releaseDate']; ?></td>
                              <td><?php echo $row['reason']; ?></td>
                              <td><?php echo $row['status']; ?></td>                              
                              </tr>  
                                <?php                           
                          } 
                          mysqli_close($database);
                      }
                      
  
              ?>
            </tbody>
          </table>
        </div>
      
        <div class="container"><table class="items">
            <caption>
              <h2 >
                Room Requests
              </h2>
            </caption>
            <thead>
              <tr >
                <th>Room Name</th>
                <th>User Name</th>           
                <th>Confirmation</th> 
                <th>Start Date</th> 
                <th>Release Date</th> 
                <th>Request Date</th> 
                <th>Reason</th>                 
              </tr>
            </thead>
            <tbody>
            <?php 
            include "dbConn.php"; 
            $query= "SELECT rooms.name,used_rooms.releaseDate,Concat(user.name,' ',user.surname) AS fullname,requested_rooms.startDate,requested_rooms.reason, used_rooms.status 
            FROM requested_rooms 
            INNER JOIN rooms ON rooms.id=requested_rooms.room_id 
            INNER JOIN user ON user.student_id=requested_rooms.u_id INNER JOIN used_rooms ON used_rooms.r_id=requested_rooms.id;";
            if(!($result=mysqli_query($database,$query))){
                print("Could not execute query!<br>");
                die("</body></html>");
            }
            else{
              while($row=mysqli_fetch_array($result)){
                ?>
                  <tr>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['fullname']; ?></td>
                  <td><?php echo $row['startDate']; ?></td>
                  <td><?php echo $row['releaseDate']; ?></td>
                  <td><?php echo $row['reason']; ?></td>                            
                  </tr>  
                    <?php                           
              } 
              mysqli_close($database);
            }
                   
              ?>
            </tbody>
          </table></div>
        
    </div>
      <!--6th Page-->
    <div id="profile" class="body_panel hidden">
        <div class="container">
          <table class="items">
            <caption>
              <h2 >
                Registrations
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
                include "dbConn.php"; 
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
                          //print("<td><a href='https://www.google.com'>Accept</a>/<a href='https://www.youtube.com'>Reject</a></td>");
                          
                        echo "</tr>" ;
                    } 
                    mysqli_close($database);
                }
              ?>
            </tbody>
          </table>
        </div>
        
    </div>
  
</body>
</html>
<?php }else{
  header("Location: http://localhost/InventoryTrackingSystem/login-register.php");
}
?>