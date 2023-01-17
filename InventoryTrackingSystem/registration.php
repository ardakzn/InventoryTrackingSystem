<?php
session_start();
include "dbConn.php"; // Using database connection file here

 // get id through query string

if(isset($_GET['id'])){
    $id = $_GET['id'];
    if(array_values($_GET)[0]=="accept"){
        $index=array_search("accept",$_GET);
        $confirmed=1;
 
    }
    else {
        $index=array_search("reject",$_GET);
        $confirmed=0;
    }

    $query=array("registration"=>"UPDATE user SET confirmed=$confirmed WHERE user.student_id=$id",
    "eq_conf"=>"UPDATE requested_items SET confirmed=$confirmed WHERE requested_items.id=$id",
    "room_conf"=>"UPDATE requested_rooms SET confirmed=$confirmed WHERE requested_rooms.id=$id");
    echo $index;
   
    if(!mysqli_query($database,$query[$index]))
    {
        echo "Error rejecting record"; // display error message if not delete
    }
    else
    {
        mysqli_close($database); // Close connection
        header("location:adminpanel.php"); // redirects to all records page
        exit;	
    }
        

}
if(isset($_GET['item_r_id'])){
    
    $query="INSERT INTO used_items(r_id,releaseDate,status) SELECT items_in_use.r_id,NOW(),'".$_POST['status']."' FROM items_in_use WHERE items_in_use.r_id=".$_GET['item_r_id'];
    $queryDel="DELETE FROM items_in_use WHERE items_in_use.r_id=".$_GET['item_r_id'];
    mysqli_query($database,$query);
    mysqli_query($database,$queryDel);
    mysqli_close($database); // Close connection
    header("location:adminpanel.php"); // redirects to all records page
    exit();
   
}
if(isset($_GET['room_r_id'])){
    
    $query="INSERT INTO used_rooms(r_id,releaseDate,status) SELECT rooms_in_use.r_id,NOW(),'".$_POST['status']."' FROM rooms_in_use WHERE rooms_in_use.r_id=".$_GET['room_r_id'];
    $queryDel="DELETE FROM rooms_in_use WHERE rooms_in_use.r_id=".$_GET['room_r_id'];
    mysqli_query($database,$query);
    mysqli_query($database,$queryDel);
    mysqli_close($database); // Close connection
    header("location:adminpanel.php"); // redirects to all records page
    exit();
   
}




?>