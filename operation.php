<?php

require_once ("db.php");
require_once ("component.php");



// create button click
if(isset($_POST['create'])){
    createData();
}
// update button click
if(isset($_POST['update'])){
    UpdateData();
}
// delete button click
if(isset($_POST['delete'])){
    deleteRecord();
}

if(isset($_POST['deleteall'])){
    deleteAll();

}
// inputs data into the respective tables
function createData(){
    $name = textboxValue("task_name");
    $det = textboxValue("task_detail");
    $status = textboxValue("task_status");
    $due = textboxValue("task_due");
    $username=$_SESSION['username'];
    if($name && $det && $status){

        if($_SESSION['typeoftask'] === "professional"){
            $sql = "INSERT INTO professional (task_name, task_detail, task_status,task_due,user) 
                        VALUES ('$name','$det','$status','$due','$username')";
                        
        }
        if($_SESSION['typeoftask'] === "personal"){
            $sql = "INSERT INTO personal (task_name, task_detail, task_status,task_due,user) 
                        VALUES ('$name','$det','$status','$due','$username')";
        }
        
        if(mysqli_query($GLOBALS['con'], $sql)){
            TextNode("success", "Record Successfully Inserted...!");
           
        }else{
            echo "Error";
        }

    }else{
            TextNode("error", "Provide Data in the Textbox");
    }
}

function textboxValue($value){
    $textbox = mysqli_real_escape_string($GLOBALS['con'], trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox;
    }
}


// messages
function TextNode($classname, $msg){
    $element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}


// get data from mysql database
function getData(){

    $username=$_SESSION['username'];

    if($_SESSION['typeoftask'] === "professional"){
    $sql = "SELECT * FROM professional WHERE user = '$username' ORDER BY task_due ASC";
    }
    if($_SESSION['typeoftask'] === "personal"){
        $sql = "SELECT * FROM personal WHERE user = '$username' ORDER BY task_due ASC";
        }
    $result = mysqli_query($GLOBALS['con'], $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}

// update data
function UpdateData(){
    $id = textboxValue("task_id");
    $name = textboxValue("task_name");
    $det = textboxValue("task_detail");
    $status = textboxValue("task_status");
    $due = textboxValue("task_due");
    $username=$_SESSION['username'];

    if($name && $det && $status){
        if($_SESSION['typeoftask'] === "professional"){
        $sql = "
                    UPDATE professional SET task_name='$name', task_detail = '$det', task_status = '$status', task_due = '$due' WHERE id='$id' AND user = '$username';                    
        ";
        }
        if($_SESSION['typeoftask'] === "personal"){
            $sql = "
                        UPDATE personal SET task_name='$name', task_detail = '$det', task_status = '$status', task_due = '$due' WHERE id='$id' AND user = '$username';                    
            ";
            }
        if(mysqli_query($GLOBALS['con'], $sql)){
            TextNode("success", "Data Successfully Updated");
        }else{
            TextNode("error", "Enable to Update Data");
        }

    }else{
        TextNode("error", "Select Data Using Edit Icon");
    }


}

// deletes data of users from respective tables
function deleteRecord(){
    $username=$_SESSION['username'];
    $id = (int)textboxValue("task_id");
    if($_SESSION['typeoftask'] === "personal"){
    $sql = "DELETE FROM personal WHERE id=$id AND user = '$username'";
    }
    if($_SESSION['typeoftask'] === "professional"){
        $sql = "DELETE FROM professional WHERE id=$id AND user = '$username'";
        }
    if(mysqli_query($GLOBALS['con'], $sql)){
        TextNode("success","Record Deleted Successfully...!");
    }else{
        TextNode("error","Enable to Delete Record...!");
    }

}


function deleteBtn(){
    $result = getData();
    $i = 0;
    if($result){
        while ($row = mysqli_fetch_assoc($result)){
            $i++;
            if($i > 3){
                buttonElement("btn-deleteall", "btn btn-danger" ,"<i class='fas fa-trash'></i> Delete All", "deleteall", "");
                return;
            }
        }
    }
}

// deletes all data of a user from a table
function deleteAll(){
    $username=$_SESSION['username'];
    if($_SESSION['typeoftask'] === "personal"){
        $sql = "DELETE FROM personal WHERE user = '$username';";
    }
    if($_SESSION['typeoftask'] === "professional"){
        $sql = "DELETE FROM professional WHERE user = '$username';";
    }
    if(mysqli_query($GLOBALS['con'], $sql)){
        TextNode("success","All Record deleted Successfully...!");
        
    }else{
        TextNode("error","Something Went Wrong Record cannot deleted...!");
    }
}


// set id to textbox
function setID(){
    $getid = getData();
    if($_SESSION['typeoftask'] === "personal")
    {
    $id = 0;
    if($getid){
        while ($row = mysqli_fetch_assoc($getid)){
            $id = $row['id'];
        }
    }
   }
   if($_SESSION['typeoftask'] === "professional")
    {
    $id = 0;
    if($getid){
        while ($row = mysqli_fetch_assoc($getid)){
            $id = $row['id'];
        }
    }
   }

    return ($id + 1);
}








