<?php


namespace Softion\Site\Models\BaseModels;

use DB;
use Illuminate\Database\Eloquent\Model;

class SubSite extends Model {

    protected $table = 'st_subsite';

    public static function get($lang, $field = 'short'){
        return parent::select('short', 'url', 'id')->where(['active' => 1, 'online' => 1, $field => $lang])->first();
    }

    public static function num(){
        return parent::where(['active' => 1, 'online' => 1])->count();
    }

}