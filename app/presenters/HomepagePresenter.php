<?php

namespace App\Presenters;

use App\Model\Articles;
use Kdyby;
/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
    public function renderDefault()
    {
        $this->redrawControl();
    }

    protected function createComponentArticleJumbo()
    {
        $component = new \ArticleJumboControl();
        $component->redrawControl();
        return $component;
    }

    protected function createComponentArticleHighlight()
    {
        $component = new \ArticleHighlightControl();
        $component->redrawControl();
        return $component;
    }

    protected function createComponentArticleList()
    {
        // Sadly, there is no Doctrine DI for classes other than Presenters
        // Sending the repository forward
        $daoArticles = $this->EntityManager->getRepository(Articles::getClassName());
        $component = new \ArticleListControl($daoArticles);
        $component->redrawControl();
        return $component;
    }
}
?>