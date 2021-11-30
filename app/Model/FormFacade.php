<?php
namespace App\Model;

use Nette;
use Nette\Application\UI\Form;

final class FormFacade
{
	use Nette\SmartObject;

	private Nette\Database\Explorer $database;
    private int $postId;

	public function __construct(Nette\Database\Explorer $database)
	{
		$this->database = $database;
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


        $this->postId = $postId;

        $form->onSuccess[] = [$this, 'addComment'];
    
        return $form;
    }
	
	public function addComment(\stdClass $values): void
    {

        $this->database->table('comments')->insert([
            'post_id' => $this->postId,
            'name' => $values->name,
            'email' => $values->email,
            'content' => $values->content,
        ]);
	}

}