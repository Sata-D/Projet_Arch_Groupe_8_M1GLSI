             <?php // Connecting, selecting database
                session_start();  
                if (!isset($_SESSION['pseudo'])) { 
                   header ('Location: index.php'); 
                   exit();  
                }
                include("config.ini");
                $link = mysqli_connect(HOST,USER,PASSWORD,DB);
                $query = 'SELECT * FROM users';
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
            <h1>actualités</h1>
        </header>
        <div align="right">Utilisateur connecté :....<font color="#FF0000"><b><?php echo htmlentities(trim($_SESSION['pseudo'])); ?></b></font>....<a href="deconnexion.php">Déconnexion</a></div>
        <nav>
            <div class="table">
                 <ul>
                    <li class="menu-ogb">
                        <a href="admin_user.php">GESTION DES UTILISATEURS</a>
                    </li>
                </ul>
            </div>    
        </nav>
        <section class="rouge">
            <div class="sec"><br></div>
            
          
            <h3>Ajouter un utilisateur - Gestion des utilisateurs</h3>
            <div class="rouge">
            <br>
            <form id="form1" name="form1" method="POST" action="admin_ajout_user.php" enctype="multipart/form-data">
            <span class="redstar">
                <label for="pseudo">pseudo<span class="redstar">*</span>
                <input type="text" name="pseudo" id="pseudo" required />
            </span>
            <br><br>
            <span class="redstar">
                <label for="pseudo">pass<span class="redstar">*</span>
                <input type="password" name="pass" id="pass" required/>
            </span>
            <br><br>
           
            <span class="redstar">
                <label for="pseudo">email<span class="redstar">*</span>
                <input type="email" name="email" id="email" required/>
            </span>
             <br><br>
            <span class="redstar">
                <label for="profil">Profil<span class="redstar">*</span>
                <SELECT name="profil" size="1">
                    <OPTION>editeur
                    <OPTION>visiteur
                    <OPTION>administrateur
                </SELECT>
            </span>
            <br><br>
            <input name="Annuler" type="reset" id="annuler" value="Annuler" />
            <input name="ajouter" type="submit" id="ajouter" value="Ajouter" />
          </form>
          </div>
          <br>
          <a href="admin_user.php">[Retour]</a>
            <!--</div> -->
        </section>
        <footer>
            <p>Copyright 2020 NdFatimalo-Sata-Adja - Toute reproduction interdite</p>
        </footer>
    </body>
</html>