             <?php // Connecting, selecting database
                session_start();  
                if (!isset($_SESSION['pseudo'])) { 
                   header ('Location: index.php'); 
                   exit();  
                }
                include("config.ini");
                $link = mysqli_connect(HOST,USER,PASSWORD,DB);
                $query = 'SELECT * FROM users WHERE users.id='.$_GET['id'];
                $result= mysqli_query($link, $query)                
                or die("Could not connect: ".mysqli_error($link));  
              ?>
              
<!DOCTYPE html>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html lang="fr-FR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" conttent="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <header>
            <h1>actualité</h1>
        </header>
        <div align="right">Utilisateur connecté :....<font color="#FF0000"><b><?php echo htmlentities(trim($_SESSION['pseudo'])); ?></b></font>....<a href="deconnexion.php">Déconnexion</a></div>
        <nav>
            <div class="table">
                <ul>
                    <li class="menu-ind">
                        <a href="accueil_admin.php">Accueil</a>
                    </li>
                    <li class="menu-osn">
                        <a href="articles.php">Les articles</a>
                    </li>
                    <li class="menu-ogb">
                        <a href="admin_user.php">GESTION DES UTILISATEURS</a>
                    </li>
                </ul>
            </div>    
        </nav>
        <section class="rouge">
            <div class="sec"><br></div>
            
           
            <h3>modifier utilisateur - Modifier user</h3>
            <div class="rouge">
            <br>
            <?php
                $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
              
             ?>
            <form id="form1" name="form1" method="post" action="script_modifier_user.php">
            <span class="redstar">
                <label>IdUtilisateur<span class="redstar">*</span>
                <input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" readonly="readonly" />
            </span>
            <br><br>
            <span class="redstar">
                <label>pseudo<span class="redstar">*</span>
                <input type="text" name="pseudo" id="pseudo" value="<?php echo $row['pseudo']; ?>" />
            </span>
            <br><br>
            <span class="redstar">
          
                <label for="pass">Passeword<span class="redstar">*</span>
                <input type="password" name="pass" id="pass" value="<?php  echo $row ['pass'];?>" required/>
            </span>
            
            <br><br>
            <span class="redstar">
                <label for="email">Email<span class="redstar">*</span>
                <input type="email" name="email" id="email" value="<?php echo $row ['email']; ?>" required/>
            </span>
            
            <br><br>
            <span class="redstar">
                <label for="profil">profil<span class="redstar">*</span>
                <SELECT name="profil" size="1">
                    <OPTION selected><?php echo $row['profil']; ?>
                    <OPTION>visiteur
                    <OPTION>editeur
                    <OPTION>administrateur
                </SELECT>
            </span>
            <br><br>
            <input name="Annuler" type="reset" id="annuler" value="Annuler" />
            <input name="modifier" type="submit" id="modifier" value="Modifier" />
          </form>
          </div>
          <br>
          <a href="admin_user.php">[Retour]</a>
            <!--</div> -->
        </section>
        
        <footer>
            <p>Copyright 2020 fatimalo-sata-adja - Toute reproduction interdite</p>
        </footer>
    </body>
</html> 