<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Model\PostFacade;
use App\Model\FormFacade;
use App\Components\ICommentFormFactory;
use App\Components\CommentForm;
use Nette;

final class PostPresenter extends Presenter
{
	
    private PostFacade $Pfacade;
    private FormFacade $Ffacade;

    private ICommentFormFactory $commentFormFactory;

    public function __construct(
        PostFacade $Pfacade, 
        FormFacade $Ffacade, 
        ICommentFormFactory $commentFormFactory
        )
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
        /** var CommentForm $service */
    $service = $this->commentFormFactory->create($this->getParameter("postId"),$this->myCallback());
        /*$service->onSuccess = function(){
            $this->presenter->redirect('Default:default');
        };*/
        
        //$service->getComponent('form');

        
        return $service;
        
        

        //return $this->Ffacade->getCommentForm($this->getParameter("postId"));
        /*$temp = $this->Ffacade->getCommentForm($this->getParameter("postId"));
        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Post:show', $post->id);
        return $temp;*/
    }

    public function myCallback(): callable
    {
        return function(Form $form, $values) {
        
            \Tracy\Debugger::barDump($form);
            \Tracy\Debugger::barDump($values);
            $this->Pfacade->addComment($values);
            $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
            $this->redirect('Post:show', $values->postId);
            
        };
    }

}
// Interface = šablona pro třídy
;;