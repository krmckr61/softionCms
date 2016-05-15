<?php

namespace Softion\Site\Controllers;

use App\Http\Controllers\Controller;

use Softion\Site\Controllers\BaseControllers\LanguageController;
use Softion\Site\Controllers\BaseControllers\SubSiteController;
use Softion\Site\Controllers\BaseControllers\MenuController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class PathFinderController extends Controller
{

    private $checkUrl = 'http://check.softion.dev?url=';

    protected $langTypes = [
        'Default', 'DiffUrl'
    ];

    protected $subSiteTypes = [
        'Default', 'DiffUrl'
    ];

    protected $url;         //url text (string)
    protected $parameters;  //url parameters (array)

    public static $languageParameter   = 0;
    public static $subSiteParameter    = 0;
    public static $menuParameter       = 0;


    protected $controller = 'Home';

    public function __construct()
    {
        $this->setParameters();
    }

    public function begin(){
        $this->checkUrl();
        $lc = new LanguageController();
        $lc->set();
        $sc = new SubSiteController();
        $sc->set();
        $mc = new MenuController();
        $mc->set();
    }

    private function checkUrl(){
        $currentDomain = urlencode(URL::to('/'));
        $this->checkUrl .= $currentDomain;
        $response = file_get_contents($this->checkUrl);
        if($response == 1) {
            return true;
        } else if($response == 0){
            abort(500, 'Bu site için kullanım yapılamaz.');
        } else {
            abort(500, 'Teknik bir arızadan dolayı kullanıma aktif değiliz.');
        }
    }

    private function setParameters(){
        $parameters = Route::getCurrentRoute()->parameters();
        $parameters = $parameters['all'];
        $this->url = $parameters;
        if($parameters != '/') {
            $this->parameters = explode('/', rtrim(trim($parameters, '/'), '/'));
        } else {
            $this->parameters = NULL;
        }
    }

}