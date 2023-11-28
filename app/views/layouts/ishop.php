<?php

use wfm\View;

/** @var $this View */

$this->getPart('parts/header');

echo $this->content;

$this->getPart('parts/footer');
