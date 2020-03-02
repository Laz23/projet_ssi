<?php
require_once("functions/auth.php");
require_once("menu.php"); 
require_once("ConnectionToBD.php"); 
$erreur = null;
ConnectionToBD::setNamePassword("root", "lazizi1997+", "mysql", "");
$db = ConnectionToBD::initialization(); 

//echo $donnee ; 

if(!empty($_POST['pseudo']) && !empty($_POST['motdepasse'])){


  /*  $reponse = $db->query("select user, password , default_role from user where user = "); 
    while($donnees = $reponse->fetch()){
        echo "nom : " . $donnees["User"] . ", prenom  : ". $donnees["Password"]  . " , description : " .$donnees['default_role'] ."<br>";
    }*/
    
    $response = $db->prepare("select User , Password , default_role from user where User  = :user and Password = PASSWORD(:password)");
    $response->execute( ['user' => $_POST['pseudo'] , "password" => $_POST["motdepasse"] ] ) ;
    $donnee = $response->fetch();
    if(is_array($donnee)){
            est_connecte();
            $_SESSION['connecte'] =1;
            //ConnectionToBD::setNamePassword($donnee["User"] ,$donnee["password"], "medical", $donnee["default_role"]);

            
            $_SESSION["user"] = $_POST["pseudo"] ; 
            $_SESSION["pwd"] = $_POST["motdepasse"];
            $_SESSION["role"] = $donnee["default_role"];
            
           /* setcookie('user', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true);
            setcookie('pwd', $_POST['motdepasse'], time() + 365*24*3600, null, null, false, true);
            setcookie('role', $donnee["default_role"], time() + 365*24*3600, null, null, false, true);*/
            header("Location: /tables/table-".$donnee["default_role"]."/index.php");
            exit();
    }else{
        $erreur = "identifiants incorrects";
    }
   
    // echo "<br> " . $donnee['User'] . $donnee["Password"] ."<br>";
    
            /*if($_POST["pseudo"] === "lzz" && password_verify($_POST["motdepasse"],$passwd)){
                session_start();
                $_SESSION['connecte'] =1;
                    header("Location: /dashboard.php");
                    exit();
            }else{
                $erreur = "identifiants incorrects";
            }*/
         
    }else{
        $erreur = "veuilliez remplir les champs "; 
    }

    if(est_connecte()){
            header("Location: /tables/table-".$_SESSION["role"]."/index.php");
            exit();
    }

   /* require_once "functions/auth.php";
    if(est_connecte()){
            header("Location: /dashboard.php");
            exit();
    }*/
?>
    <?php if($erreur): ?>
        <div class="alert alert-danger mx-auto w-50" style=" margin-top:5em;">
            <?= $erreur ?>
        </div>
    <?php endif ?>

    
    <div class="container shadow-none p-3 mb-5 bg-light rounded w-50 mx-auto "  style="margin-top:3em;margin-bottom:3em;">
    <h1><span class="badge badge-dark">Mon site</span></h1>
    <form action="" method="post" >
    <label for="exampleInputEmail1">Pseudo</label>
            <div class="form-group">
                    <input type="text"  class="form-control" name="pseudo" placeholder="Pseudo de l'utilisateur">
            </div>
            <label for="exampleInputEmail1">Mot de passe</label>
            <div class="from-group">
                    <input type="password" class="form-control" name="motdepasse" placeholder="mots de passe">
            </div>
            <small id="emailHelp" class="form-text text-info">Soyez toujours vigilant .</small>
            <br>

            <button type="submit" class="btn btn-primary">connexion</button> <a href="/formulaire.php" class="btn btn-success">s'inscrire</a>
    </form>
    

    </div>


<?php 
//echo "<br> " . $donnee["user"] ."<br>";
require_once("footer.php"); 
?>