<?php
/**
 * Classe représentant une news, créée à l'occasion d'un TP du tutoriel « La programmation orientée objet en PHP » disponible sur http://www.openclassrooms.com/
 * @author Victor T.
 * @version 2.0
 */
class News
{
  protected $erreurs = [],
            $id,
            $titre,
            $contenu,
            $dateCreation,
            $dateModif,
            $categorie;
  
  /**
   * Constantes relatives aux erreurs possibles rencontrées lors de l'exécution de la méthode.
   */
  const AUTEUR_INVALIDE = 1;
  const TITRE_INVALIDE = 2;
  const CONTENU_INVALIDE = 3;
  
  
  /**
   * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
   * @param $valeurs array Les valeurs à assigner
   * @return void
   */
  public function __construct($valeurs = [])
  {
    if (!empty($valeurs)) // Si on a spécifié des valeurs, alors on hydrate l'objet.
    {
      $this->hydrate($valeurs);
    }
  }
  
  /**
   * Méthode assignant les valeurs spécifiées aux attributs correspondant.
   * @param $donnees array Les données à assigner
   * @return void
   */
  public function hydrate($donnees)
  {
    foreach ($donnees as $attribut => $valeur)
    {
      $methode = 'set'.ucfirst($attribut);
      
      if (is_callable([$this, $methode]))
      {
        $this->$methode($valeur);
      }
    }
  }
  
  /**
   * Méthode permettant de savoir si la news est nouvelle.
   * @return bool
   */
  public function isNew()
  {
    return empty($this->id);
  }
  
  /**
   * Méthode permettant de savoir si la news est valide.
   * @return bool
   */
  public function isValid()
  {
    return !(empty($this->titre) || empty($this->contenu) || empty($this->categorie));
  }
  
  
  // SETTERS //
  
  public function setId($id)
  {
    $this->id = (int) $id;
  }

  
  public function setTitre($titre)
  {
    if (!is_string($titre) || empty($titre))
    {
      $this->erreurs[] = self::TITRE_INVALIDE;
    }
    else
    {
      $this->titre = $titre;
    }
  }
  
  public function setContenu($contenu)
  {
    if (!is_string($contenu) || empty($contenu))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }
    else
    {
      $this->contenu = $contenu;
    }
  }
  
  public function setDateCreation(DateTime $dateCreation)
  {
    $this->dateCreation = $dateCreation;
  }
  
  public function setDateModification(DateTime $dateModification)
  {
    $this->dateModification = $dateModification;
  }

  public function setCategorie($categorie)
  {
    if (!is_string($categorie) || empty($categorie))
    {
      $this->erreurs[] = self::CATEGORIE_INVALIDE;
    }
    else
    {
      $this->categorie = $categorie;
    }
  }
  
  // GETTERS //
  
  public function erreurs()
  {
    return $this->erreurs;
  }
  
  public function id()
  {
    return $this->id;
  }
  
  public function titre()
  {
    return $this->titre;
  }
  
  public function contenu()
  {
    return $this->contenu;
  }
  
  public function dateCreation()
  {
    return $this->dateCreation;
  }
  
  public function dateModification()
  {
    return $this->dateModification;
  }

  public function categorie()
  {
    return $this->categorie;
  }
}
?>