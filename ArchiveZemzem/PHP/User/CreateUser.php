<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  Create Account Page </title>
    </head>
    <body>

    <ul>
            <li> <a href="ListOfUser.php"> List of user </a> </li>
            
    </ul>

        <div class="Input-Container">
            <form action="CreateUser.php" method="post">

                <label for=""> Nom </label>
                <input type="text" name="Nom" id="">
    
                <label for=""> Prenom </label>
                <input type="text" name="Prenom" id="">
                <br><br>
    
                <label for=""> Username </label>
                <input type="text" name="Username" id="">
    
                <label for=""> Password </label>
                <input type="password" name="Password" id="">

                <br><br>
    
                <label for=""> Reseau Sociaux </label>
                <select name="Reseau_Sociaux" id="">
                    <option value="Facebook"  > Facebook </option>
                    <option value="Instagram" > Instagram </option>
                </select>
                
                <label for=""> Nom Utilisateur  </label>
                <input type="text" name="Nom_Utilisateur" id="">
    
                <label for=""> Email </label>
                <input type="email" name="Email" id="">
    
                <label for=""> Numero personelle </label>
                <input type="number" name="Numero_personelle" id="">
                
                <br><br>

                <label for=""> Ville </label>
                <input type="text" name="Ville" id="">
    
                <label for=""> Adresse </label>
                <input type="text" name="Adresse" id="">

                <br><br>

                <label for=""> Persone a contactee en cas urgence </label>
                <input type="text" name="persone_Urgence" id="">

                <label for=""> Nom Complet  </label>
                <input type="text" name="Nom_complet" id="">
    
                <label for=""> Numero de telephone du personne en cas urgence </label>
                <input type="text" name="numero_urgence" id="">
                <br><br>

                <label for=""> Post de travail </label>
                <select name="Post-Travaille" id="">
                    <option value="Commercial"> Commercial </option>
                    <option value="Designer" > Designer </option>
                    <option value="A-g" > Agent de bureau </option>
                </select>

                <br><br>

                <input type="submit" value="submit" name="submit">
            </form>
            
        </div>
    </body>
</html>

<?php

    if(isset($_POST["submit"]) && isset($_POST["Post-Travaille"]) && isset($_POST["numero_urgence"]) && isset($_POST["persone_Urgence"]) && isset($_POST["Nom_complet"]) && isset($_POST["Adresse"]) && isset($_POST["Ville"]) && isset($_POST["Numero_personelle"]) && isset($_POST["Email"]) && isset($_POST["Nom_Utilisateur"]) && isset($_POST["Reseau_Sociaux"]) && isset($_POST["Password"]) &&  isset($_POST["Username"]) &&  isset($_POST["Prenom"]) && isset($_POST["Nom"])) {
       if(!empty($_POST["submit"]) && !empty($_POST["Post-Travaille"]) && !empty($_POST["numero_urgence"]) && !empty($_POST["persone_Urgence"]) && !empty($_POST["Nom_complet"]) && !empty($_POST["Adresse"]) && !empty($_POST["Ville"]) && !empty($_POST["Numero_personelle"]) && !empty($_POST["Email"]) && !empty($_POST["Nom_Utilisateur"]) && !empty($_POST["Reseau_Sociaux"]) && !empty($_POST["Password"]) &&  !empty($_POST["Username"]) &&  !empty($_POST["Prenom"]) && !empty($_POST["Nom"]) ) {
            
            $Etat = 1;
            $Role = 2;
            $Post = htmlspecialchars($_POST["Post-Travaille"]);
            $numero_urgence = htmlspecialchars($_POST["numero_urgence"]);
            $persone_urgence = htmlspecialchars($_POST["persone_Urgence"]);
            $Nom_complet = htmlspecialchars($_POST["Nom_complet"]);
            $Adresse = htmlspecialchars($_POST["Adresse"]);
            $Ville = htmlspecialchars($_POST["Ville"]);
            $Numero_personelle = htmlspecialchars($_POST["Numero_personelle"]);
            $Email = htmlspecialchars($_POST["Email"]);
            $Nom_Utilisateur = htmlspecialchars($_POST["Nom_Utilisateur"]);
            $Reseau_Sociaux = htmlspecialchars($_POST["Reseau_Sociaux"]);
            $Password = htmlspecialchars($_POST["Password"]);
            $Username = htmlspecialchars($_POST["Username"]);
            $Prenom = htmlspecialchars($_POST["Prenom"]);
            $Nom = htmlspecialchars($_POST["Nom"]);
            $stillWorking = "Yes";


            $req = $db->prepare("INSERT INTO User (Nom , Prenom, Username,Password,Numero_personelle,Reseau_Sociaux,Nom_utilisateur,Email, Ville,Adresse,Persone_Urgence,Nom_Complet,Numero_de_telephone_urgence,Post,User_Role,Etat_Account,stillWorking) 
                            VALUES (:Nom , :Prenom , :Username ,:Password ,:Numero_personelle, :Reseau_Sociaux ,:Nom_utilisateur ,:Email ,:Ville ,:Adresse ,:Persone_Urgence ,:Nom_Complet ,:Numero_de_telephone_urgence ,:Post ,:User_Role ,:Etat_Account , :stillWorking )") ;

            $result = $req -> execute([
                ":Nom" => $Nom , 
                ":Prenom" => $Prenom ,
                ":Username" =>  $Username ,
                ":Password" => $Password ,
                ":Numero_personelle" => $Numero_personelle ,
                ":Reseau_Sociaux" =>  $Reseau_Sociaux , 
                ":Nom_utilisateur" => $Nom_Utilisateur ,
                ":Email" =>  $Email ,
                ":Ville" => $Ville ,
                ":Adresse" => $Adresse ,
                ":Persone_Urgence" => $persone_urgence ,
                ":Nom_Complet" =>  $Nom_complet,
                ":Numero_de_telephone_urgence" => $numero_urgence ,
                ":Post" => $Post ,
                ":User_Role" => $Role , 
                ":Etat_Account" => $Etat ,
                ":stillWorking" => $stillWorking    

            ]);

            if($result) {
                echo "Data inserted successfully!";
            } else {
                echo "Failed to insert data.";
                print_r($req->errorInfo()); // Debugging information
            }

        } 
    }




?>