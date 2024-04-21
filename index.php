<?php declare(strict_types=1);

namespace api;
require __DIR__ . '/api/ApiController.php';


// $parser = new ApiController('convert', [19999.95, 'GPB', 'EUR'], ['app_id' => 'APP_ID', 'prettyprint' => true]);
$parser = new ApiController('latest.json', [], ['app_id' => 'APP_ID']);
try {
    $myrow = $parser->get();

    echo '<PRE>';
    print_r($myrow);
    echo '</PRE>';

} catch (\RuntimeException $e) {
    echo $e->getMessage();
}