<?php


namespace Softion\Site\Models\BaseModels;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    protected $table = 'st_setting';

    public static function get($name){
        return parent::select('value')->where('name' , '=', $name)->first();
    }

}