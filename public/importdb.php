<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
$tables = ['user_types','users','registrable_users','facilities','reservations','reservation_detail','reservation_status_histories','reports','report_status_histories','migrations','cache','cache_locks','sessions','password_reset_tokens','failed_jobs','jobs','job_batches'];
foreach($tables as $t) DB::statement("DROP TABLE IF EXISTS `$t`");
DB::unprepared(file_get_contents('/app/bisqe8ufwzykt4nszqof.sql'));
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "Done!";