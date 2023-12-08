<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use wfm\App;
use wfm\Pagination;

/** @property Category $model*/
class CategoryController extends AppController
{
    public function viewAction()
    {
        $lang = App::$app->getProperty('language');
        $category = $this->model->get_category($this->route['slug'], $lang);

        if (!$category) {
            $this->error_404();
            return;
        }

        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category['id']);
        $ids = $this->model->getIds($category['id']);
        $ids = !$ids ? $category['id'] : $ids . $category['id'];

        $page = abs(get('page')) ?: 1;
        $perPage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_products($ids);
        $pagination = new Pagination($page, $perPage, $total);
        $start = $pagination->getStart();

        $products = $this->model->getProducts($ids, $lang, $start, $perPage);
        $this->setMeta($category['title'], $category['description'], $category['keywords']);
        $this->set(compact('products', 'category', 'breadcrumbs', 'total', 'pagination'));
    }
}
