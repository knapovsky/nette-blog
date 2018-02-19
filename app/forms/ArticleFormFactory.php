<?php

namespace App\Forms;

use App\Model\Articles;
use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\Image;

class ArticleFormFactory
{
    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $EntityManager;

    /**
     * @var DAO
     */
    private $daoUsers;

    /**
     * @var DAO
     */
    private $daoArticles;

    /**
     * @var integer
     */
    private $currentUser;

    /**
     * @var integer
     */
    private $articleId;

    /**
     * @var \ImageStorage
     */
    private $imageStorage;

    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;


    public function __construct(FormFactory $factory, \ImageStorage $storage)
    {
        $this->imageStorage = $storage;
        $this->factory = $factory;
    }

    /**
     * @return Form
     */
    public function create($daoArticles, $daoUsers, $currentUser, $articleId, callable $onSuccess)
    {
        /**
         * Saving for callback
         */
        $this->daoArticles = $daoArticles;
        $this->daoUsers = $daoUsers;
        $this->currentUser = $currentUser;
        $this->articleId = $articleId;

        /*
         * Prepare article
         */
        $article = new Articles();
        if($articleId >= 0){
            $article = $daoArticles->find($articleId);
        }
        else {
            $article->title = '';
            $article->user = $daoUsers->find($currentUser);
            $article->perex = '';
            $article->text = '';
            $article->pictureURL = '';
            $article->createdDate = new Nette\Utils\DateTime();
            $article->updatedDate = new Nette\Utils\DateTime();
        }

        /*
         * Create form and fill it
         */
        $form = $this->factory->create();
        $form->addText('title', 'Titulek')
            ->setRequired()
            ->setValue($article->title);
        $form->addHidden('user_id', $article->user->id);
        $form->addTextArea('perex', 'Perex')
            ->setRequired()
            ->setValue($article->perex);
        $form->addTextArea('content', 'Obsah')
            ->setRequired()
            ->setValue($article->text);
        $form->addUpload('picture', 'Obrázek')
            ->setRequired(false)
            ->addRule(Form::IMAGE, 'Obrázek musí být JPEG, PNG nebo GIF.')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 1MB.', 1024*1024);
        $form->addSubmit('send', 'Odeslat');

        /**
         * Register callback
         * @param Form $form
         * @param $values
         * @throws Nette\Utils\UnknownImageFileException
         */
        $form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {

            // Prepare article
            $user = $this->daoUsers->find($this->currentUser);
            $article = new \App\Model\Articles();

            if($this->articleId >= 0){
                $article = $this->daoArticles->find($this->articleId);
            }
            else {
                $user->addArticle($article);
                $article->user = $user;
                $article->createdDate = new Nette\Utils\DateTime();
            }
            $article->updatedDate = new Nette\Utils\DateTime();
            $article->setTitle($values->title);
            $article->setPerex($values->perex);
            $article->setText($values->content);

            // Prepare picture
            if ($values->picture->isImage() and $values->picture->isOk()) {
                //$file = new FileUpload($values->picture);
                $file = $values->picture; //Prehodenie do $file
                $file_name = filter_var($file->name, FILTER_SANITIZE_STRING);
                $file_name = iconv('UTF-8', 'ASCII//TRANSLIT', $file_name);
                $file_name = strtolower(preg_replace('/[^a-zA-Z0-9.]/', '_', $file_name));
                $file->move($this->imageStorage->getDir() . '/' . $file_name );
                $image = Image::fromFile($this->imageStorage->getDir() . '/' . $file_name);
                //$image->resize(128, 128, Image::EXACT);
                //$image->sharpen();
                $image->save($this->imageStorage->getDir() .'/'. $file_name);
                $article->setPictureURL($file_name);
            }

            // Save it all
            $this->daoArticles->save($article);

            $onSuccess();
        };

        return $form;
    }

    /**
     * @param ImageStorage $storage
     */
    public function injectImages(ImageStorage $storage)
    {
        $this->imageStorage = $storage;
    }
}
