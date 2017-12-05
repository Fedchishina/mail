<?php

namespace App\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

}