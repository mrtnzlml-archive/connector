<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Document\DomainModel;

use Adeira\Connector\Document\DomainModel\Article;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class ArticleTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatPrepareReturnsInstanceOfArticle()
	{
		Assert::type(Article::class, Article::prepare('title', 'content'));
	}

	public function testThatPublishWorks()
	{
		$article = Article::prepare('title', 'content');
		Assert::false($article->isPublished());
		Assert::null($article->publicationDate());
		$article->publish(new \DateTimeImmutable('2017-03-07'));
		Assert::true($article->isPublished());
		Assert::equal(new \DateTimeImmutable('2017-03-07'), $article->publicationDate());
	}

	public function testThatTitleWorks()
	{
		$article = Article::prepare('title', 'content');
		Assert::same('title', $article->title());
	}

	public function testThatContentWorks()
	{
		$article = Article::prepare('title', 'content');
		Assert::same('content', $article->content());
	}

}

(new ArticleTest)->run();
