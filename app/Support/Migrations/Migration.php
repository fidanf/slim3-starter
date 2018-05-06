<?php


namespace App\Support\Migrations;

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Migration extends AbstractMigration
{
    protected $schema;

    protected function init()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->bootEloquent();
        $capsule->setAsGlobal();
        $this->schema = $capsule->schema();
    }

}