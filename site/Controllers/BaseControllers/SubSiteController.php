<?php

namespace Softion\Site\Controllers\BaseControllers;

use Softion\Site\Controllers\PathFinderController;
use Softion\Site\Models\BaseModels\Setting;
use Softion\Site\Models\BaseModels\SubSite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SubSiteController extends PathFinderController
{
    //subSite variable name on session
    public $subSiteVariable = 'site';

    //default SubSite type
    protected $subSiteType = 'Default';

    //main site id
    public $defaultSubSite = 99;

    //which sequence of parameters
    public $ssParameter = 1;

    public function set()
    {
        $this->ssParameter = PathFinderController::$subSiteParameter;
        if (isset($this->parameters[$this->ssParameter]) && SubSite::num() > 0) {
            $arr = Setting::get('subSiteType');
            if ($arr) {
                $subSiteType = $arr['value'];
                if (in_array($subSiteType, $this->subSiteTypes)) {
                    $this->subSiteType = $subSiteType;
                }
            }
            $function = 'set' . $this->subSiteType;
            $this->$function();
        } else {
            $this->setSubSiteToDefault();
        }
    }

    //set SubSite for "default" type
    private function setDefault()
    {
        $have = SubSite::get($this->parameters[$this->ssParameter]);
        if ($have) {
            $this->increaseOtherParameters();
            Session::put($this->subSiteVariable, $have->id);
        } else {
            $this->setSubSiteToDefault();
        }
    }

    //set SubSite for "different url" type
    private function setDiffUrl()
    {
        $have = SubSite::get(URL::to('/'), 'url');
        if ($have) {
            Session::put($this->subSiteVariable, $have->id);
        } else {
            $this->setSubSiteToDefault();
        }
    }

    //set SubSite to default SubSite
    private function setSubSiteToDefault()
    {
        Session::put($this->subSiteVariable, $this->defaultSubSite);
    }

    private function increaseOtherParameters()
    {
        ++PathFinderController::$menuParameter;
    }
}