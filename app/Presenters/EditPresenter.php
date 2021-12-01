<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PostFacade;
use App\Model\FormFacade;

final class EditPresenter extends Nette\Application\UI\Presenter
{
    //private Nette\Database\Explorer $database;
    private PostFacade $Pfacade;
    private FormFacade $Ffacade;

	public function __construct(PostFacade $Pfacade, FormFacade $Ffacade)
	{
        // Připojení facade k databazi

		//$this->database = $database;
        $this->Pfacade = $Pfacade;
        $this->Ffacade = $Ffacade;

	}



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


    public function startup(): void
    {
        parent::startup();
    
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }
    



}