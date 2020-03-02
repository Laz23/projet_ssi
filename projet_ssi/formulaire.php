<?php 
    require_once("menu.php"); 
    require_once("ConnectionToBD.php");
    require_once("functions/auth.php"); 
    $erreur =null;
    ConnectionToBD::setNamePassword("root", "lazizi1997+", "mysql", "");
    $db = ConnectionToBD::initialization();
    //$db = new PDO("mysql:host=localhost;dbname=medical;charset=utf8", "laz", "");
   // $reponse = $db->query("select user, password , default_role from user"); 

    
   if(!empty($_POST['pseudo']) && !empty($_POST['motdepasse']) && isset($_POST["role"])){ 

    //echo password_hash($_POST['role'], PASSWORD_DEFAULT) ;
        $query = $db->prepare("create user :pseudo@'localhost' identified by :passwd"); 
        $query->execute(["pseudo" => $_POST["pseudo"] , "passwd" => $_POST["motdepasse"]]);
       // die();

        $query = $db->prepare("grant :role to :pseudo@'localhost'"); 
        $query->execute(["role" => $_POST['role'] , "pseudo" => $_POST["pseudo"]]);
        est_connecte();
        $_SESSION['connecte'] =1;
        
            $_SESSION["user"] = $_POST["pseudo"] ; 
            $_SESSION["pwd"] = $_POST["motdepasse"];
            $_SESSION["role"] = $_POST["role"];
        
            
       // $_COOKIE["pwd"] = $_POST["motdepasse"];
        //$_COOKIE["user"] = $_POST["pseudo"];
        //$passwd = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT) ;
        //ConnectionToBD::setNamePassword($_POST['pseudo'], $_POST["motdepasse"], "" , $_POST["role"]) ; 
        header("Location: /tables/table-".$_POST['role']."/index.php" );
        exit();
    }else{
        $erreur = "veuillez remplir les champs " ;
    }

    if(est_connecte()){
            header("Location: /tables/table-".$_SESSION["role"]."/index.php");
            exit();
    }
?>

<?php if($erreur): ?>
        <p class="alert alert-danger mx-auto w-50" style=" margin-top:5em;">
            <?= $erreur ?>
</p>
    <?php endif ?>

    <div class="shadow-none p-3 mb-5 bg-light rounded w-50 mx-auto">

<div class="container" style="margin-top:2em;margin-bottom:2em;">
    <div class="mx-auto w-25">
        <h2><span class="badge badge-dark">Mon site</span></h2>
        </div>
        <br>
        <div class="mx-auto w-50"><h1>
            <strong>Créer Votre compte 
             <small class="text-muted">Rejoignez vous .</small>
            </strong>
            </h1>
        </div>
    <form action="" method="post" >
             <label for="exampleInputEmail1">Pseudo</label>
            <div class="form-group">
                    <input type="text"  class="form-control" name="pseudo" placeholder="Nom de l'utilisateur">
            </div>
            <label for="exampleInputEmail1">Mot de passe</label>
            <div class="from-group">
                    <input type="password" class="form-control" name="motdepasse" placeholder="mots de passe">
            </div>
            <small id="emailHelp" class="form-text text-info">Soyez toujours vigilant .</small>
            <br>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="medecin" name="role" class="custom-control-input " value="medecin">
            <label class="custom-control-label" for="medecin">Médecin</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="infirmier" name="role" class="custom-control-input" value="infirmier">
            <label class="custom-control-label"  for="infirmier">Infirmier</label>
            </div>
            <br>
            <br>
            <button type="submit" class="btn btn-success">Inscription</button>  <a class="btn btn-primary"href="/se_connecter.php">Se connecter</a>
    </form>

    </div>

</div>


<?php
require_once("footer.php");

?>