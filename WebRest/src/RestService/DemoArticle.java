package RestService;
import javax.ws.rs.core.MediaType;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;

import domaine.Article;

@Path("/Article")
public class DemoArticle {
	String BDD = "mglsi_news";
	String url = "jdbc:mysql://localhost:3306/" + BDD;
	String user = "user_al";
	String passwd = "passer"; 
	Connection  connexion;
	PreparedStatement statement;
	ResultSet result;
	public DemoArticle(){
		try
	    {
	 	  connexion=DriverManager.getConnection(url, user, passwd);
	 	  System.out.println("connexion reussie");
	    }
	    catch(Exception e)
	    {
	    System.out.println(e.getMessage());
	    }
		
	}
	//Récupérer la liste de tous les articles.(json ou xml au choix)
	@GET
	@Path("/listeArticles")
	@Produces(value={MediaType.APPLICATION_JSON, MediaType.APPLICATION_XML})
	public ArrayList <Article> readArticles()
	{
		 ArrayList<Article> liste= new ArrayList<Article>();
	     try
	     {
	       statement=connexion.prepareStatement("select * from article");
	       result=statement.executeQuery();
	       while(result.next())
	         {
	           String titre =result.getString("titre");
	           String contenu=result.getString("contenu");
	        
	           Article article = new Article(titre,contenu);

	           liste.add(article); 
	         }  
	     }
	     catch(Exception e)
	     {
	        System.out.println(e.getMessage());
	     }
	    return liste;
	}
	//recuperer la liste des articles recuperes en categorie
	@GET
	@Path("/listeArticlesparcaetgorie")
	@Produces(value={MediaType.APPLICATION_XML,MediaType.APPLICATION_JSON})
	public ArrayList <Article> readArticlesByCategorie()
	{
		 ArrayList<Article> liste= new ArrayList<Article>();
	     try
	     {
	       statement=connexion.prepareStatement("select * from article, categorie group by libelle");
	       result=statement.executeQuery();
	       while(result.next())
	         {
	           String titre =result.getString("titre");
	           String contenu=result.getString("contenu");
	           String libelle=result.getString("libelle");
	        
	           Article article = new Article(titre,contenu,libelle);

	           liste.add(article); 
	         }  
	     }
	     catch(Exception e)
	     {
	        System.out.println(e.getMessage());
	     }
	    return liste;
	}
	//récupérer la liste des articles appartenant à une catégorie fournie par l’utilisateur
	@Path("{listeArticleCategorie}")
	@GET
	@Produces(value={MediaType.APPLICATION_JSON,MediaType.APPLICATION_XML})
		public ArrayList <Article> readArticlesCategorie(@PathParam("categorie")String categorie)
		{
			 ArrayList<Article> liste= new ArrayList<Article>();
		     try
		     {
		       statement=connexion.prepareStatement("select * from article, categorie where article.id=categorie.id and categorie.libelle=?");
		       statement.setString(1, categorie);
		       
		       result=statement.executeQuery();
		       while(result.next())
		         {
			           String titre =result.getString("titre");
			           String contenu=result.getString("contenu");
			           String libelle=result.getString("libelle");
			        
			           Article article = new Article(titre,contenu,libelle);

			           liste.add(article); 
		         }  
		     }
		     catch(Exception e)
		     {
		        System.out.println(e.getMessage());
		     }
		    return liste;

		}
}

