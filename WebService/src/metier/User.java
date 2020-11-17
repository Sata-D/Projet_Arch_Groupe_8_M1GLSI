package metier;
import  com.mkyong.hashing.PasswordSha256;

public class User {
	private String login;
	private String mail;
	private String password;
	private String profile;
	
	public String getLogin() {
		return login;
	}

	public void setLogin(String login) {
		this.login = login;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = PasswordSha256.sha256(password);
	}
	public String getProfile() {
		return profile;
	}

	public void setProfile(String profile) {
		this.profile = profile;
	}

	public String getMail() {
		return mail;
	}

	public void setMail(String mail) {
		this.mail = mail;
	}

	public User(){
		
	}
	
	public User(String login, String mail,String password, String profile) {
		super();
		setLogin(login);
		setMail(mail);
		setPassword(password);
		setProfile(profile);
	}
	public User(String login, String mail, String profile) {
		super();
		setLogin(login);
		setMail(mail);
		setProfile(profile);
	}
	
}
