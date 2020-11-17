from zeep import Client
print("Bienvenue dans l'application de gestion des utilisateurs")
print("Entrer votre pseudo")
loginEntry=input()
login=str(loginEntry)
print("Entrer votre mot de passe")
passwordEntry=input()
password=str(passwordEntry)

#on fait appel au service d'authentification
soapClient=Client(wsdl="http://localhost:8087/SoapService?wsdl")
authentication=soapClient.service.authentication(login,password)
if (authentication!=""):
	print("Application de gestion des users:: Bienvenue")
	#while True:
	print("1 : lister utilisateur")
	print("2 : supprimer utilisateur")
	print("3 : modifier utilisateur")
	print("4 : ajouter utilisateur")
	choice_entry = input()
	choice = int(choice_entry)
	if choice == 1:
		print("liste des utilisateurs de l'application: ")
		listes = soapClient.service.readUsers()
		for users in listes:
			print("----------------------------------------")
			for champ in users:
				if(champ != "password"):
					print(champ, " : " , users[champ])
		print("----------------------------------------")
	if choice == 2:
			print("entrer le pseudo de l'utilisateur à supprimer: ")
			pseudo_entry = input()
			pseudo=str(pseudo_entry)
			soapClient.service.deleteUser(pseudo)
			print("Suppression reussie ")
	if choice == 3:
			print("entrer le pseudo de l'utilisateur à modifier: ")
			pseudo_entry = input()
			pseudo=str(pseudo_entry)
			print("entrer le nouveau mot de passe: ")
			password_entry=input()
			password=str(password_entry)
			print("entrer le nouveau mail: ")
			mail_entry=input()
			mail=str(mail_entry)
			print("entrer le nouveau profil: ")
			profil_entry=input()
			profil=str(profil_entry)
			soapClient.service.updateUser(pseudo)
			print("Mise à jour reussie: ")



else:
	print("login ou password incorrect!!!!!!!")

