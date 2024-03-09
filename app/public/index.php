<?php
// app/public/index.php (the front controller)

require_once __DIR__ . '/../Autoloader.php';
// Include the routing file
require_once __DIR__ . '/../../app/routes/web.php';

// Now the web.php script will handle the request based on the current URI

