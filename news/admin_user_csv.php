<?php

include("config.ini");
$link=mysqli_connect(HOST,USER,PASSWORD,DB);

//Premiere ligne = nom des champs (si on en a besoin)
//$csv_output = "p_nom,p_email";
//$csv_output .= "\n";

    $csv_output = "pseudo;pass;email;profil;";
    $csv_output .= "\n";
    
    //Requete SQL
    
    $query = 'SELECT * FROM users';
    $result = mysqli_query($link, $query)                
    or die("Could not connect: ".mysqli_error($link));
    
    
    //Boucle sur les resultats
    while($row = mysqli_fetch_assoc($result)) {
    $csv_output .= "$row[pseudo]; $row[pass]; $row[email]; $row[profil]\n";
    }
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=ListeUtilisateurs_" . date("Ymd").".csv");
    print $csv_output;
    exit;
?> 