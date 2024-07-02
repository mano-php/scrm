<?php

namespace Mano\Scrm\Http\Controllers;

use Slowlyo\OwlAdmin\Controllers\AdminController;

class ScrmController extends AdminController
{
    public function index()
    {
        $page = $this->basePage()->body('Crm Extension.');

        return $this->response()->success($page);
    }
}
