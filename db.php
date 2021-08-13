<?php
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    
    $con = mysqli_connect("localhost","root","");
    // Check connection
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql = "CREATE DATABASE IF NOT EXISTS ToDoApp";
    if(mysqli_query($con, $sql)){
        $con = mysqli_connect("localhost", "root", "", "ToDoApp");
//users table
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT ,
            username varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            password varchar(50) NOT NULL,
            create_datetime datetime NOT NULL,
            PRIMARY KEY(id)
           );
           ";
        
        if(!mysqli_query($con, $sql)){
            echo "Cannot Create table...!";
        }

    }else{
        echo "Error while creating database ". mysqli_error($con);
    }


    if(mysqli_query($con, $sql)){
        $con = mysqli_connect("localhost", "root", "", "ToDoApp");
        //Professional table
        $sql = "
        CREATE TABLE IF NOT EXISTS professional(
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            task_name VARCHAR (25) NOT NULL,
            task_detail VARCHAR (20),
            task_status VARCHAR (20),
            task_due DATE,
            user VARCHAR (20)
        );
           ";
        
        if(!mysqli_query($con, $sql))
        {
            echo "Cannot Create table...!";
        }

    }else{
        echo "Error while creating database ". mysqli_error($con);
    }

    if(mysqli_query($con, $sql)){
        $con = mysqli_connect("localhost", "root", "", "ToDoApp");
        // Personal table
        $sql = "
        CREATE TABLE IF NOT EXISTS personal(
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            task_name VARCHAR (25) NOT NULL,
            task_detail VARCHAR (20),
            task_status VARCHAR (20),
            task_due DATE,
            user VARCHAR (20)
        );
           ";
        
        if(!mysqli_query($con, $sql))
        {
            echo "Cannot Create table...!";
        }

    }else{
        echo "Error while creating database ". mysqli_error($con);
    }
?> 
