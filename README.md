### usage examples:

###### Get aricle list:

```
$article_list = new GuzzleRbcArticleList;
$list = $processor->getArticleList();
```

###### Get article by content:
```
$article = new RbcArticle;
$is_article = $article->isArticle(<article content>);
$article_item = $article->getArticle(<article content>);
```