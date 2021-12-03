<?php

namespace App\Components\CommentForm;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class CommentForm extends Control //implements ICommentFormFactory
{
    private ?int $id;
    private $callback;

    public function __construct(?int $id, ?callable $callback)
    {
        $this->id = $id;
        $this->callback = $callback;
    }

    public function createComponentForm()  
    {
        $form = new Form; // means Nette\Application\UI\Form
    
        $form->addText('name', 'Jméno:')
            ->setRequired();
    
        $form->addEmail('email', 'E-mail:');
    
        $form->addTextArea('content', 'Komentář:')
            ->setRequired();
    
        $form->addSubmit('send', 'Publikovat komentář');

        
        $form->addHidden('postId', $this->id);
        
        //call_user_func('callback');o
        $form->onSuccess = [$this->callback];
    
        return $form;
    }

    public function render($params = [ ]) 
    {
        $this->template->setFile(__DIR__ . '/CommentForm.latte');
        $this->template->render();
    }

}

interface ICommentFormFactory
{
    public function create(?int $id, ?callable $callback): CommentForm;
}