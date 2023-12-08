<?php

namespace app\controllers;

use app\models\Search;
use wfm\App;
use wfm\Pagination;

/** @property Search $model */
class SearchController extends AppController
{
    public function indexAction()
    {
        $s = get('s', 's');
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $total = $this->model->get_count_find_product($s, $lang);
        $perPage = App::$app->getProperty('pagination');
        $pagination = new Pagination($page, $perPage, $total);
        $start = $pagination->getStart();

        $products = $this->model->get_find_products($s, $lang, $start, $perPage);
        $this->setMeta(___('tpl_search_title'));
        $this->set(compact('s', 'products', 'pagination', 'total'));
    }
}