<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PostFacade;
use App\Model\FormFacade;

final class PostPresenter extends Nette\Application\UI\Presenter
{
	
    private PostFacade $Pfacade;
    private FormFacade $Ffacade;

    public function __construct(PostFacade $Pfacade, FormFacade $Ffacade)
	{
        // Připojení facade k databazi
		$this->Pfacade = $Pfacade;
        $this->Ffacade = $Ffacade;
	}

    public function renderShow(int $postId): void
	{
        $articleDetails = $this->Pfacade
        ->getArticleDetails($postId);

        if (!isset($articleDetails[1])){
            $this->error('Stránka nebyla nalezena');
        }
        else{

            $this->template->post = $articleDetails[0];

            $this->template->comments = $articleDetails[1];
        }

        
        


    }

    public function createComponentCommentForm()
    {
        return $this->Ffacade->getCommentForm($this->getParameter("postId"));
    }


    public function commentFormSucceeded()
    {
        $postId = $this->getParameter('postId');
        $this->Ffacade->addComment($postId);

        $this->flashMessage('Děkuji za komentář', 'success');
        $this->redirect('this');

    }




}