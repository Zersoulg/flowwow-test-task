<?php declare(strict_types=1);

namespace api;
require __DIR__ . '/api/ApiController.php';


$parser = new ApiController('latest', ['app_id' => 'App_id']);
try {
    $myrow = $parser->get();

    echo '<PRE>';
    print_r($myrow);
    echo '</PRE>';

} catch (\RuntimeException $e) {
    echo $e->getMessage();
}