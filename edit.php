<?php
$host = "localhost";
$user = "root";
$pass  = "";


$db = mysql_connect($host , $user , $pass);
if(!$db)
{
    die("you done fucked up");


}
$db_selected = mysql_select_db("shopping_cart", $db);

$id = $_POST['prod_id'];

if(isset($id))
{
    echo"$id";
    $query = "select * from product_table where product_id = '$id'";
    $result  =  mysql_query($query);
    $row_num = mysql_num_rows($result);
    if($row_num>0)
    {
       if($row=mysql_fetch_assoc($result))
        {
            $name = "".$row['product_name']."";
            $class = "".$row['Category']."";
            $desc = "".$row['product_description']."";
            $image = "".$row['image_url']."";
           echo"<div style='position: fixed; z-index: 22; background-color:#555555; color:#ffffff; text-shadow:1px 1px 1px #000000; height:300px; padding:20px; border:2px solid #ffffff; box-shadow:3px 3px 3px #000000; top:30px; left:400px; border-radius:3px;   ' id='click_e'>";
            echo"<div><a onclick = \"close_e()\" style = 'color:#ffffff; text-decoration: none; float:right;' id='close_e_click'>Close?</a></div>";
            echo"<form method='POST' action='index.php'>";
            echo"<b>Name:</b>";
            echo"<br/>";
            echo"<input type='text' value='$name' name='e_name'/>";
            echo"<br/>";
            echo"<input type='text' name='e_id' value='$id' style='display: none;' />";
            echo"<br/>";
            echo"<b>Product Description:</b>";
            echo"<br/>";
            echo"<textarea name='e_desc'>$desc</textarea>";
            echo"<br/>";
            echo"<br/>";
            echo"<b>Class:</b>";
            echo"<br/>";
            echo"<input type='text' name='e_category' value = '$class' />";
            echo"<input type='submit' name='e_submit' value = 'Final Decision' />";
            echo"</form>";
        }



    }
    else{
        echo"There is something Wrong with the id";
    }
}






unset($query);
unset($result);
unset($id);

?>