<?php
require_once("../../functions/auth.php");
forcer_utilisateur_connecte();
if(est_connecte()){
    if($_SESSION['role'] != "medecin"){
        header("Location: /tables/table-infirmier/index.php");
        exit();
    }
}

require_once("../../ConnectionToBD.php");
require_once("../../menu.php");
//require("vendor/autoload.php");

use App\ControleInfoPatient;
//use \DateTime;

ConnectionToBD::setNamePassword($_SESSION["user"], $_SESSION["pwd"], "medical", "");
$db = ConnectionToBD::initialization();

$query = "select * from dossier_patient where id  = :id" ;
$response = $db->prepare($query) ; 
$response->execute(["id" => $_GET["id"]]);
$patient = $response->fetch();
/*else{
    $errors["error_formulaire"] = " , un champs est vide , veulliez remplir tous les champs." ; 

}
*/



?>

        <div class="container shadow p-3 mb-5 mt-lg-5 bg-dark rounded-lg w-50 mx-auto" style="margin-top:4em;margin-bottom:4em;">
                <div class="text-white">
                    <h1>

                        <strong>Acces aux information d'un patient : <?= $patient["nom"] ." ". $patient["prenom"]?>  </strong>

                    </h1>
                </div>
            <form action="" method="">

            <div class="form-row">
            
            <div class="form-group col-md-6">
            <label class="text-white" for="nom">Nom</label>
            <input type="text" name ="nom"class="form-control " id="nom" value="<?= $patient["nom"] ?>" disabled>
            </div>

            <div class="form-group col-md-6">
            <label class="text-white" for="prenom">Prenom</label>
            <input type="text" name="prenom"class=" form-control" id="prenom" value="<?= $patient["prenom"] ?>" disabled>
            </div>


            </div>

            <div class="form-row">

             <div class="form-group col-md-4">
              <label class="text-white" for="email">Adresse email</label>
             <input type="text" name="email" class="form-control " id="email" value="<?= $patient["email"] ?>" disabled>
             </div>

             <div class="form-group col-md-4">
              <label class="text-white" for="date_naissance">Date de naissance</label>
             <input type="text" name="date_naissance" class="form-control " id="date_naissance" value="<?= $patient["date_naissance"]?>" disabled>
             </div>

             <div class="form-group col-md-4">
              <label class="text-white" for="num_tele">Numéro de téléphone</label>
             <input type="text" name="num_tele" class="form-control " id="num_tele" value=" <?= $patient["num_tele"] ?>" disabled>
             </div>

            </div>

            <div class="form-row">
                 <div class="form-group col-md-12">
                     <label class="text-white" for="description">Description de l'etat du patient </label>
                 <textarea class="form-control" name="description" id="description" rows="3" disabled>
                 <?= $patient["description"] ?>
                </textarea>

                 </div>
            </div>
            <br>

            <a class="btn btn-secondary "href="/tables/table-medecin/index.php">Retourner</a>
             
            </form>

            <br>


        </div>




<?php
    require_once("../../footer.php");
    ?>
