<?php
namespace App\Presenters;

use App\Forms\ArticleFormFactory;
use App\Model\Users;
use App\Model\Articles;
use Nette;
use Kdyby;
use Nette\Forms\Form;
use ImageStorage;
use Alnux\NetteBreadCrumb\Breadcrumbs;

class PostPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    /** @var ArticleFormFactory */
    private $articleFormFactory;

    /** @var ImageStorage */
    private $imageStorage;

    /** @var int  */
    private $postId;


    public function __construct(ArticleFormFactory $articleFormFactory)
    {
        $this->articleFormFactory = $articleFormFactory;

        // Undefined constant for postId
        $this->postId = -1;
    }

    /**
     * Show action - showing a detail of a chosen article
     * @param $postId
     */
    public function actionShow($postId)
    {
        // Get data from db
        $daoArticles = $this->EntityManager->getRepository(Articles::getClassName());
        $article = $daoArticles->find($postId);

        // Put the data into template
        $this->template->article = $article;

        // Path for images
        $this->template->imgPath = $this->imageStorage->getDir();

        // Set up breadcrumbs
        $this['breadcrumbs']->addLink($article->title);
    }

    /**
     * Action for editing a chosen article
     * @param $postId
     * @throws Nette\Application\AbortException
     * @throws Nette\Application\UI\InvalidLinkException
     */
    public function actionEdit($postId)
    {
        $this->postId = $postId;

        // Get data from db
        $daoArticle = $this->EntityManager->getRepository(Articles::getClassName());
        $daoUser = $this->EntityManager->getRepository(Users::getClassName());

        // Find article
        $article = $daoArticle->find($postId);

        // Only owner can edit his article
        if($article->user->id == $this->user->id){
            // show edit form
            $this->template->article = $article;
        }
        else {
            $this->flashMessage('Toto není váš článek!');
            $this->redirect('Homepage:');
            // show error form - cannot let you go inside
        }

        // Fill breadcrumbs
        $this['breadcrumbs']->addLink($article->title, $this->link('Post:show', $postId));
        $this['breadcrumbs']->addLink('Editace');
    }

    public function actionAdd()
    {
        //$this->addSample();
        // Fill breadcrumbs
        $this['breadcrumbs']->addLink('Přidat článek');
    }

    /**
     * Deletes an article with a chosen id
     * @param $postId
     * @throws Nette\Application\AbortException
     * @throws \Exception
     */
    public function actionDelete($postId)
    {
        // Get it from db
        $daoArticles = $this->EntityManager->getRepository(Articles::getClassName());
        $article = $daoArticles->find($postId);

        // Remove it
        if($article){
            $this->EntityManager->remove($article);
            $this->EntityManager->flush();
        }

        $this->flashMessage('Zpráva smazána.');
        $this->redirect('Homepage:');
    }

    /**
     * Adds sample articles
     * @throws \Exception
     */
    public function addSample()
    {
        $howManyArticles = 100;
        for ($i = 0; $i < $howManyArticles; $i++)
        {
            $article = new Articles();
            $article->setTitle('Article' . $i);
            $article->setPerex('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris' . rand(1,100));
            $article->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris');
            $daoUser = $this->EntityManager->getRepository(Users::getClassName());
            $user = $daoUser->find($this->user->id);
            $article->setUser($user);
            $article->createdDate = new Nette\Utils\DateTime();
            $article->updatedDate = new Nette\Utils\DateTime();
            $user->addArticle($article);
            $daoArticle = $this->EntityManager->getRepository(Articles::getClassName());
            $daoArticle->save($article);
            $this->EntityManager->flush();
        }
    }

    /**
     * Sign-up form factory.
     * @return Form
     */
    protected function createComponentArticleAddForm()
    {
        $daoArticles = $this->EntityManager->getRepository(Articles::getClassName());
        $daoUsers = $this->EntityManager->getRepository(Users::getClassName());


        return $this->articleFormFactory->create($daoArticles, $daoUsers, $this->user->id, $this->postId, function () {
            $this->redirect('Homepage:');
        });
    }

    /**
     * Sign-up form factory.
     * @return Form
     */
    protected function createComponentArticleEditForm()
    {
        $daoArticles = $this->EntityManager->getRepository(Articles::getClassName());
        $daoUsers = $this->EntityManager->getRepository(Users::getClassName());

        return $this->articleFormFactory->create($daoArticles, $daoUsers, $this->user->id, $this->postId, function () {
            $this->flashMessage('Článek úspěšně upraven.', 'success');
            $this->redirect('Homepage:');
        });
    }

    /**
     * @return Breadcrumbs
     * @throws Nette\Application\UI\InvalidLinkException
     */
    protected function createComponentBreadcrumbs()
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addLink('Úvod', $this->link('Homepage:'), 'icon-homepage');
        return $breadcrumbs;
    }

    /**
     * @param ImageStorage $storage
     */
    public function injectImages(ImageStorage $storage)
    {
        $this->imageStorage = $storage;
    }
}
