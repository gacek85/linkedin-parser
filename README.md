Parser tool for LinkedIn public profiles
===

Simple parser service that reads and scraps LinkedIn profile page HTML. In default configuration, contains a sample command that takes an existing **html file** path and outputs the content to given **CSV** file


Run
---
Then a simple command line command needs to be ran. The input csv file should contain a column of profile links.

``` bash

$ php console.php linkedin:crawl-file:csv /path/to/input-profile-file.html /path/to/output-file.csv

```

Useful tools
---
The `Gacek85\LinkedInCrawler\Parser\LinkedInDocumentParser` itself is a standalone tool for parsing the LinkedIn profiles in **current form** - at the point of writing the lib. It takes one string parameter `$html` and returns an instance of `Gacek85\LinkedInCrawler\Parser\LinkedInEntry`.

``` php
<?php

$parser = new \Gacek85\LinkedInCrawler\Parser\LinkedInDocumentParser();
$html = file_get_contents('./path/to/file.html');

/* @var $output \Gacek85\LinkedInCrawler\Parser\LinkedInEntry */
$output = $parser->parse($html);
```