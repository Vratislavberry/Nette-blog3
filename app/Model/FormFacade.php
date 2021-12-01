<?php
namespace App\Model;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PostFacade;

final class FormFacade
{
	use Nette\SmartObject;

	private Nette\Database\Explorer $database;
    private int $postId;
    private PostFacade $Pfacade;


	public function __construct(Nette\Database\Explorer $database, PostFacade $Pfacade)
	{
		$this->database = $database;
        $this->Pfacade = $Pfacade;
	}


    public function getCommentForm(int $postId): Form
    {
        $form = new Form; // means Nette\Application\UI\Form
    
        $form->addText('name', 'Jméno:')
            ->setRequired();
    
        $form->addEmail('email', 'E-mail:');
    
        $form->addTextArea('content', 'Komentář:')
            ->setRequired();
    
        $form->addSubmit('send', 'Publikovat komentář');

        
        $form->addHidden('postId', $postId);

        

        $form->onSuccess[] = [$this->Pfacade, 'addComment'];
    
        return $form;
    }



    public function getNewArticleForm(int $postId = 0): Form
    {
        $form = new Form;
        $form->addText('title', 'Titulek:')
            ->setRequired();
        $form->addTextArea('content', 'Obsah:')
            ->setRequired();

        $form->addSubmit('send', 'Uložit a publikovat');


       $form->addHidden('postId', $postId);


        $form->onSuccess[] = [$this->Pfacade, 'addArticle'];


        return $form;
    }





}