<?php

namespace Softion\Site\Models\BaseModels;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Menu extends Model
{

    protected $table = 'st_menu';
    public static $defaultModule = 'Home';

    public static function getByUrl($url)
    {
        return parent::join('st_module as module', 'module.id', '=', 'st_menu.module')
        ->select('st_menu.*', 'module.module as moduleName', 'module.type as moduleType')->where(['st_menu.url' => $url, 'module.active' => 1, 'st_menu.active' => 1, 'st_menu.lang' => Session::get('lang')])->first();
    }

    public static function getDefault(){
        return parent::join('st_module as module', 'module.id', '=', 'st_menu.module')
            ->select('st_menu.*', 'module.module as moduleName', 'module.type as moduleType')->where(['module.module' => self::$defaultModule, 'module.active' => 1, 'st_menu.active' => 1, 'st_menu.lang' => Session::get('lang')])->first();
    }

}