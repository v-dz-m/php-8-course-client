<?php

namespace app\controllers;

class PageController
{
    public function viewAction()
    {
        echo "Вы находись здесь: ";
        echo __METHOD__;
    }
}