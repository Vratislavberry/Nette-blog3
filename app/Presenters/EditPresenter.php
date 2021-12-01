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

/*
    protected function createComponentPostForm(): Form
    {
        $form = new Form;
        $form->addText('title', 'Titulek:')
            ->setRequired();
        $form->addTextArea('content', 'Obsah:')
            ->setRequired();

        $form->addSubmit('send', 'Uložit a publikovat');
        $form->onSuccess[] = [$this, 'postFormSucceeded'];

        return $form;
    }
*/

    public function createComponentPostForm(): Form
    {
        $postId = $this->getParameter('postId');
        if (isset($postId))
            return $this->Ffacade->getNewArticleForm($postId);
        else
            return $this->Ffacade->getNewArticleForm();
    }




/*
    public function postFormSucceeded(array $values): void
    {

        $postId = $this->getParameter('postId');

        if ($postId) {
            $post = $this->database
                ->table('posts')
                ->get($postId);
            $post->update($values);
    
        } else {
            $post = $this->database
                ->table('posts')
                ->insert($values);
        }
    
        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');
        $this->redirect('Post:show', $post->id);


    }

*/









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