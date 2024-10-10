<?php
// deploy
$output = shell_exec('git pull origin main && php artisan config:cache && php artisan route:cache && php artisan view:cache');
echo "<pre>$output</pre>";
?>