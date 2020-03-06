<?php
require_once("menu.php") ; 
require_once("ConnectionToBD.php");

ConnectionToBD::setNamePassword($_SESSION["user"], $_SESSION["pwd"],"", "");

$db = ConnectionToBD::initialization();
$db->exec("SET ROLE ".$_SESSION["role"]); 
$db->exec("set default role ".$_SESSION["role"]); 
sleep(2);
header("Location: /tables/table-".$_SESSION['role']."/index.php" );
exit();



?>

<div class="m-auto w-50">
<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  <span class="sr-only">Loading...</span>
</button>
<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  Loading...
</button>
</div>


<?php

require_once("footer.php");

?>