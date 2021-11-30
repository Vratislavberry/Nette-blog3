<?php
namespace App\Model;

use Nette;
use Nette\Application\UI\Form;

final class PostFacade
{
	use Nette\SmartObject;

	private Nette\Database\Explorer $database;

	public function __construct(Nette\Database\Explorer $database)
	{
		$this->database = $database;
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
            $this->error('Stránka nebyla nalezena');
        }

		return [$post, $post->related('comments')->order('created_at DESC')];
	}



	

}