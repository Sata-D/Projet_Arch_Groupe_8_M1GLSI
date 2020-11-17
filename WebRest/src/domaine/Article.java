package domaine;

public class Article {
	private String titre;
	private String contenu;
	private String categorieLibelle;
	public Article(String titre, String contenu) {
		this.titre=titre;
		this.contenu=contenu;
	}
	public Article(String titre, String contenu,String categorieLibelle) {
		this.titre=titre;
		this.contenu=contenu;
	}
	
	public String getTitre() {
		return titre;
	}
	public void setTitre(String titre) {
		this.titre = titre;
	}
	public String getContenu() {
		return contenu;
	}
	public void setContenu(String contenu) {
		this.contenu = contenu;
	}
	public String getlibelle() {
		return categorieLibelle;
	}
	public void setlibelle(String libelle) {
		this.categorieLibelle = libelle;
	}
	
}
