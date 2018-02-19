<?php namespace Alnux\NetteBreadCrumb;
/**
 * Class BreadCrumbControl
 *
 * Breadcrumb Component
 * @author David Zadražil <me@davidzadrazil.cz> edit by Leonardo Allende <alnux@ya.ru>
 *
 */

use Nette\Application\UI\Control;

class Breadcrumbs extends Control
{

    /** @var array links */
    public $links = array();

    /**
     * @var Null if it is not declared or string
     */
    private $templateFile = NULL;

    public function customTemplate($template)
    {
        $this->templateFile = $template?$template:__DIR__ . '/Breadcrumbs.latte';
    }

    /**
     * Render function
     */
    public function render()
    {
        $this->customTemplate($this->templateFile);

        $this->template->setFile($this->templateFile);

        $this->template->links = $this->links;
        $this->template->render();
    }

    /**
     * Add link
     *
     * @param $title
     * @param \Nette\Application\UI\Link $link
     * @param null $icon
     */
    public function addLink($title, $link = NULL, $icon = NULL)
    {
        $this->links[md5($title)] = array(
            'title' => $title,
            'link'  => $link,
            'icon'  => $icon
        );
    }

    /**
     * Remove link
     *
     * @param $key
     *
     * @throws Exception
     */
    public function removeLink($key)
    {
        $key = md5($key);
        if(array_key_exists($key, $this->links))
        {
            unset($this->links[$key]);
        }
        else
        {
            throw new Exception("Key does not exist.");
        }
    }

    /**
     * Edit link
     * @author Leonardo Allende <alnux@ya.ru>
     * @param $title
     * @param \Nette\Application\UI\Link $link
     * @param null $icon
     */
    public function editLink($title, $link = NULL, $icon = NULL)
    {
        if(array_key_exists(md5($title), $this->links))
        {
            $this->addLink($title, $link, $icon);
        }
    }
}