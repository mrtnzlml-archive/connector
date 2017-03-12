<?php declare(strict_types = 1);

namespace Adeira\Connector\Document\DomainModel;

use Ramsey\Uuid\{
	Uuid, UuidInterface
};

final class Article
{

	private $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var NULL|\DateTimeImmutable
	 */
	private $publicationDate = NULL;

	/**
	 * @var bool
	 */
	private $isPublished = FALSE;

	private function __construct()
	{
		$this->id = Uuid::uuid4();
	}

	public static function prepare(string $title, string $content): self
	{
		$article = new self;
		$article->title = $title;
		$article->content = $content;
		return $article;
	}

	public function publish(\DateTimeImmutable $dateOfPublication)
	{
		$this->publicationDate = $dateOfPublication;
		$this->isPublished = TRUE;
	}

	public function id(): UuidInterface
	{
		return $this->id;
	}

	public function title(): string
	{
		return $this->title;
	}

	public function content(): string
	{
		return $this->content;
	}

	public function publicationDate(): ?\DateTimeImmutable
	{
		return $this->publicationDate;
	}

	public function isPublished(): bool
	{
		return $this->isPublished;
	}

}
