<?php

include '../vendor/autoload.php';

$container   = new \DI\Container();
$farmService = $container->get('FarmGame\\Service\\FarmService');

$response = "Please select and option below";


if (isset($_POST['newGame'])) {
    $response = $farmService->newGame();
}

if (isset($_POST['feed'])) {
    $response = $farmService->processTurn();
}

echo $response;

?>
<form action="index.php" method="POST">
    <button type="submit" name="newGame">Start New Game</button>
    <button type="submit" name="feed">Feed an Animal</button>
</form>
