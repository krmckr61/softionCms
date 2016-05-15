<?php

namespace Softion\Site\Controllers\ModulesControllers\NotFound;

use App\Http\Controllers\Controller;

class NotFoundController extends Controller {

    public function index(){
        return View('NotFound',$arr = ['message' => 'Aradığınız sayfaya şu anda ulaşılamıyor.']);
    }

}