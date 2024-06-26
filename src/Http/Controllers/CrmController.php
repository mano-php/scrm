<?php

namespace Mano\Crm\Http\Controllers;

use Slowlyo\OwlAdmin\Controllers\AdminController;

class CrmController extends AdminController
{
    public function index()
    {
        $page = $this->basePage()->body('Crm Extension.');

        return $this->response()->success($page);
    }
}
