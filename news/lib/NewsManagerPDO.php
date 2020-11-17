<?php
class NewsManagerPDO extends NewsManager
{
  /**
   * Attribut contenant l'instance représentant la BDD.
   * @type PDO
   */
  protected $db;
  
  /**
   * Constructeur étant chargé d'enregistrer l'instance de PDO dans l'attribut $db.
   * @param $db PDO Le DAO
   * @return void
   */
  public function __construct(PDO $db)
  {
    $this->db = $db;
  }
  
  /**
   * @see NewsManager::add()
   */
  protected function add(News $news)
  {
    $requete = $this->db->prepare('INSERT INTO article(titre, contenu, dateCreation, dateModification) VALUES(:titre, :contenu,:categorie ,NOW(), NOW())');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':categorie', $news->categorie());
    
    $requete->execute();
  }
  
  /**
   * @see NewsManager::count()
   */
  public function count()
  {
    return $this->db->query('SELECT COUNT(*) FROM article')->fetchColumn();
  }
  
  /**
   * @see NewsManager::delete()
   */
  public function delete($id)
  {
    $this->db->exec('DELETE FROM article WHERE id = '.(int) $id);
  }
  
  /**
   * @see NewsManager::getList()
   */
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, titre, contenu, dateCreation, dateModification,categorie FROM article ORDER BY id DESC';
    
    // On vérifie l'intégrité des paramètres fournis.
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    
    $requete = $this->db->query($sql);
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'News');
    
    $listeNews = $requete->fetchAll();

    // On parcourt notre liste de news pour pouvoir placer des instances de DateTime en guise de dates d'ajout et de modification.
    foreach ($listeNews as $news)
    {
      $news->setDateCreation(new DateTime($news->dateCreation()));
      $news->setDateModification(new DateTime($news->dateModification()));
    }
    
    $requete->closeCursor();
    
    return $listeNews;
  }
  
  /**
   * @see NewsManager::getUnique()
   */
  public function getUnique($id)
  {
    $requete = $this->db->prepare('SELECT id, titre, contenu,dateCreation, dateModification, categorie FROM article WHERE id = :id');
    $requete->bindValue(':id', (int) $id, PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'News');

    $news = $requete->fetch();

    $news->setDateCreation(new DateTime($news->dateCreation()));
    $news->setDateModification(new DateTime($news->dateModification()));
    
    return $news;
  }
  
  /**
   * @see NewsManager::update()
   */
  protected function update(News $news)
  {
    $requete = $this->db->prepare('UPDATE article SET titre = :titre, contenu = :contenu, dateModification = NOW() , categorie = :categorie WHERE id = :id');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':categorie', $news->categorie());
    $requete->bindValue(':id', $news->id(), PDO::PARAM_INT);
    
    $requete->execute();
  }
}
?>