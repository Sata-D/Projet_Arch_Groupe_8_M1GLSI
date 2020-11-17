package server;

import javax.xml.ws.Endpoint;

import service.SoapService;

public class SoapServer {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		String url= "http://localhost:8087/";
		Endpoint.publish(url,new SoapService());
		System.out.println("Le serveur est à l'écoute à l'adresse " +url); 

	}
 
}
