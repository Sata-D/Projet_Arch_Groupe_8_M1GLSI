<?php
	/**
	 * Gestionnaire des connexions à la base de données
	 */
	class ConnexionManager
	{
		public static function getInstance()
		{
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=mglsi_news;charset=utf8', 'root', '');
			}
			catch (Exception $e)
			{
				echo "Erreur de connexion à la base de données : ".$e->getMessage();
				$bdd = null;
			}
			
			return $bdd;
		}
	}
?>