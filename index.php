<?php

$host = "localhost";
$user = "root";
$pass  = "";
$request = $_SERVER['REQUEST_METHOD'];
$self  = $_SERVER['PHP_SELF'];
$done = false;

$db = mysql_connect($host , $user , $pass);
if(!$db)
{
    die("Did not connect");


}
$db_selected = mysql_select_db("shopping_cart", $db);
if(isset($_POST['e_submit']) && !empty($_POST['e_id']) || isset($_POST['e_name']))
{
    echo"yes i got here";
    $id = $_POST['e_id'];
    echo $id;
    $name = "".$_POST['e_name']."";
    echo $name;
    $desc = "".$_POST['e_desc']."";
    echo $desc;
    $class = "".$_POST['e_category']."";
    echo $class;
    $query = "update product_table set product_name = '$name', product_description = '$desc', Category = '$class' where product_id = '$id'";
    echo $query;
    $false = mysql_query($query);
    if($false == false)
    {
        echo"update un successful";
    }
    unset($id);
    unset($name);
    unset($desc);
    unset($class);
    unset($query);





}

if(isset($_POST['delete_this'])) // i should put this in its own page -> trying to solve
{
    $id = $_POST['delete_this'];// need to leave more comments.. will comment later.. this Is DB ID for product wanting to delete I will then delete that product and(while) reloading the page.
    $del_query = "delete from product_table where product_id = '$id'";
    $del_result = mysql_query($del_query);
    if($del_result != FALSE)
    {
        echo"You have successfully deleted the item";
    }
    else{
        echo"Something went wrong here: Item not deleted";

    }
}



if(isset($_POST['submit_one']))
{
    if(!empty($_POST['new_prod_name']) && isset($_POST['new_prod_name']))
    {
     $new_name = $_POST['new_prod_name'];
     $new_desc = $_POST['area_'];

     $new_price = $_POST['prod_price'];
     $class = $_POST['prod_class'];
     $insert_new = "insert into product_table ( product_name , product_description ,product_price, Category) values('$new_name', '$new_desc' , '$new_price' , '$class' )";

     $result = mysql_query($insert_new);
    }
    else{
        echo "Post is not set!";
    }



$done = true;
}
if(isset($_POST['submit_two']))
{




}




?>
<html>
<head>
    <style>
         body{
             background-color:#999999;
         }
        #prod_container{
            border:1px solid #000000;
            float:right;
            width:600px;
            height:800px;
            background-color:#cccccc;
            color:#ffffff;
            overflow: scroll;
            margin-top:65px;

        }
        #prod_table{
            border:2px solid #ffffff;
            width:100%;
            height:200px;
        }
        #prod_head
        {
            #color:#ffffff;
            position: absolute;
            left:900px;
            top:2px;
            text-shadow:3px 3px 3px #000000;
            text-shadow:3px 2px -2px rgb(0,0,5);
        }
        .func_sec{
            width:660px;
            background-color:hsl(0,0%,90%);
            margin-top:60px;
            position:absolute;
            top:50px;
            left:20px;
            border:2px solid #676767;
            border-radius:3px;
            padding:20px;

        }
        #functions{
            width:700px;
            background-color:#e3e3e3;
            border:1px solid #676767;
            height:50px;
            position: absolute;
            top:55px;
            left:20px;

        }
        #functions ul{
            list-style-type: none;
        }
        #functions ul li {
            float: left;
            font-size:18px;
            margin-right:10px;

        }
        #functions ul li:hover{
            text-shadow:1px 1px 1px #0066FF;
            cursor:pointer;

        }
        #close_e_click:hover{cursor: pointer;}


    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
           $('.func_sec#edit_class').hide();
            $('.func_sec#add_class').hide();
        });
    function edit_button()
    {
        $('.func_sec#default').fadeOut("fast");
        $('.func_sec#edit_class').fadeIn("slow");
        $('.func_sec#add_class').fadeOut("fast");
    }
    function add_button()
    {

        $('.func_sec#default').fadeIn("slow");
        $('.func_sec#edit_class').fadeOut("fast");
        $('.func_sec#add_class').fadeOut("fast");
    }
    function class_button()
    {
        $('.func_sec#default').fadeOut("fast");
        $('.func_sec#edit_class').fadeOut("fast");
        $('.func_sec#add_class').fadeIn("slow");
    }
    function fill_edit(id)
    {
        $.ajax({ url: 'edit.php',
            data: { prod_id: id},
            type: 'post',
            success: function(output) {
                var html = output;
                $('#edit_prod').html(html);

            }
        });
    }
function ask_delete(prod_id)
        {
            var $info = prod_id.split(':');
            var $id = $info[0];
            var $name = $info[1];

            $('#ask_delete').css('display' , 'inline');
            $('#ask_delete').attr('name' , $id);

        }
       function close_e(){

            $('#click_e').css('display' , 'none');

        }
        function p_del(){

           var id =  $('#ask_delete').attr("name");

            $.ajax({
                url: 'index.php',
                data: { delete_this: id},
                type: 'post',
                success: function(output) {
                    alert("To see the deletion refresh the page.");
                }




            });
        }


    </script>
</head>
<body>
<div name="" id="ask_delete" style="display: none; width: 460px; height:80px; background-color: #eeeeee; border:1px solid #ffffff; color:#000000; border-radius:3px; box-shadow:3px 2px 2px #676767; position: fixed; top:200px; left:800px; 6px">
    <div><b>Would you like to delete this because once you do you can never go back.</b></div>
    <div><div style="height:15px; border:1px solid #000000; margin: 5px; padding:3px; float: left;"><a href="#" id="yes_del" onclick = "close_del()" name="">no</a></div><div style=" float:left; height:15px; border:1px solid #000000; margin: 5px; padding:3px;"><a href="#" id="no_del" name = "" onclick = "p_del()">Yes</a></div></div>
</div>
<div id = "admin_sec"></div><!-- END admin sec -->
<?php
echo"<h1 id = \"prod_head\" style='color:#ffffff;'>Current Products</h1>";

echo "<div id = \"prod_container\"     style = \"\">";
$query = "select * from product_table";
$result = mysql_query($query);
$row_num = mysql_num_rows($result);

    if($row_num > 0)
    {
        while($row = mysql_fetch_assoc($result))
        {
        $prod_name = "".$row['product_name']."";
        $prod_id = $row['product_id'];
        $prod_desc = "".$row['product_description']."";
        $prod_price = $row['product_price'];
        $img_dir   = "".$row['image_url']."";
        $cat = "".$row['Category']."";


        echo"<table id = \"prod_table\">";
        echo "<tr>";
        echo"<tr style='float: left;'><th>Category:$cat</th></tr>";
        echo"<th>$prod_name</th><td style='width:100px;'>Delete Item:<input type='checkbox' name = \"$prod_id:$prod_name\" onchange='ask_delete(this.name)' /></td>";
        echo"</tr>";
        echo"<tr>";
        echo"<td><img src = \"Jellyfish.jpg\"  height='50' width = '100'/><p>$prod_desc</p></td></tr>";
        echo"<tr><td>$prod_price</td></tr>";
        echo"</table>";
        }
        echo"</div>";


    }
    else{
        echo"No items to display..";
    }
?>
<!--this is the end of the right side of the page so letss move on------------------------------------------------------------->

<div id = "functions">
    <ul>
        <li onclick = "add_button()">Add a Product</li>
        <li onclick="edit_button()">Edit a Product</li>
        <li onclick = "class_button()">Add Class</li>
        <li></li>
    </ul>
</div><!-- end functions -->
<div class = "func_sec" id="default" style="">
    <div>
        <fieldset>
            <legend>Bringing your product to life:</legend>
            <form method="post" action="index.php">
    New Product Name:<br><input type="text" name="new_prod_name"  /><br>
    New Product Description:<br><textarea name="area_"></textarea><br>
    New Product Price:<br><input type="text" name="prod_price" /><br>
    New Product class:<br><input type="text" name="prod_class"   /><br>
        <input type="submit" value="create" name="submit_one">
        </form>
        </fieldset>
    </div>
</div>
<div class="func_sec" id="edit_class" style="">
    <form method="post" action="index.php">

    <div style="height:350px; overflow-y: scroll; border: inset; background-color:#898989;">
 <?php
    $query_edit = "select * from product_table";
    $result = mysql_query($query_edit);
    $row_num = mysql_num_rows($result);

    if($row_num > 0)
    {
    while($row = mysql_fetch_assoc($result))
    {
    $prod_name = "".$row['product_name']."";
    $prod_id = $row['product_id'];
    $prod_desc = "".$row['product_description']."";
    $prod_price = $row['product_price'];
    $img_dir   = "".$row['image_url']."";
    $cat = "".$row['Category']."";

    echo"<table id = \"edit_table\" style='border:2px solid #000000;'>";
        echo"<div style='width: 200px; background-color: #000000; margin-top:10px;'>";
        echo"<a href = '#' onclick = 'fill_edit(this.name)' name='$prod_id'  style='color:#ffffff; font-size:20px; margin-left: 20%; text-decoration: none; , '>$prod_name</a>";
        echo"</div>";
            echo"</table>";
    }
        echo"</div>";
       echo"</form>";
    echo"</div>";


}
else{
echo"No items to display..";
}
?>

</div>
<div id="edit_prod"></div>
<div class="func_sec" id="add_class">
    <p>This is where you can add a category to the product page on the shopping cart <br>
    these will be the head nav bar.
    </p>
    <form method="post" action="index.php">
    Class Name: <input type="text" name="class_a">
    <br>
    <input type="submit" value="Add Class" />
    </form>
        <div>


        <h1>Categories:</h1>
        <div style="overflow-y: scroll; height:200px; width: 300px; background-color:#ffffff">
        <?php
        $query = "select * from product_table";
        $result = mysql_query($query);

        while($row=mysql_fetch_assoc($result))
        {
            $cat = "".$row['Category']."";
            echo"<div style='color:#eeeeee; padding:10px; width:80px; border:2px solid #676767; border-radius:2px; margin-top:3px; background-color: #676767;'>$cat</div>";
        }

        ?>
        </div>




    </div>

</div><!-- END add_class -->







</body>




</html>
