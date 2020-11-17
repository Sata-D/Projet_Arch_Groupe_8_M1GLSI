<?php
	try
	{
		$bdd = new PDO( 'mysql:host=localhost;dbname = mglsi_news; charset = utf8','root', '');
	}
	catch(Exception $e)
	{
		echo "Erreur: ".$e->getMessage();
		$bdd = null;
	}
	if(isset(($_POST['titre']), ($_POST['contenu']),($_POST['categorie'])))
      {
          $titre = $_POST['titre'];
          $contenu = $_POST['contenu'];
          $categorie = $_POST['categorie'];
          $date = date('d-m-y');
          $ajout = $db-> prepare('INSERT INTO article(titre, contenu, dateCreation, dateModification, categorie) VALUES(:titre, :contenu, :dateCreation, :dateModification, :categorie)');
          $ajout-> execute(array(
          	'titre' => $titre,
          	'contenu' => $contenu,
          	'dateCreation' => $date,
          	'dateModification' => $date,
			'categorie' => $categorie
          ));
          
          echo "Bien";
      }
	
?>