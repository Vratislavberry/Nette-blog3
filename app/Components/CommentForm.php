<?php

namespace App\Components;

use Nette\Application\UI\Control;


interface IComponentFormFactory
{
    public function create(?int $id): CommentForm;
}

class ComponentForm extends Control


{

    private ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }


    public function create(?int $id): CommentForm
    {
        $form = new Form; // means Nette\Application\UI\Form
    
        $form->addText('name', 'Jméno:')
            ->setRequired();
    
        $form->addEmail('email', 'E-mail:');
    
        $form->addTextArea('content', 'Komentář:')
            ->setRequired();
    
        $form->addSubmit('send', 'Publikovat komentář');

        
        $form->addHidden('postId', $postId);
        

        //$form->onSuccess[] = [$this->Pfacade, 'addComment'];
    
        return $form;
    }
}
