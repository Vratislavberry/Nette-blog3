<?php
namespace App\Model;

use Nette;
use Nette\Application\UI\Form;
//use App\Model\FormFacade;

final class PostFacade
{
	use Nette\SmartObject;

	private Nette\Database\Explorer $database;
	//private FormFacade $Ffacade;

	public function __construct(Nette\Database\Explorer $database/*, FormFacade $Ffacade*/)
	{
		$this->database = $database;
		//$this->Ffacade = $Ffacade;
	}

	// Vrati celou tabulku posts nejak filtrovane.
	public function getPublicArticles()
	{
		return $this->database
			->table('posts')
			->where('created_at < ', new \DateTime)
			->order('created_at DESC')
			->limit(8);
	}


	// Vrati jeden radek podle $postId a jeho komentare podle ciziho klice
	public function getArticleDetails(int $postId)
	{
        $post = $this->database
            ->table('posts')
			// ziskame radek z tabulky podle $postID
            ->get($postId);
        if (!$post) 
        {
            return [$post];
			//$this->error('Stránka nebyla nalezena');
        }

		return [$post, $post->related('comments')->order('created_at DESC')];
	}

	public function addComment(\stdClass $values): void
    {

        $this->database->table('comments')->insert([
            'post_id' => $values->postId,
            'name' => $values->name,
            'email' => $values->email,
            'content' => $values->content,
        ]);
	}


	

}