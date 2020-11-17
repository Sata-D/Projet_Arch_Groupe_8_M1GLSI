<?php
include("config.ini");
$link=mysqli_connect(HOST,USER,PASSWORD,DB);

if (isset($_POST['id']))
{
  $id=$_POST['id'];
} 
else 
{
  $id = null;
}

if (isset($_POST['pseudo']))
{
  $pseudo=$_POST['pseudo'];
} 
else 
{
  $pseudo = null;
}
   
if (isset($_POST['pass']))
{
  $pass=sha1($_POST['pass']);
} 
else 
{
  $pass = null;
}    

if (isset($_POST['email']))
{
  $email=$_POST['email'];
} 
else 
{
  $email = null;
}

if (isset($_POST['profil']))
{
  $profil=$_POST['profil'];
} 
else 
{
  $profil = null;
}




if (isset($_POST['modifier']))
         {
          $query="UPDATE users SET pseudo='$pseudo', pass='$pass', email='$email', profil='$profil' WHERE users.id='$id';";
           
          mysqli_query($link, $query) or die("Could not connect: ".mysqli_error($link));
           
          echo '<body onLoad="alert("Mise à jour effectuée...")">';
          echo '<meta http-equiv="refresh" content="0;URL=admin_user.php">';
          mysqli_close($link);
         }
?>