<?php

namespace app\controllers;

use app\models\Main;
use RedBeanPHP\R;

/** @property Main $model */
class MainController extends AppController
{
    public function indexAction()
    {
        $slides = R::findAll('slider');
        $this->set(compact('slides'));
        /*$names = $this->model->get_names();
        $spec_name = R::getRow('SELECT * FROM name WHERE id = 2');
        $this->setMeta('Главная страница', 'Description...', 'keywords...');
        $this->set(compact('names'));*/
    }
}