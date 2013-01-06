SphinxSearch
============

## Installation

Add in your composer.json:

```js
{
    "require": {
        "ask/sphinx-search": "dev-master"
    },
    "repositories": {
        "ask/sphinx-search": {
            "type": "vcs",
            "url": "git://github.com/A-S-Kozienko/SphinxSearch.git"
        },
        "googlecode/sphinxsearch":  {
            "type": "package",
            "package": {
                "name": "googlecode/sphinxsearch",
                "version": "2.0.0",
                "source": {
                    "url": "http://sphinxsearch.googlecode.com/svn/",
                    "type": "svn",
                    "reference": "branches/rel20"
                },
                "autoload": {
                    "classmap": ["api/sphinxapi.php"]
                }
            }
        }
    }
}
```

and run the command

```sh
$ php composer.phar update ask/sphinx-search
```

## Basic usage

```php
$client = new \SphinxClient();
$manager = new SphinxManager($client);

$query = $manager->createQuery(array(
    'index_main',
    'index_delta',
));

$query
    ->addMatch('hello :placeholder')
    ->setMatchParameter('placeholder', 'word')
;

$result = $query->execute();
```

## Aliases

Aliases useful for different environments.

```php
$client = new \SphinxClient();

$env_dev = array(
    'MainAlias' => 'index_main_dev',
);

$env_prod = array(
    'MainAlias' => 'index_main_prod',
);

$manager = new SphinxManager($client, $env_dev); // or $env_prod

$query = $manager->createQuery(array(
    'MainAlias',
    'index_delta',
));
```

## Pagination

For pagination you need additional lib [Pagerfanta](https://github.com/whiteoctober/Pagerfanta)

```php
$client = new \SphinxClient();
$manager = new SphinxManager($client);

$query = $manager->createQuery(array(
    'index_main',
    'index_delta',
));

$adapter = new SphinxAdapter($query);
$pager = new \Pagerfanta\Pagerfanta($adapter);
$pager->setMaxPerPage(15);
$pager->setCurrentPage(1);

$result = $pager->getCurrentPageResults();
```
