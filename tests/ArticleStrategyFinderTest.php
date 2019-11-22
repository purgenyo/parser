<?php


use PHPUnit\Framework\TestCase;
use Website\HtmlParser\Rbc\ArticleStrategyFinder;
use Website\HtmlParser\Rbc\RbcArticle;

class ArticleStrategyFinderTest extends TestCase
{

    public function testStub()
    {
        $strategy_1 = $this->createMock(RbcArticle::class);
        $strategy_2 = $this->createMock(RbcArticle::class);

        // Configure the stub.
        $strategy_1->method('isArticle')->willReturn(true);
        $strategy_2->method('isArticle')->willReturn(false);

        $strategy_list = [$strategy_2, $strategy_1];
        $find_strategy = new ArticleStrategyFinder($strategy_list);
        $strategy = $find_strategy->findStrategy('content');
        $this->assertTrue($strategy->isArticle('content'));

        $strategy_list = [$strategy_2];
        $find_strategy = new ArticleStrategyFinder($strategy_list);
        $strategy = $find_strategy->findStrategy('content');
        $this->assertNull($strategy);
    }

}