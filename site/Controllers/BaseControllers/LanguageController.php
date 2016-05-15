<?php

namespace Softion\Site\Controllers\BaseControllers;

use Softion\Site\Controllers\PathFinderController;
use Softion\Site\Models\BaseModels\Setting;
use Softion\Site\Models\BaseModels\Language;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LanguageController extends PathFinderController
{
    //lang variable name on session
    public $langVariable = 'lang';

    //default language type
    private $langType = 'Default';

    //mother tongue
    public $defaultLanguage;

    //which sequence of parameters
    public $langParameter;

    public function set()
    {
        $this->langParameter = PathFinderController::$languageParameter;
        $this->setDefaultParameter();
        if (isset($this->parameters[$this->langParameter]) && Language::num() > 0) {
            $arr = Setting::get('langType');
            if ($arr) {
                $langType = $arr['value'];
                if (in_array($langType, $this->langTypes)) {
                    $this->langType = $langType;
                }
            }
            $function = 'set' . $this->langType;
            $this->$function();
        } else {
            $this->setLanguageToDefault();
        }
    }

    //set language for "default" type
    private function setDefault()
    {
        if (strtolower($this->defaultLanguage) == strtolower($this->parameters[$this->langParameter])) {
            unset($this->parameters[$this->langParameter]);
            $redirectUrl = implode('/', $this->parameters) . ((isset($_SERVER['REDIRECT_QUERY_STRING'])) ? '?' . $_SERVER['REDIRECT_QUERY_STRING'] : '');
            echo redirect($redirectUrl);
            exit;
        }
        $have = Language::get($this->parameters[$this->langParameter]);
        if ($have) {
            $this->increaseOtherParameters();
            Session::put($this->langVariable, $have->short);
        } else {
            $this->setLanguageToDefault();
        }
    }

    //set language for "different url" type
    private function setDiffUrl()
    {
        $have = Language::get(URL::to('/'), 'url');
        if ($have) {
            $this->increaseOtherParameters();
            Session::put($this->langVariable, $have->short);
        } else {
            $this->setLanguageToDefault();
        }
    }

    private function setDefaultParameter()
    {
        $arr = Setting::get('defaultLanguage');
        if ($arr) {
            $this->defaultLanguage = $arr->value;
        } else {
            abort(500, 'Sitede anadil bulunamadı.');
        }
    }

    //set language to default language
    private function setLanguageToDefault()
    {
        Session::put($this->langVariable, $this->defaultLanguage);
    }

    private function increaseOtherParameters()
    {
        ++PathFinderController::$subSiteParameter;
        ++PathFinderController::$menuParameter;
    }
}