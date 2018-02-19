<?php

use Nette\Application\UI;

/**
 * Article list control
 */
class ArticleJumboControl extends UI\Control
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $template = $this->template;
        $template->render(__DIR__ . '/ArticleJumbo.latte');
    }
}