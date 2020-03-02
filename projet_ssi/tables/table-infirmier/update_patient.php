<?php

require_once("../../functions/auth.php");
forcer_utilisateur_connecte();
require_once("../../ConnectionToBD.php");
require_once("../../menu.php");
//require("vendor/autoload.php");

require_once("src/ControleInfoPatient.php");

use App\ControleInfoPatient;
//use \DateTime;

ConnectionToBD::setNamePassword($_SESSION["user"], $_SESSION["pwd"], "medical", "");
$db = ConnectionToBD::initialization();

$query_seleted = "select * from dossier_patient where id  = :id" ;
$response = $db->prepare($query_seleted) ; 
$response->execute(["id" => $_GET["id"]]);
$patient = $response->fetch();

$query_updated = "UPDATE dossier_patient set nom = :nom,prenom = :prenom,description = :description, num_tele = :num_tele,email = :email,date_naissance = :date_naissance WHERE id = :id " ; 


$errors = null;
$success = false;
//dd($_POST);
if(  isset($_POST["nom"] , $_POST["prenom"] , $_POST["email"] , $_POST["num_tele"] , $_POST["date_naissance"]) ){
    //dd($_POST); 
    //die();
        $_POST['nom'] = htmlentities($_POST['nom']);
        $_POST['prenom'] = htmlentities($_POST['prenom']);
        $_POST['email'] = htmlentities($_POST['email']);
        $_POST['num_tele'] = htmlentities($_POST['num_tele']);
        $_POST['date_naissance'] = htmlentities($_POST['date_naissance']);
        $_POST['description'] = htmlentities($_POST['description']);
        $controleur = new ControleInfoPatient($_POST["nom"],$_POST["prenom"], $_POST["num_tele"]); 
        //dd($controleur->isValid());
       // die();
        if($controleur->isValid()){
                //dd($_POST["date_naissance"]);
               // echo "la date naissance sous la format suivante :  " . $_POST["date_naissance"]  ;
                //die();
                $response = $db->prepare($query_updated); 
               /* dd($response); 
                die();*/
                //$date = DateTime::createFromFormat("d/m/Y", $_POST['date_naissance']); 
                //dd($date);
               // $date_naissance = $date->format("Y-m-d");
                $response->execute( [ "nom" => $_POST["nom"] , "prenom" => $_POST["prenom"], "description" => $_POST["description"], 
                "num_tele" => $_POST["num_tele"] , "email" => $_POST["email"] , "date_naissance" => $_POST["date_naissance"], "id" => $_GET["id"] ] );
                
                $query_seleted = "select * from dossier_patient where id  = :id" ;
                $response = $db->prepare($query_seleted) ; 
                $response->execute(["id" => $_GET["id"]]);
                $patient = $response->fetch();
                $success = true;
                //$_POST = []; 
        }else{
            $errors = $controleur->getError(); 
        }
}

/*else{
    $errors["error_formulaire"] = " , un champs est vide , veulliez remplir tous les champs." ; 

}
*/



?>

            <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger mt-lg-5 rounded-lg w-50 mx-auto" style="margin-top:4em;margin-bottom:4em;">
                    Formulaire invalide <?= isset($errors["error_formulaire"]) ? $errors["error_formulaire"]: "."?>
                     </div>
             <?php endif ?>
            <?php if($success): ?>
                <div class="alert alert-success mt-lg-5 rounded-lg w-50 mx-auto" style="margin-top:4em;margin-bottom:4em;">
                    Les informations de ce patient ont été bien enregistrées .  
                 </div>
             <?php endif ?>

        <div class="container shadow p-3 mb-5 mt-lg-5 bg-dark rounded-lg w-50 mx-auto" style="margin-top:4em;margin-bottom:4em;">
                <div class="text-white">
                    <h1>

                        <strong>Mis a jours les information d'un patient </strong>

                    </h1>
                </div>
            <form action="" method="post">

            <div class="form-row">
            
            <div class="form-group col-md-6">
            <label class="text-white" for="nom">Nom</label>
            <input type="text" name ="nom"class="form-control <?= isset($errors['nom']) ? "is-invalid" : "" ?>" id="nom" value="<?= $patient["nom"] ?>">
            <?php if( isset($errors["nom"])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['nom'] ?>
                     </div>
                <?php endif ?>
            </div>

            <div class="form-group col-md-6">
            <label class="text-white" for="prenom">Prenom</label>
            <input type="text" name="prenom"class=" form-control  <?= isset($errors['prenom']) ? "is-invalid" : "" ?>" id="prenom" value="<?= $patient["prenom"] ?>">

            <?php if( isset($errors["prenom"])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['prenom'] ?>
                     </div>
                <?php endif ?>
            </div>


            </div>

            <div class="form-row">

             <div class="form-group col-md-4">
              <label class="text-white" for="email">Adresse email</label>
             <input type="email" name="email" class="form-control  <?= isset($errors['email']) ? "is-invalid" : "" ?>" id="email" value="<?= $patient["email"] ?>">
             
            <?php if( isset($errors["email"])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['email'] ?>
                     </div>
                <?php endif ?>
             </div>

             <div class="form-group col-md-4">
              <label class="text-white" for="date_naissance">Date de naissance</label>
             <input type="date" name="date_naissance" class="form-control  <?= isset($errors['date_naissance']) ? "is-invalid" : "" ?> " id="date_naissance" value="<?= $patient["date_naissance"] ?>">
             <?php if( isset($errors["date_naissance"])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['date_naissance'] ?>
                     </div>
                <?php endif ?>
             </div>

             <div class="form-group col-md-4">
              <label class="text-white" for="num_tele">Numéro de téléphone</label>
             <input type="tel" name="num_tele" class="form-control <?= isset($errors['num_tele']) ? "is-invalid" : "" ?>" id="num_tele" value="<?= $patient["num_tele"] ?>">

             <?php if( isset($errors["num_tele"])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['num_tele'] ?>
                     </div>
                <?php endif ?>
             </div>

            </div>

            <div class="form-row">
                 <div class="form-group col-md-12">
                     <label class="text-white" for="description">Description de l'etat du patient </label>
                 <textarea class="form-control" name="description" id="description" rows="3">
                 <?= $patient["description"] ?>
                </textarea>

                 </div>
            </div>
            <br>

            <button type="submit" class="btn btn-success"> Confirmer </button>

            <a class="btn btn-secondary "href="/tables/table-infirmier/index.php">Retourner</a>
             
            </form>

            <br>


        </div>


<?php
    require_once("../../footer.php");
?>