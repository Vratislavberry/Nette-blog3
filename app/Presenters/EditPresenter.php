<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PostFacade;
use App\Model\FormFacade;
use App\Components\NewArticleForm\INewArticleFormFactory;
use App\Components\NewArticleForm\CommentForm;

final class EditPresenter extends Nette\Application\UI\Presenter
{
    //private Nette\Database\Explorer $database;
    private PostFacade $Pfacade;
    private FormFacade $Ffacade;
    private INewArticleFormFactory $newArticleForm;

	public function __construct(PostFacade $Pfacade, FormFacade $Ffacade, INewArticleFormFactory $newArticleForm)
	{
        // Připojení facade k databazi

		//$this->database = $database;
        $this->Pfacade = $Pfacade;
        $this->Ffacade = $Ffacade;
        $this->newArticleForm = $newArticleForm;

	}

/*

    public function createComponentPostForm(): Form
    {
        $postId = $this->getParameter('postId');
        if (isset($postId))
            return $this->Ffacade->getNewArticleForm($postId);
        else
            return $this->Ffacade->getNewArticleForm();
    }




    public function renderEdit(int $postId): void
    {
        $post = $this->Pfacade->getArticleDetails($postId);

            if (!$post) {
            $this->error('Post not found');
        }
        
        $this->getComponent('postForm')
            ->setDefaults($post[0]);
        
    }
*/

    public function startup(): void
    {
        parent::startup();
    
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }
    

    public function createComponentNewArticleForm()
    {
    $service = $this->newArticleForm->create($this->getParameter("postId"),$this->myCallback());
        
        return $service;
    }

    public function myCallback(): callable
    {
        return function(Form $form, $values) {
        
            \Tracy\Debugger::barDump($form);
            \Tracy\Debugger::barDump($values);
            $this->Pfacade->addArticle($values);
            $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
            $this->redirect('Homepage:');
            //$this->redirect('Post:show', $values->postId);
            
        };
    }

    public function actionEdit($id){
        echo "ahoj";
    }


}