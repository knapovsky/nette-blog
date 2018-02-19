<?php

use Nette\Application\UI;
use Nette\Forms\Form;
use App\Model\Articles;
use App\Model\Users;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Article list control
 */
class ArticleListControl extends UI\Control
{
    /*
     * @var dao
     */
    private $daoArticles;

    /*
     * @var integer
     */
    private $firstResult = 0;

    /*
     * @var integer
     */
    private $maxResults = 10;

    /*
     * @var integer
     */
    private $articleCount = 0;

    public function __construct($daoArticles)
    {
        $this->daoArticles = $daoArticles;
        parent::__construct();
    }

    public function render()
    {
        // Create paginator for showing only $this->maxResults
        $dql = "SELECT a FROM \App\Model\Articles a ORDER BY a.updatedDate DESC";
        $query = $this->daoArticles->createQuery($dql)
            ->setFirstResult($this->firstResult)
            ->setMaxResults($this->maxResults);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $c = count($paginator);
        $this->template->articles = $paginator;
        $this->articleCount = $c;
        $this->template->articleCount = $this->articleCount;

        // If this is the first run, set it to 0
        if($this->firstResult == 0){
            $this->template->firstResult = 0;
            $this->template->offset = $this->firstResult;
        }

        // Render component
        $template = $this->template;
        $template->render(__DIR__ . '/ArticleList.latte');
    }

    /**
     * Handle AJAX requests for showing older articles
     * @param $offset
     * @param $articleCount
     */
    public function handleOlder($offset, $articleCount){

        if(!(($offset + $this->maxResults) > $articleCount)){
            $this->firstResult = $offset + $this->maxResults;
        } else {
            $this->firstResult = $offset;
        }
        $this->template->offset = $this->firstResult;
        $this->redrawControl('articles');
    }

    /**
     * Handle AJAX requests for showing newer articles
     * @param $offset
     * @param $articleCount
     */
    public function handleNewer($offset, $articleCount){
        $this->firstResult = $offset - $this->maxResults;
        if($this->firstResult < 0){
            $this->firstResult = 0;
        }
        $this->template->offset = $this->firstResult;
        $this->redrawControl('articles');
    }
}


