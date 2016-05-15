<?php

namespace Softion\Site\Controllers\BaseControllers;

use Softion\Site\Controllers\PathFinderController;
use Illuminate\Support\Facades\Session;

use DB;
use Softion\Site\Models\BaseModels\Menu;

class MenuController extends PathFinderController
{

    private $menuVariable = 'menu';

    public $mParameter;

    public function set()
    {
        $this->mParameter = PathFinderController::$menuParameter;
        if (isset($this->parameters[$this->mParameter])) {
            $currentMenu = Menu::getByUrl($this->parameters[$this->mParameter]);
            if ($currentMenu) {
                if ($currentMenu->moduleName == Menu::$defaultModule) {
                    unset($this->parameters[$this->mParameter]);
                    $redirectUrl = implode('/', $this->parameters) . ((isset($_SERVER['REDIRECT_QUERY_STRING'])) ? '?' . $_SERVER['REDIRECT_QUERY_STRING'] : '');
                    echo redirect($redirectUrl);
                } else {
                    Session::put($this->menuVariable, $currentMenu);
                }
            } else {
                $this->set404();
            }
        } else {
            $currentMenu = Menu::getDefault();
            if ($currentMenu) {
                Session::put($this->menuVariable, Menu::getDefault());
            } else {
                $this->set404();
            }
        }
    }

    private function set404()
    {
        Session::put($this->menuVariable, ['moduleName' => 'notFound']);
    }

}