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

    private ICommentFormFactory $commentFormFactory;

    public function __construct(PostFacade $Pfacade, FormFacade $Ffacade, ICommentFormFactory $commentFormFactory)
	{
        // Připojení facade k databazi
		$this->Pfacade = $Pfacade;
        $this->Ffacade = $Ffacade;

        $this->commentFormFactory = $commentFormFactory;
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

        $service = $this->commentFormFactory->create($this->getParameter("postId"));

        $service['form']->onSuccess[] = function(){
            $this->presenter->redirect('Default:default');
        };
        $service->getComponent('form');

        return $service;


        //return $this->Ffacade->getCommentForm($this->getParameter("postId"));
        /*$temp = $this->Ffacade->getCommentForm($this->getParameter("postId"));
        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Post:show', $post->id);
        return $temp;*/
    }

}
// Interface = šablona pro třídy
