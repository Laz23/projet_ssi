<?php
require_once("../../functions/auth.php");
forcer_utilisateur_connecte();
if(est_connecte()){
    if($_SESSION['role'] != "infirmier"){
        header("Location: /tables/table-medecin/index.php");
        exit();
    }
}
use App\TableHelper;
use App\URLHelper;
//use App\ControleInfoPatient;
require_once("../../menu.php");


require_once("../../ConnectionToBD.php");
//require("src/ControleInfoPatient.php");
require_once("src/TableHelper.php"); 
require_once("src/URLHelper.php");
ConnectionToBD::setNamePassword($_SESSION["user"], $_SESSION["pwd"],"medical", "");

$db = ConnectionToBD::initialization();
$db->exec("SET ROLE infirmier"); 
$db->exec("set default role infirmier"); 

    define('PER_PAGE' ,20);
    //dd(PER_PAGE);
    $query = "SELECT * FROM dossier_patient ";
    $queryTotal = "SELECT COUNT(*) as count FROM dossier_patient ";
    $params = [];
    $sortable = ["id","nom","prenom","date_naissance","email","num_tele"];
    if(isset($_GET['q']) && isset($_GET["search"])){
     // dd($_GET["q"], $_GET["search"]);
        $query .= "WHERE ".$_GET["search"]." LIKE :option";
        $queryTotal .= "WHERE ".$_GET["search"]." LIKE :option";
        $params["option"] ="%".$_GET['q']."%";
    }

    if(isset($_GET['sort']) && in_array($_GET["sort"],$sortable)){
        $direction = $_GET["dir"] ?? "asc";
        if(!in_array($direction,["asc","desc"])){
            $direction = "asc";
        }
        $query .= " ORDER BY ".$_GET["sort"] ." $direction ";
    }

    // Pagination
    $page = 1;
    if(isset($_GET['p'])){
        $page = (int) $_GET['p'];
        if($page == 0){
            $page = 1;
        }
    }
    $offset = ($page-1) * PER_PAGE;
    
    $query .= " LIMIT ".PER_PAGE." OFFSET $offset";
    $statement = $db->prepare($query);
    $statement->execute($params);
    $patients = $statement->fetchAll();

    $statement = $db->prepare($queryTotal);
    $statement->execute($params);
    $count = (int)$statement->fetch()["count"];
  //  dd($count);
    $pages = ceil($count / PER_PAGE);

    //dd($pages, $page);

    //dd(http_build_query(array_merge($_GET,["p" => 3])));
    //dd($page);
   // dd($count);
   // dd($products);
?>
        <div class="shadow-none p-4 mb-4 mt-5 bg-light rounded-lg w-80 ">

       



        <h1 class="text-secondary"> <strong>Les patients </strong></h1>

        <form action="" class="mb-4"> 
                <div class="form-group">
                    <input type="text" class="form-control" name="q" placeholder="Rechercher un patient" value="<?= htmlentities($_GET["q"] ?? null) ?>">

                </div>
                

                <p>
                 <a class="btn btn-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                     Les options de recherche 
                 </a>
                </p>

                <div class="collapse" id="collapseExample">
                <div class="card card-body">

                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="id" name="search" class="custom-control-input" value="id">
                <label class="custom-control-label" for="id">ID</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="nom" name="search" class="custom-control-input" value="nom">
                <label class="custom-control-label" for="nom">Nom</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="prenom" name="search" class="custom-control-input" value="prenom">
                <label class="custom-control-label" for="prenom">Prenom</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="date_aissance" name="search" class="custom-control-input" value="date_naissance">
                <label class="custom-control-label" for="date_aissance">Date de naissance</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="email" name="search" class="custom-control-input" value="email">
                <label class="custom-control-label" for="email">Adresse email</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="num_tele" name="search" class="custom-control-input" value="num_tele">
                <label class="custom-control-label" for="num_tele">Numéro de téléphone</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="description" name="search" class="custom-control-input" value="description">
                <label class="custom-control-label" for="description">État de patient</label>
                </div>

                </div>
                </div>
                <br>
                <div class="form-group">
                <button class="btn btn-primary">Rechercher</button>
                </div>
        </form>
        </div>
        <?php if(isset($_GET["s"])) : ?>
            <div class="alert alert-success rounded-lg w-80 mx-auto" style="margin-top:4em;margin-bottom:4em;">
                   La suppression a été bien éffectuée.  
            </div>
        <?php endif ?>

    
    <div class="shadow-lg p-3 mb-5  bg-dark rounded-lg w-80 mx-auto">

    
    <table class="table table-striped table-dark table-hover">
        <thead >
            <tr>
                <th><?= TableHelper::sort("id","ID",$_GET)?></th>
                <th><?= TableHelper::sort("nom","Nom",$_GET)?></th>
                <th><?= TableHelper::sort("prenom","Prenom",$_GET)?></th>
                <th><?= TableHelper::sort("date_naissance","Date de naissance",$_GET)?></th>
                <th><?= TableHelper::sort("email","Adresse email",$_GET)?></th>
                <th><?= TableHelper::sort("num_tele","Numéro de téléphone",$_GET)?></th>
                <th scope="3">Les actions</th>
                
            </tr>
        </thead>

        <tbody>
           <?php foreach($patients as $patient): ?>
            <tr>
                <th><?= $patient['id'] ?></th>
                <th ><?= $patient['nom'] ?></th>
                <th  class="<?= $patient['prenom'] === null ? "table-warning" : "" ?>"> <?= $patient['prenom']  ?> </th>
                <th><?= $patient['date_naissance'] ?></th>
                <th class=" <?= $patient['email'] === null ? "table-warning" : "" ?>" >  <?= $patient['email'] !== null ? $patient['email'] : "pas d'ad resse email" ?> </th>
                <th class="<?= $patient['num_tele'] === null ? "table-warning" : "" ?>"><?= $patient['num_tele'] !== null ? $patient['num_tele'] : "pas de numéro du téléphone!" ?></th>
                <th><a class="btn btn-primary btn-sm" href="/tables/table-infirmier/acceder_patient.php?id=<?=$patient["id"]?>">Accéder</a> <a class="btn btn-warning btn-sm"href="/tables/table-infirmier/update_patient.php?id=<?=$patient["id"]?>"> Mis a jour</a> <!--<a class="btn btn-danger btn-sm"href="/tables/table-infirmier/suppression_patient.php?id= //$patient["id"] " >Supprimer</a> --> </th>

            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
    <br>

    


    <div class="alert alert-info  rounded p-2 w-80 mx-auto container-fluid">
        <h4> <strong>Pagination :</strong> </h4>
        <?php if($pages <= 1 ) : ?>
            <strong>Qu'une seule page</strong>
            <?php endif?>

        <?php if($pages > 1 && $page > 1): ?>   
        <a href="?<?= URLHelper::withParam($_GET,"p",($page - 1)) ?>" class="btn btn-secondary">Page précédente</a>
        <?php endif ?>
        <?php if($pages > 1 && $page < $pages): ?>
        <a href="?<?= URLHelper::withParam($_GET,"p",($page + 1)) ?>" class="btn btn-primary">Page suivante</a>
        <?php endif ?>
    </div>
<?php
        require_once("../../footer.php");
?>