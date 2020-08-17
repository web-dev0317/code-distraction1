<?php
    $name=test($_POST["contributor"]);
    $show_movie=test($_POST["show_movie"]);
    $rating=test($_POST["rating"]);
    $review=test($_POST["review"]);

    function test($data){
        $data=trim($data);
        $data=addslashes($data);
        $data=htmlspecialchars($data);
        return $data;

    }

    $servername="localhost";
    $username="root";
    $password="";
    $database="dmd";

    
    $conn=new mysqli($servername,$username,$password,$database);

    if($conn->connect_error){
        die("CONNECTION FAILED: ".$conn->connect_error);
    }
    
    $sql="INSERT INTO dmd_table(Name, Review, Show_Movie, Rating) VALUES('$name','$review','$show_movie',$rating)";
    
    if($conn->query($sql) === TRUE){
       header('Location: http://localhost/revproj/index.php');
    }
    else{
        echo "SYNTAX ERROR";
    }
?>