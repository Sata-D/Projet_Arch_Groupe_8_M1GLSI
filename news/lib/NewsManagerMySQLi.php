<?php
class NewsManagerMySQLi extends NewsManager
{
  /**
   * Attribut contenant l'instance représentant la BDD.
   * @type MySQLi
   */
  protected $db;
  
  /**
   * Constructeur étant chargé d'enregistrer l'instance de MySQLi dans l'attribut $db.
   * @param $db MySQLi Le DAO
   * @return void
   */
  public function __construct(MySQLi $db)
  {
    $this->db = $db;
  }
  
  /**
   * @see NewsManager::add()
   */
  protected function add(News $news)
  {
    $requete = $this->db->prepare('INSERT INTO article(id, titre, contenu, dateCreation, dateModification,categorie) VALUES(?, ?, ?,?, NOW(), NOW())');
    
    $requete->bind_param('sss', $news->titre(), $news->contenu(), $news->contenu());
    
    $requete->execute();
  }
  
  /**
   * @see NewsManager::count()
   */
  public function count()
  {
    return $this->db->query('SELECT id FROM article')->num_rows;
  }
  
  /**
   * @see NewsManager::delete()
   */
  public function delete($id)
  {
    $id = (int) $id;
    
    $requete = $this->db->prepare('DELETE FROM article WHERE id = ?');
    
    $requete->bind_param('i', $id);
    
    $requete->execute();
  }
  
  /**
   * @see NewsManager::getList()
   */
  public function getList($debut = -1, $limite = -1)
  {
    $listeNews = [];
    
    $sql = 'SELECT id,titre, contenu,dateCreation, dateModification,categorie FROM article ORDER BY id DESC';
    
    // On vérifie l'intégrité des paramètres fournis.
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    
    $requete = $this->db->query($sql);
    
    while ($news = $requete->fetch_object('article'))
    {
      $news->setDateCreation(new DateTime($news->dateCreation()));
      $news->setDateModification(new DateTime($news->dateModification()));

      $listeNews[] = $news;
    }
    
    return $listeNews;
  }
  
  /**
   * @see NewsManager::getUnique()
   */
  public function getUnique($id)
  {
    $id = (int) $id;
    
    $requete = $this->db->prepare('SELECT id, titre, contenu, dateCreation, dateModification,categorie FROM article WHERE id = ?');
    $requete->bind_param('i', $id);
    $requete->execute();
    
    $requete->bind_result($id, $titre, $contenu, $dateCreationte, $dateModification,$categorie);
    
    $requete->fetch();
    
    return new News([
      'id' => $id,
      'titre' => $titre,
      'contenu' => $contenu,
      'dateCreation' => new DateTime($dateCreation),
      'dateModification' => new DateTime($dateModification),
      'categorie' => $categorie,
    ]);
  }
  
  /**
   * @see NewsManager::update()
   */
  protected function update(News $news)
  {
    $requete = $this->db->prepare('UPDATE article SET titre = ? , contenu = ?, dateModification = NOW() WHERE id = ?');
    
    $requete->bind_param('sssi', $news->titre(), $news->contenu(), $news->id());
    
    $requete->execute();
  }
}
?>