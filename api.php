<?php

 header('content-type: application/json');
  
 $request=$_SERVER['REQUEST_METHOD'];
    switch ($request) {
        case 'GET':
            getMethod();
            break;
        case 'POST':
         $data=json_decode(file_get_contents('php://input'),true);
           postMethod($data);
            break;
        case 'PUT':
            $data=json_decode(file_get_contents('php://input'),true);
            putMethod($data);
            break;
        case 'DELETE':
            $data=json_decode(file_get_contents('php://input'),true);
            delete($data);
            break;
        
        default:
        echo'{"name":"NOT FOUND"}';
            break;
    }

    
function getMethod(){
    include "database.php";
    
    
    $sql="SELECT * FROM users";
   $result=mysqli_query($conn,$sql);

   if(mysqli_num_rows($result)>0){
       $rows=array();

   while ($r = mysqli_fetch_assoc($result)) {
    $rows["result"][]=$r;
   }

   echo json_encode($rows);

   }else {
    echo'{"result":"data not found"}';
   }
  }
// get method end




// post method end


function postMethod($data){
  include "database.php";
  $username=$data{"name"};
  $useremail=$data["email"];


  $sql="INSERT INTO users(name,email) VALUES ('$username','$useremail')";

  if(mysqli_query($conn,$sql)){
      echo'{"result":"data inserted"}';
  }else {
      echo'{"result":"data not inserted"}';
  }

}


function putMethod($data){
    include "database.php";
    $id=$data["id"];
    $username=$data["name"];
    $useremail=$data["email"];
  
  
    $sql="UPDATE  users SET name='$username',email='$useremail'  where id='$id'  ";
  
    if(mysqli_query($conn,$sql)){
        echo'{"result":"data updated"}';
    }else {
        echo'{"result":"data not updated"}';
    }
  
  }



function delete($data){
    include "database.php";
    $id=$data["id"];

  
    $sql="DELETE FROM users where id='$id'  ";
  
    if(mysqli_query($conn,$sql)){
        echo'{"result":"data deleted"}';
    }else {
        echo'{"result":"data not deleted"}';
    }

  }




?>