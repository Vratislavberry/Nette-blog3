<?php

class ComponentForm extends Control implements ICommentFormFactory
{

    private ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
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

        
        $form->addHidden('postId', $postId);
        

        $form->onSuccess[] = [$this->Pfacade, 'addComment'];
    
        return $form;
    }
}

interface IComponentFormFactory
{
    public function create(?int $id): CommentForm;
}