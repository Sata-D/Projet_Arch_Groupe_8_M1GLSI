<?php
session_start();  
if (!isset($_SESSION['pseudo'])) { 
   header ('Location: index.php'); 
   exit();  
}
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
            <h1>Utilisateur</h1>
        </header>
        <div align="right">Utilisateur connecté :....<font color="#FF0000"><b><?php echo htmlentities(trim($_SESSION['pseudo'])); ?></b></font>....<a href="deconnexion.php">Déconnexion</a></div>
        </div>
        <section class="rouge">
            <div class="sec"><br></div>
            <h3>LES UTILISATEURS DE L'APPLICATION</h3>
            <div class="rouge">
            <br>
            <form id="form1" name="form1" method="post" action="admin_user.php">
              <label><input name="rechercher" type="submit" id="rechercher" value="Rechercher" autocomplete="off"/></label>
              <label><input name="t_pseudo" type="text" id="t_pseudo" /><span>&nbsp;Recherche par utilisateur<br><br></span></label>
            </form>
            </div>
            <div align="center">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">gestion des utilisateurs:</th>
                            <th scope="col" colspan="10">LES UTILISATEURS AJOUTES</th>
                        </tr>
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Pass</th>
                            <th scope="col">Email</th>
                            <th scope="col">Profil</th>
                            <th scope="col" colspan="3">Actions</th>
                        </tr>
                    </thead>
                    </tfoot>
                <tbody>
                    <?php // Connecting, selecting database
                    //session_start();
                    //phpinfo();
                        include("config.ini");
                        $link = mysqli_connect(HOST,USER,PASSWORD,DB);
                        if (isset($_POST['rechercher']))
                        {
                          $rech=$_POST['rechercher'];
                        } 
                        else 
                        {
                          $rech = null;
                        }
                        
                        if (isset($_POST['t_pseudo']))
                        {
                          $pseudo=$_POST['t_pseudo'];
                        } 
                        else 
                        {
                          $pseudo = null;
                        }
                        if (isset($_POST['rechercher']))
                        {      
                            $query = 'SELECT * FROM users where pseudo like "%'.$pseudo.'%"';
                            $result= mysqli_query($link, $query)                
                            or die("Could not connect: ".mysqli_error($link));
                            
                            //Gestion de la pagination avec la recherche
                            $messagesParPage=5; //Nous allons afficher 5 messages par page.
 
                            //Une connexion SQL doit être ouverte avant cette ligne...
                            $retour_total=mysqli_query($link, 'SELECT COUNT(*) AS total FROM users WHERE pseudo like "%'.$pseudo.'%"'); //Nous récupérons le contenu de la requête dans $retour_total
                            $donnees_total=mysqli_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
                            $total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
                             
                            //Nous allons maintenant compter le nombre de pages.
                            $nombreDePages=ceil($total/$messagesParPage);
                             
                            if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
                            {
                                 $pageActuelle=intval($_GET['page']);
                             
                                 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
                                 {
                                      $pageActuelle=$nombreDePages;
                                 }
                            }
                            else // Sinon
                            {
                                 $pageActuelle=1; // La page actuelle est la n°1    
                            }
                            $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
 
                            // La requête sql pour récupérer les messages de la page actuelle.
                            $retour_messages=mysqli_query($link, 'SELECT * FROM users WHERE pseudo like "%'.$pseudo.'%" ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
                            
                            // Fin gestion pagination avec la recherche
                        }
                        else
                        {
                            $query = 'SELECT * FROM users';
                            $result= mysqli_query($link, $query)                
                            or die("Could not connect: ".mysqli_error($link));
                            //Gestion de la pagination sans la recherche
                            $messagesParPage=5; //Nous allons afficher 5 messages par page.
 
                            //Une connexion SQL doit être ouverte avant cette ligne...
                            $retour_total=mysqli_query($link, 'SELECT COUNT(*) AS total FROM users'); //Nous récupérons le contenu de la requête dans $retour_total
                            $donnees_total=mysqli_fetch_assoc($retour_total); //On range retour sous la forme d'un tableau.
                            $total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
                             
                            //Nous allons maintenant compter le nombre de pages.
                            $nombreDePages=ceil($total/$messagesParPage);
                             
                            if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
                            {
                                 $pageActuelle=intval($_GET['page']);
                             
                                 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
                                 {
                                      $pageActuelle=$nombreDePages;
                                 }
                            }
                            else // Sinon
                            {
                                 $pageActuelle=1; // La page actuelle est la n°1    
                            }
                            $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
 
                            // La requête sql pour récupérer les messages de la page actuelle.
                            $retour_messages=mysqli_query($link, 'SELECT * FROM users ORDER BY id  DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
                            
                            // Fin gestion pagination sans la recherche
                        }
                        //while($row=mysqli_fetch_array($result, MYSQL_ASSOC)){ le temps de tester la pagination
                        while($row=mysqli_fetch_assoc($retour_messages)) {
                    ?>
                    <tr>
                        <th scope="row"></th>
                        <td><?php echo $row['pseudo']; ?></td>
                        <td><?php echo $row['pass']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['profil']; ?></td>
                        <td><a href="ajouter_user_admin.php"><img src="image/ajout.png" alt="Ajouter" align="center"></a></td>
                        <td><a href="modifier_user.php?id=<?php echo $row['id']; ?>"><img src="image/modif.png" alt="Modifier" align="center"></a></td>
                        <td><a href="supprimer_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Vous confirmez la suppression cet utilisateur ?')"><img src="image/supp.png" alt="Supprimer" align="center"></a></td>
                    </tr>
                    <?php
                        }
                        ?>
                </tbody>
            </table>
                <?php
                echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
                for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                {
                     //On va faire notre condition
                     if($i==$pageActuelle) //S'il s'agit de la page actuelle...
                     {
                         echo ' [ '.$i.' ] '; 
                     }	
                     else //Sinon...
                     {
                          echo ' <a href="admin_user.php?page='.$i.'">'.$i.'</a> ';
                     }
                }
                echo '</p>';
                ?>
                
                <a href="admin_user_csv.php"><button type="button">Exporter xls</button></a>
            </div>
            <!--</div> -->
        </section>
          
        <!--<section class="orange">
            balalalalalal
        </section>-->
        <footer>
            <p>Copyright 2019 Fatima-sata-adja - Toute reproduction interdite</p>
        </footer>
         <script type="text/javascript">
    (function(){
    var rechercherElement = 
    document.getElementById('rechercher'),
    results = 
    document.getElementById('results'),
    selectedResult = -1,//permet de savoir quel résultat est selectionné : -1 signifie "aucune selection"

    previousRequest,//on stocke notre précédente requete dans cette variable

    previousValue = rechercherElement.value;//on fait de meme avec la précédente valeur 

    function getResults(keywords){ //effectue une requete et récupère les résultats

        var xhr = new XHLHttpRequest();

        xhr.open('GET','./admin_user.php?s='

            encodeURIComponent(keywords));

        xhr.addEventListener('readystatechange',

            function(){

                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200){
                    //le code une fois la requete treminée et réussi

                    displayResults(xhr.responseText);
                }
            });

        xhr.send(null);
        return xhr;
    }
    function displayResults(response){ //affiche les résultats d'une requete
        results.style.display = response.length?
        'block' : 'none'; //on cache le conteneur si on n'a pas de résultats 

        if (response.length){ //on ne modifie les résultats que si on en a obtenu

            response = response.split('|');

            var responseLen = response.length;
            
            results.innerHTML = '';//on vide les résultats

            for(var i =0, div ; i < responseLen ; i++){

                div = results.appendChild(document.createElement('div'));

                div.innerHTML = response[i];

                div.addEventListener('click',

                    function(e){

                        chooseResult(e.target);

                    });
            }

        }
    }
    function chooseResult(result){ // choisi un des résultats d'une requete et gére tout ce qui y est attaché

    rechercherElement.value = previousValue = result.innerHTML; /*on change le contenu du champ de recherche et on enregistre
         en tant que précédente valeur */

        results.style.display = 'none'; //on cache les résultats

        result.className = ''; //on supprime

        selectedResult = -1; //on remet le selection à zéro

        rechercher.focus();/*si le résultat a été choisi par le biais d'un clique alors le focus est perdu,donc on le réattribue*/
    }

    rechercherElement.addEventListener('keyup',

        function(e){

            var divs = results.getElementsByTageName('div');

            if(e.keyCode == 38 && selectedResult > -1){ //si la touche est la flèche "haut"

                divs[selectedResult--].className = '';

                if (selectedResult > -1) { /* cette condition évite une modification de childNodes[-1]
                    qui n'existe pas ,bien attendu*/

                    divs[selectedResult].className = 'result_focus';

                }
            }

            else if (e.keyCode == 40 && selectedResult < divs.length -1) { //si la touche pressé est la flèche "bas"

                results.style.display = 'block'; // on affiche les résultats

                if(selectedResult > -1){/*cette condition évite une modification de childNodes[-1], qui n'existe pas,bien attendu*/

                    divs[selectedResult].className = '';
 
                }

                divs[++selectedResult].className = 'result_focus';

            }

            else if (e.keyCode == 13 && selectedResult >-1) { //si la touche est "Entrée"

                chooseResult(divs[selectedResult]);
            }

            else if (rechercherElement.value != previousValue) { //si le contenu du champ de recherche a changé

                previousValue = rechercherElement.value;

                if(previousRequest && previousRequest.readyState < XMLHttpRequest.DONE){

                    previousRequest.abort(); //si on a tjrs une requete en cours ,on l'arrete

                }

                previousRequest = getResults(previousValue); //on stocke la nouvelle requete 

                selectedResult = -1;//on remet la sélection à zéro caractère
            }
        });
})();
</script>
    </body>
</html>