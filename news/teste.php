<!DOCTYPE html>
<html>
<head>
     <?php
            $bdd = new PDO('mysql:host=localhost;dbname=mglsi_news;charset=utf8', 'root', '');
            // on teste si le visiteur a soumis le formulaire de connexion
            if (isset($_POST['connexion']) && $_POST['connexion'] == 'connexion') 
        { 
            $pseudo=htmlspecialchars($_POST["pseudo"]);
            $pass=sha1($_POST["pass"]);
            if (!empty($_POST['pseudo'])&& !empty($_POST['pass']))
             {
                    $requser = $bdd->prepare("SELECT * FROM users WHERE 
                        pseudo = ? AND pass = ? ");
                    $requser->execute(array($pseudo, $pass));
                    //var_dump($requser);
                    $userexist = $requser->rowCount();
                    var_dump($userexist);

                    $userinfo = $requser->fetch();
                    $profil =  $userinfo['profil'];
                    if($userexist == 1)
                    {
                        if ($profil=='visiteur')
                        {
                            session_start();
                            $_SESSION['id'] = $userinfo['id'];
                            $_SESSION['pseudo'] = $userinfo['pseudo'];
                            header("Location: visiteur.php?id=".$_SESSION['id']);
                        } 
                        else if ($profil=='administrateur')
                        {
                            session_start();
                            $_SESSION['id'] = $userinfo['id'];
                            $_SESSION['pseudo'] = $userinfo['pseudo'];
                            header("Location:admin_user.php?id=".$_SESSION['id']);
                        }
                       
                        else
                        {
                            session_start();
                            $_SESSION['id'] = $userinfo['id'];
                            $_SESSION['pseudo'] = $userinfo['pseudo'];
                            header("Location: editeur.php?id=".$_SESSION['id']);
                        }
                    }
                    else
                    {
                        $erreur = "mauvais pseudo ou mot de passe";
                    }
                }
             else
            {
                $erreur="Tous les champs doivent etre complétés";
            }
        }
            ?>
            <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>
    <body>
   <section >
            <div align="center">
            <table width="80%" id="menutab">
              <tr id="menutr">
                <td colspan="2" align="center"><span class="titre"><p>IDENTIFIER</p></span></td>
              </tr>
              <tr>
                <table id="menutab2" width="80%">
                    <tr>
                        <td colspan="2">
                        <div class="legend1" align="center">
                            <fieldset style="width:300px">
                                <legend><b>CONNEXION</b></legend>
                                    <form action="teste.php" method="post">
                                        <table>
                                            <tr><td align="left"><b>pseudo : </b></td><td><input type="text" name="pseudo" value="<?php if (isset($_POST['pseudo'])) echo htmlentities(trim($_POST['pseudo'])); ?>"/></td></tr>
                                            <tr><td align="left"><b>password : </b></td><td><input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass'])); ?>"/></td></tr>
                                            <tr><td colspan="2"><input type="submit" name="connexion" value="connexion"></label></td></tr>
                                             <tr><td align="left"><b></b></td><td><a href="#">Mot de passe oublié ?</a></td></tr>
                                        </table>
                                    </form>
                            </fieldset>
                            </div>
                        </td>
                    </tr>
                </table>
              </tr>
            </table>
            </div>
            </section>
  </section>
            <div align="center">
            <font color="#FF0000"><h4>
            <?php
                if (isset($erreur)) echo '<br />',$erreur;   
            ?>
            </h4></font>
            </div>
        </article>
        <footer>
            <p>Copyright 2020 Ndfatimata-sata-adja - Toute reproduction interdite</p>
        </footer>
</body>
</html>