<?php
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=mglsi_news;charset=utf8', 'root','');
  $bdd->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $profil =htmlspecialchars($_POST['profil']);
  if (isset($_POST['ajouter']))
  {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $pass = sha1($_POST['pass']);
    $email = htmlspecialchars($_POST['email']);
    $profil =htmlspecialchars($_POST['profil']);
    if(!empty($_POST['pseudo']) AND !empty($_POST['pass']) AND !empty($_POST['email'])  AND !empty($_POST['profil'])  )
    {
      $userlength=strlen($pseudo);
      if ($userlength<=255) 
      {
        $requser = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
        $requser->execute(array($pseudo));
        $userexist = $requser->rowCount();
        if($userexist ==0)
        {
          
              $insertmbr = $bdd->prepare("INSERT INTO users(
                pseudo,pass,email,profil) VALUES(?,?,?,?)");
              if ( $insertmbr->execute(array($pseudo,$pass,$email,$profil))) 
              {
                echo 'ajout effectué avec succès !';
                //header('Location: ajouequipe.php');
                echo '<meta http-equiv="refresh" content="0;URL=admin_user.php">';
              }
              else
              {
              echo "Erreur ";
              }
           }
          
        }  
        else
        {
          $erreur="mail déjà utilisée";
        }
      }
      else
      {
        $erreur="Votre pseudo ne doit pas dépasser 255";
      }
    }
   else
    {
     $erreur = "Tous les champs doit etre completé ! ";
    }
  

  ?>

            <?php
                if (isset($erreur)) echo '<br />',$erreur;   
            ?>
           