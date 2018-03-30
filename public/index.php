<?php

include '../vendor/autoload.php';

$container   = new \DI\Container();
$farmService = $container->get('FarmGame\\Service\\FarmService');

if($_POST['newGame']){
    $farmService->newGame();
}

if ($_POST['feed']){
    $farmService->processTurn();
}

?>
<form action="index.php" method="POST">
    <button type="newGame" name="">Start New Game</button>
    <button type="feed" name="">Feed an Animal</button>
</form>
