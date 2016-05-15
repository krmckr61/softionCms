<?php


namespace Softion\Site\Models\BaseModels;

use DB;
use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'st_language';

    public static function get($lang, $field = 'short'){
        return parent::select('short', 'url')->where(['active' => 1, 'online' => 1, $field => $lang])->first();
    }

    public static function num(){
        return parent::where(['active' => 1, 'online' => 1])->count();
    }

}