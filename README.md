# PHP Library for newsapi.org
This library is designed to run well on codeigniter 3. But it should run well on native PHP too.
## How To Use
### Codeigniter
1. Extract library to /application/libraries
2. Load library into your project
```php
$this->load->library('news_reader');
```
3. Do action
```php
$this->news_reader->[method_name]([param]);
```
> api key is saved on codeigniter config file with item name '**api_key**', or can be pased through library loader or '**setApiKey**' method

### Native PHP
1. Extract to your project directory
2. Load library
```php
require('News_reader.php');
$param['api_key']='your newsapi.org api_key';
$news_reader=new News_reader($param);
```
3. Do action
```php
$news_reader->[method_name]([param]);
```
## Method Available
* setApiKey ( [api_key] ) :
  Rewrite api key on the library
* getApiKey :
  Return current used api key
* getNews( [endpoint], [array of parameter]) :
  * endpoint available: top-headlines,everything,sources
  * parameter: country,category,sources,q,pageSize,page.
  > Note: Read more abaut endpoint and parameter availability on [News API Documentation page](https://newsapi.org/docs/endpoints)
* results :
  Return success results of getNews method
* error :
  Return array of error information from invalid getNews command
* articles :
  Return list of articles from getNews command
