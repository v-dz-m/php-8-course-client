<?php

namespace app\widgets\menu;

use wfm\App;
use wfm\Cache;

class Menu
{
    // https://www.youtube.com/watch?v=fOMaYSmsiQU
    // https://www.youtube.com/watch?v=Qble3-723bs
    protected $data;
    protected array $tree;
    protected string $menuHtml;
    protected string $tpl;
    protected string $container = 'ul';
    protected string $class = 'menu';
    protected int $cache = 3600;
    protected string $cacheKey = 'ishop_menu';
    protected array $attrs = [];
    protected string $prepend = '';
    protected mixed $language;

    public function __construct($options = [])
    {
        $this->language = App::$app->getProperty('language');
        $this->tpl = __DIR__ . '/menu_tpl.php';
        $this->getOptions($options);
        $this->run();
    }

    protected function getOptions($options): void
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    protected function run(): void
    {
        $cache = Cache::getInstance();
        $this->menuHtml = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if (!$this->menuHtml) {
            /*$this->data = R::getAssoc("SELECT c.*, cd.* FROM category AS c
                        JOIN category_description cd
                        ON c.id = cd.category_id
                        WHERE cd.language_id = ?", [$this->language['id']]);*/

            $this->data = App::$app->getProperty("categories_{$this->language['code']}");
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if ($this->cache) {
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuHtml, $this->cache);
            }
        }

        $this->output();
    }

    protected function output(): void
    {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " $k='$v' ";
            }
        }
        echo "<{$this->container} class='{$this->class}' $attrs>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function getTree(): array
    {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['children'][$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''): string
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab, $id): bool|string
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

}