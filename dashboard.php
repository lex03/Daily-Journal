<?php
include("auth_session.php");

require_once ("component.php");
require_once ("operation.php");
//on clinking submit button taking the value for type of user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["radios"])) {
    // $_SESSION['typeoftask'] = "Selection is required";
    // echo "Selection is required";
    // TextNode("error", "Selection and submission is required");
   } else {
     $_SESSION['typeoftask'] = $_POST["radios"];
   }
 }
 

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Rendering title based on typeof task -->
    <title>
    
    <?php if( $_SESSION['typeoftask'] === " "){ ?>
    To Do List
    <?php }
    if($_SESSION['typeoftask'] === "professional"){
    ?>
    Professional To Do List
    <?php
    }
    if($_SESSION['typeoftask'] === "personal"){
    ?>
    Personal To Do List
    <?php
    }
    ?>

    </title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="style.css">

</head>
<body>

<main>
   <!-- Rendering header based on typeof task -->
        <h1 class="py-4 bg-danger text-light rounded text-center"><i class="fas fa-tasks"></i><?php if( $_SESSION['typeoftask'] === " "){ ?>
    To Do List
    <?php }
    if($_SESSION['typeoftask'] === "professional"){
    ?>
    Welcome <?php echo $_SESSION['username']?> To your Professional To Do List
    <?php
    }
    if($_SESSION['typeoftask'] === "personal"){
    ?>
    Welcome <?php echo $_SESSION['username']?> To your  Personal To Do List
    <?php
    }
    ?></h1>
    <!-- logout button -->
    <p class="logout"><a class="btn btn-danger" href="login.php">LogOut</a></p>
        <div class="container text-center">
        <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <div class="form-check">
            <input class="form-check-input" type="radio" name="radios" id="Professional" value="professional" 
            <?php
            if($_SESSION['typeoftask'] === "professional")
            {  //marking the checkbox based on type of task
            ?>
            checked
            <?php
            }
            ?>
            >
            <label class="form-check-label font-weight-bold" for="Professional">
                Professional
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="radios" id="Personal" value="personal"
            <?php
            if($_SESSION['typeoftask'] === "personal")
            {
            ?>
            checked
            <?php
            }
            ?>
            >
            <label class="form-check-label font-weight-bold" for="Personal">
                Personal
            </label>
        </div>
        <input class="but" id="llll" type="submit" name="submit" value="Submit"> 
        </form>
        <!-- getting inputs from the user -->
        <div class="d-flex justify-content-center">
            <form action="" method="post" class="w-50">
                <div class="pt-2" hidden>
                    <?php inputElement("<i class='fas fa-id-badge'></i>","ID", "task_id",setID()); ?>
                </div>
                <div class="pt-2">
                    <?php inputElement("<i class='fas fa-book'></i>","Subject", "task_name",""); ?>
                </div>
                <div class="pt-2">
                    
                        <?php inputElement("<i class='fas fa-people-carry'></i>","Detail", "task_detail",""); ?>
                    </div>
                    <div class=" pt-2">
                    <?php inputElement("<i class='fas fa-calendar-check'></i>","Status", "task_status",""); ?>
                    </div>
                    <div class=" pt-2">
                    <?php input("<i class='fas fa-table'></i>","", "task_due",""); ?>
                    </div>
                </div>
                <!-- buttons to perform CRUD -->
                <div class="d-flex justify-content-center">
                        <?php buttonElement("btn-create","btn btn-success","<i class='fas fa-plus'></i>","create","data-toggle='tooltip' data-placement='bottom' title='Create'"); ?>
                        <?php buttonElement("btn-read","btn btn-primary","<i class='fas fa-sync'></i>","read","data-toggle='tooltip' data-placement='bottom' title='Read'"); ?>
                        <?php buttonElement("btn-update","btn btn-light border","<i class='fas fa-pen-alt'></i>","update","data-toggle='tooltip' data-placement='bottom' title='Update'"); ?>
                        <?php buttonElement("btn-delete","btn btn-danger","<i class='fas fa-trash-alt'></i>","delete","data-toggle='tooltip' data-placement='bottom' title='Delete'"); ?>
                        <?php deleteBtn();?>
                </div>
            </form>
        </div>

        <!-- Bootstrap table  -->
        <div class="d-flex table-data">
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Subject</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                
<?php
               //displaying the lists of tasks
                   if(isset($_POST['read'])){
                       $result = getData();

                       if($result){

                           while ($row = mysqli_fetch_assoc($result)){ ?>

                               <tr>
                                   <td data-id="<?php echo $row['id']; ?>" hidden><?php echo $row['id']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"><?php echo $row['task_name']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"><?php echo $row['task_detail']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"><?php echo $row['task_status']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"><?php echo $row['task_due']; ?></td>
                                   <td ><i class="fas fa-edit btnedit" data-id="<?php echo $row['id']; ?>"></i></td>
                               </tr>

                   <?php
                           }

                       }
                   }


                   ?>
                </tbody>
            </table>
        </div>


    </div>
</main>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="main.js"></script>
<script>
  $(function() {
    $('#toggle-one').bootstrapToggle();
  })
</script>
</body>
</html>
