package service;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;

import metier.User;
@WebService
public class SoapService{
	String BDD = "mglsi_news";
	String url = "jdbc:mysql://localhost:3306/" + BDD;
	String user = "user_al";
	String passwd = "passer"; 
	Connection  connexion;
	PreparedStatement statement;
	ResultSet result;
	public SoapService(){
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
	//Lister les utilisateurs
	@WebMethod
	public ArrayList <User> readUsers()
	{
		 ArrayList<User> liste= new ArrayList<User>();
	     try
	     {
	       statement=connexion.prepareStatement("select * from users");
	       result=statement.executeQuery();
	       while(result.next())
	         {
	           String login =result.getString("pseudo");
	           String mail=result.getString("email");
	           String profile=result.getString("profil");  
	           User user = new User(login,mail,profile);

	           liste.add(user); 
	         }  
	     }
	     catch(Exception e)
	     {
	        System.out.println(e.getMessage());
	     }
	    return liste;
	}
	    //Ajouter utilisateur
		@WebMethod
	    public void addUser(User user) {
			try
			 {
			statement = connexion.prepareStatement("insert into users (pseudo,pass, email, profil) values(?,?,?,?)");
		
			statement.setString(1,user.getLogin());
			statement.setString(2,user.getPassword());
			statement.setString(3,user.getMail());
			statement.setString(4,user.getProfile());

		
			statement.executeUpdate();
		  }

		  catch(Exception e)
		  {
		  System.out.println(e.getMessage());
		  }
			
		}
		
		
		//supprimer utilisateur
	    @WebMethod
		public void deleteUser(String pseudo)
		{
			try
			 {
				statement = connexion.prepareStatement("delete from users where pseudo = ?");
				statement.setString(1,pseudo);

				statement.executeUpdate();
		  }
		  catch(Exception e)
		  {
		  System.out.println(e.getMessage());
		  }

		}
		
		
		//modifier utilisateur
		@WebMethod
		public void updateUser(User user){
			try{
				statement = connexion.prepareStatement("update users set pass=?, email=?, profil=? where pseudo= ?");
				statement.setString(1,user.getPassword());
				statement.setString(2,user.getMail());
				statement.setString(3,user.getProfile());
				statement.setString(4,user.getLogin());
				statement.executeUpdate();
			}
			catch(Exception e){
				System.out.println(e.getMessage());
			}
		}
		//authentification 
		@WebMethod
		public boolean authentication(@WebParam(name="login")String login, @WebParam(name="password")String password){
			boolean isAllowed = false;
			try
			 {
				statement = connexion.prepareStatement("select pseudo, pass,profil from users where pseudo = ?");
				statement.setString(1,login);
	
				result=statement.executeQuery();
				result.next();
	
				if(result.getString(1).equals(login)){
					if(result.getString(2).equals(password)){
						if(result.getString(3)=="admin") {
							isAllowed = true;
						}
					}
				}
		  }
		  catch(Exception e)
		  {
		  System.out.println(e.getMessage());
		  }
			return isAllowed;
		}

	
	
	
}
