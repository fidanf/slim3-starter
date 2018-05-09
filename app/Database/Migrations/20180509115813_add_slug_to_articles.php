<?php

use App\Support\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * PHPStorm helper
 * @property Builder schema
 * @property Blueprint table
 */
class AddSlugToArticles extends Migration
{
    public function up()
    {
        $this->schema->table('articles', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });
    }

    public function down()
    {
        $this->schema->table('articles', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        // Without doctrine/dbal dependency :
        // $this->table('articles')->removeColumn('slug')->save();
    }

}