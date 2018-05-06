<?php


use App\Support\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;


/**
 * PHPStorm helper
 * @property Builder schema
 * @property Blueprint table
 */
class CreateArticlesTable extends Migration
{
    public function up()
    {
        $this->schema->create('articles', function (Blueprint $table) {
           $table->increments('id');
           $table->string('title');
           $table->text('body');
           $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('articles');
    }

}