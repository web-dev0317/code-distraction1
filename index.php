<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMD</title>
    <script src="https://kit.fontawesome.com/d0d39b9bb5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        body{
            background-color: black;
            color: white;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        span.head{
            padding-left: 5px;
            font-size: 50px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        div.disp{
            background-color: rgb(55,46,46);
            border: 1px solid rgb(55,46,46);
            border-radius: 12px;
            margin: 10px;
            padding: 5px;
        }
        span.colorHead{
            color: rgb(243,203,118);
        }
        span.ts{
            color: rgb(243,203,118);
        }
        div.norevdisp{
            color: rgb(243,203,118);
            text-align: center;
            background-color: rgb(55,46,46);
            border: 1px solid rgb(55,46,46);
            border-radius: 12px;
            margin: 10px;
            padding: 5px;
        }
        span.icon1{
            position: absolute;
            right: 100px;
            top: 50px;
            padding: 5px;
        }
        span.icon2{
            position: absolute;
            right: 50px;
            top: 50px;
            padding: 5px;
        }
        span.icon3{
            position: absolute;
            right: 0;
            top: 50px;
            padding: 5px;
        }
        #ta{
            background-color: rgb(55,46,46);
            border: 1px solid rgb(55,46,46);
            border-radius: 12px;
            margin: 10px;
            padding: 5px;

        }
        #overlay{
            text-align: center;
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.8);
            z-index: 2;

        }
        table{
            margin-left: auto;
            margin-right: auto;
        }
        .button{
            background-color: black;
            border: none;
            cursor: pointer;
        }
        #form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
    </style>
</head>
<body>
    <div style="position:sticky;top:0;background-color:black;">
        <span style="color: white;">
            <i class="fas fa-film fa-5x"></i>
        </span>
        <span class="head">DMD</span>
        <span id="ui-widget">
            <input type="text" id="suggestions" name="search" style="position:absolute;right:150px;top:50px;height:28px;width:200px" placeholder="Search Show/Movie...">
        </span>
        <span class="icon1"><button type="submit" class="button" onclick="searchShow()"><i class="fas fa-search fa-2x" style="color:white"></i></button></span>

        <span class="icon2"><button type="button" onclick="dispFunc()" class="button"><i class="fas fa-pencil-alt fa-2x" style="color:white"></i></button></span>

        <span class="icon3"><button type="button" onclick="homePage()" class="button"><i class="fas fa-igloo fa-2x" style="color:white"></i></button></span><hr>

    </div>


    <?php

       $servername="localhost";
       $username="root";
       $password="";
       $database="dmd";
       $reviewArray=array();
       $q="";
       if(!empty($_REQUEST["q"]))
        $q=$_REQUEST["q"];

       $conn=new mysqli($servername,$username,$password,$database);

       if($conn->connect_error){
           die("CONNECTION FAILED: ".$conn->connect_error);
       }
       $sql="SELECT Name, Review, Show_Movie, Time, Rating FROM dmd_table ";

       if($q!=""){
           $sql.=" WHERE Show_Movie LIKE '%".$q."%'";
        //    $sql."WHERE Show_Movie LIKE '%incep%'";
            $q="";
       }
       $sql.="order by Time desc";
       $result=$conn->query($sql);
       if($result->num_rows > 0){
           while($row=$result->fetch_assoc()){
               echo "<div class='disp'>";
               echo "<span class='colorHead'>SHOW: </span>".$row['Show_Movie']."<br>";
               echo "<span class='colorHead'>RATING: </span>".$row['Rating']."<br>";
               echo "<span class='colorHead'>REVIEW BY: </span>".$row['Name']."<br><br>";
               echo $row['Review']."<br><br>";
               echo "<span class='ts'>".$row['Time']."</span>";
               echo "</div>";

            }
       }
       else{
        echo "<div class='norevdisp'><p>NO REVIEWS</p></div>";
       }
       $sql2="SELECT Show_Movie FROM dmd_table";
       $result=$conn->query($sql2);
       if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                array_push($reviewArray,$row['Show_Movie']);
            }
        }
    ?>

    <div id="overlay">
       <form action="submit.php" method="post" enctype="multipart/form-data" id="form" autocomplete="off">
            <table>
                <tr>
                    <td>Your name: </td>
                    <td><input type="text" name="contributor" required></td>
                </tr>
                <tr>
                    <td>Show/Movie: </td>
                    <td><input type="text" name="show_movie" required></td>
                </tr>
                <tr>
                    <td>Rating out of 5: </td>
                    <td><input type="text" name="rating" required></td>
                </tr>
            </table>
            <textarea id="ta" rows="5" cols="50" style="color:white" placeholder="Enter your review here..." name="review" required></textarea>
            <br>
            <input type="submit" name="submit" value="SUBMIT" style="display:inline-block;background-color:blue;color:white;border:0;font-family:'Times New Roman';height:30px;margin-right:5px;">
            <button type="button" onclick="hideFunc()" style="display:inline-block;background-color:blue;color:white;border:0;font-family:'Times New Roman';height:30px;margin-left:5px;">CANCEL</button>
       </form>

    </div>
    <!-- <p id="txtHint"></p> -->

    <script>
        var revArr=[<?php  $sql="SELECT Show_Movie FROM dmd_table";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0){
                        while($row=$result->fetch_assoc()){
                            $element=$row['Show_Movie'];
                            echo "'$element',";
                        }
                    } $conn->close(); ?>];

        function dispFunc(){
           document.getElementById("overlay").style.display = "block";
        }
        function hideFunc(){
           document.getElementById("overlay").style.display = "none";
        }
        function searchShow(){
            var str = document.getElementById("suggestions").value;
            // var xhttp = new XMLHttpRequest();
            // xhttp.onreadystatechange = function(){
            // if(this.readyState == 4 && this.status == 200){
            //     document.getElementById("txtHint").innerHTML = this.responseText;
            //     document.getElementById("txtHint").innerHTML = this.responseText;
            //     }
            // };
            // xhttp.open("GET", "index.php?q="+str, true);
            // xttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            // xhttp.send();
            window.location.replace("index.php?q="+str);
        }
        function homePage(){
            window.location.replace("index.php");
        }

        $(function(){
            $("#suggestions").autocomplete({
                source: revArr
            });
        });

    </script>
</body>
</html>
