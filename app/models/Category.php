<?php

namespace app\models;

use RedBeanPHP\R;
use wfm\App;

class Category extends AppModel
{
    public function get_category($slug, $lang): array
    {
        return R::getRow("SELECT c.*, cd.* FROM category c JOIN category_description cd on c.id = cd.category_id WHERE c.slug = ? AND cd.language_id = ?", [$slug, $lang['id']]);
    }

    public function getIds($id): string
    {
        $lang = App::$app->getProperty('language')['code'];
        $categories = App::$app->getProperty("categories_{$lang}");
        $ids = '';

        foreach ($categories as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }

        return $ids;
    }

    public function getProducts($ids, $lang, $start, $perPage): array
    {
        $sortValues = [
            'title_asc' => 'ORDER BY title ASC',
            'title_desc' => 'ORDER BY title DESC',
            'price_asc' => 'ORDER BY price ASC',
            'price_desc' => 'ORDER BY price DESC',
        ];

        if (isset($_GET['sort']) && array_key_exists($_GET['sort'], $sortValues)) {
            $order_by = $sortValues[$_GET['sort']];
        } else {
            $order_by = '';
        }

        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND p.category_id IN ($ids) AND pd.language_id = ? $order_by LIMIT $start, $perPage", [$lang['id']]);
    }

    public function get_count_products($ids): int
    {
        return R::count('product', "category_id IN ($ids) AND status = 1");
    }
}
