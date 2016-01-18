## Synopsis

The Scraper Script - I used this for parsing html content and stored the content I parsed to a Custom Post Type I created in wordpress.

This is for the purpose of data entry which I made the scraper script out of the simple_html_dom.php parser which is available online here:http://simplehtmldom.sourceforge.net/

html_content.php - contains the HTML content.
simple_html_dom.php - the PHP5+ parser that S.C. Chen Created
index.php - the scraper script I created to make my life easier *smiley*

## Motivation

What made me create this scraper was the long list of data that I had to get from another website based on an html file which I had no server access to. 

## Installation

This is for external use so whenever you want to use this you must put it inside the wordpress root directory but --CAUTION-- before pasting/uploading them under your wordpress root directory kindly rename the index.php to something else so it won't replace your index.php file. or you can just past the whole "scraper" folder under the wordpress root directory.

I think it was because I had no time to think why it triggers a "Not found page" in wordpress when I access http://site.com/scraper maybe because of its .htaccess or index so I decided to put the scraper.php(before index.php) outside under the wordpress root directory also the get_html folder.

## Questions
Contact me via email: kampaysaylo[at]gmail[dot]com

## License

I only take ownership of the code I made, but not simple_html_dom.php
Credits to(Simple HTML Dom parser): 
Author: S.C. Chen (me578022@gmail.com)
Original idea is from Jose Solorzano's HTML Parser for PHP 4. 
Contributions by: Yousuke Kumakura, Vadim Voituk, Antcs