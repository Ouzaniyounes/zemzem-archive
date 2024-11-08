<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  Add Commune </title>
    </head>
    <body>

    <ul>
            <li> <a href="listCommune.php"> List of Commune  </a> </li>
            
    </ul>

        <div class="Input-Container">
            <form action="addCommune.php" method="post">

                <label for=""> Nom Commune </label>
                <input type="text" name="NomCommune" id="">
    
                <select name="Wilaya" id="">
                    <option value="Adrar"> Adrar </option>
                    <option value="Chlef"> Chlef </option>
                    <option value="Laghouat"> Laghouat </option>
                    <option value="Oum El Bouaghi"> Oum El Bouaghi </option>
                    <option value="Batna"> Batna </option>
                    <option value="Béjaïa"> Béjaïa </option>
                    <option value="Biskra"> Biskra </option>
                    <option value="Béchar"> Béchar </option>
                    <option value="Blida"> Blida </option>
                    <option value="Bouïra"> Bouïra </option>
                    <option value="Tamanghasset"> Tamanghasset </option>
                    <option value="Tébessa"> Tébessa </option>
                    <option value="Tlemcen"> Tlemcen </option>
                    <option value="Tiaret"> Tiaret </option>
                    <option value="Tizi Ouzou"> Tizi Ouzou </option>
                    <option value="Algiers"> Algiers </option>
                    <option value="Djelfa"> Djelfa </option>
                    <option value="Jijel"> Jijel </option>
                    <option value="Sétif"> Sétif </option>
                    <option value="Saïda"> Saïda </option>
                    <option value="Skikda"> Skikda </option>
                    <option value="Sidi Bel Abbès"> Sidi Bel Abbès </option>
                    <option value="Annaba"> Annaba </option>
                    <option value="Guelma"> Guelma </option>
                    <option value="Constantine"> Constantine </option>
                    <option value="Médéa"> Médéa </option>
                    <option value="Mostaganem"> Mostaganem </option>
                    <option value="M'Sila"> M'Sila </option>
                    <option value="Mascara"> Mascara </option>
                    <option value="Ouargla"> Ouargla </option>
                    <option value="Oran"> Oran </option>
                    <option value="El Bayadh"> El Bayadh </option>
                    <option value="Illizi"> Illizi </option>
                    <option value="Bordj Bou Arréridj"> Bordj Bou Arréridj</option>
                    <option value="Boumerdès"> Boumerdès </option>
                    <option value="El Tarf"> El Tarf </option>
                    <option value="Tindouf"> Tindouf </option>
                    <option value="Tissemsilt"> Tissemsilt </option>
                    <option value="El Oued"> El Oued </option>
                    <option value="Khenchela"> Khenchela </option>
                    <option value="Souk Ahras"> Souk Ahras </option>
                    <option value="Tipasa"> Tipasa </option>
                    <option value="Mila"> Mila </option>
                    <option value="Aïn Defla"> Aïn Defla </option>
                    <option value="Naama"> Naama </option>
                    <option value="Aïn Témouchent"> Aïn Témouchent </option>
                    <option value="Ghardaïa"> Ghardaïa </option>
                    <option value="Relizane"> Relizane </option>
                    <option value="Timimoun"> Timimoun </option>
                    <option value="Bordj Baji Mokhtar"> Bordj Baji Mokhtar </option>
                    <option value="Ouled Djellal"> Ouled Djellal </option>
                    <option value="Béni Abbès"> Béni Abbès	 </option>
                    <option value="In Salah"> In Salah </option>
                    <option value="Ain Guezzam"> Ain Guezzam </option>
                    <option value="Touggourt"> Touggourt </option>
                    <option value="Djanet"> Djanet </option>
                    <option value="El M'ghair"> El M'ghair </option>
                    <option value="El Menia"> El Menia </option>
                    
                </select>

                <br><br>
    

                <input type="submit" value="submit" name="submit">
            </form>
            
        </div>
    </body>
</html>

<?php

    if(isset($_POST["submit"]) ){
    if(isset($_POST["NomCommune"]) && isset($_POST["Wilaya"]) ) {
       if(!empty($_POST["NomCommune"]) && !empty($_POST["Wilaya"]) ) {
            

            $NomCommune = htmlspecialchars($_POST["NomCommune"]);
            $Wilaya = htmlspecialchars($_POST["Wilaya"]);
            

            // Recuperer id wilaya
            $req1 = $db->prepare("SELECT id_Wilaya FROM Wilaya WHERE Nom_wilaya = :Wilaya LIMIT 1");
            $id_wilaya = $req1 -> execute([
                ":Wilaya" => $Wilaya
            ]);
    
            $Result  = $req1->fetch();
            $id_wilaya = $Result["id_Wilaya"];
             

            $req2 = $db->prepare("INSERT INTO Commune (Nom_commune , id_Wilaya) VALUES (:NomCommune , :Wilaya  )") ;

            $result = $req2 -> execute([
                ":NomCommune" => $NomCommune , 
                ":Wilaya" => $id_wilaya 
                
            ]);

            if($result) {

                echo "Wilaya : " .$Wilaya . " / <br> Commune : " .$NomCommune ;
            } else {
                echo "Failed to insert data.";
                print_r($req->errorInfo()); // Debugging information
            }

        } 
    }
}




?>