<?php
  require 'lib/autoload.php';

  $db = DBFactory::getMysqlConnexionWithPDO();
  $manager = new NewsManagerPDO($db);

  if (isset($_GET['modifier']))
  {
    $news = $manager->getUnique((int) $_GET['modifier']);
  }

  if (isset($_GET['supprimer']))
  {
    $manager->delete((int) $_GET['supprimer']);
    $message = 'La news a bien été supprimée !';
  }

      
  ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Administration</title>
      <meta charset="utf-8" />
      <link rel="stylesheet" type="text/css" href="style/style.css">
      <style type="text/css">
        body{
          
        }
        table, td {
          border: 1px solid black;
        }
        
        table {
          margin:auto;
          text-align: center;
          border-collapse: collapse;
        }
        
        td {
          padding: 3px;
        }
      </style>
    </head>
    
    <body>
      <p><a href=".">Accéder à l'accueil du site</a></p>
      
      <form action="editeur.php" method="post">
        <p style="text-align: center">
  <?php
  if (isset($message))
  {
    echo $message, '<br />';
  }
  ?>
          <?php if (isset($erreurs) && in_array(News::TITRE_INVALIDE, $erreurs)) echo 'L\'titre est invalide.<br />'; ?>
          titre : <input type="text" name="titre" value="<?php if (isset($news)) echo $news->titre(); ?>" /><br />
          
          <?php if (isset($erreurs) && in_array(News::CATEGORIE_INVALIDE, $erreurs)) echo 'la categorie est invalide.<br />'; ?>
          Categorie : <input type="text" name="categorie" value="<?php if (isset($news)) echo $news->categorie(); ?>" /><br />
          
          <?php if (isset($erreurs) && in_array(News::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
          CONTENU :<br /><textarea rows="8" cols="60" name="Categorie"><?php if (isset($news)) echo $news->contenu(); ?></textarea><br />
  <?php
  if(isset($news) && !$news->isNew())
  {
  ?>
          <input type="hidden" name="id" value="<?= $news->id() ?>" />
          <input type="submit" value="Modifier" name="modifier" />
  <?php
  }
  else
  {
  ?>
          <input type="submit" value="Ajouter" />
  <?php
  }
  ?>
        </p>
      </form>
      
      <p style="text-align: center">Il y a actuellement <?= $manager->count() ?> news. En voici la liste :</p>
      
      <table>
       <th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
  <?php
  foreach ($manager->getList() as $news)
  {
    echo '<tr><td>', $news->titre(), '</td><td>', $news->dateCreation()->format('d/m/Y à H\hi'), '</td><td>', ($news->dateCreation() == $news->dateModification() ? '-' : $news->dateModification()->format('d/m/Y à H\hi')), '</td><td><a href="?modifier=', $news->id(), '">Modifier</a> | <a href="?supprimer=', $news->id(), '">Supprimer</a></td></tr>', "\n";
  }
?>
    </table>
  </body>
</html>