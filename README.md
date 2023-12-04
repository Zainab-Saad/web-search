# Web Search
This repository includes code for a Web Crawler and a Search Engine.

## Features

### Web Crawler
The web crawler systematically explores the internet and collects information from various websites.

### Search Engine
The search engine locates web pages containing information specified by the user's query.

### Ethical Web Crawling
Adheres to ethical web programming practices by crawling only URLs permitted in the robots.txt file.

## Technologies/Tools
- HTML5
- CSS3
- PHP 8.1.25
- PostgreSQL v12
- XAMPP Server

## Implementation Details
- Web Crawler starts with a seed URL
- A queue is maintained to keep track of which URLs have been crawled and thus prevents requesting the same URLs
- For each URL, it is checked based on a user-defined function whether the `robots.txt` file in the root directory of the website allows crawling the URL or not.
- **cURL** - stands for 'Client for URLs', a command line tool for sending or receiving files using URLs over HTTP/s or FTP.
- **DomDocument** utility is used to parse the HTML document, extract the links 
- Crawler then recursively takes each of these URLs and repeats the same process for each URL till a certain **depth**

- **PostgreSQL Full Text Search** functionality is used for the search engine where the input query is matched against the auto-generated columns of type tsvector in the db. Further explained in next point
- Each of the URL visited is stored in the postgres db with the following schema
```
        -- URL (TEXT) (primary key)

        -- title (TEXT)

        -- content (TEXT) 

        -- updated_on (timestamp)
        
        -- search_content (tsvector)
```
- updated_on field would help the crawler refresh the content i.e; recrawl certain URLs
- title and text content of the page is stored in the fields that help in returning the contents of the page whenever a search query returns a particular URL, thus needing not to request same URLs again
- search_content is an auto-generated column of type tsvector that stores the 'content' in tsvector that is a sorted list of distinct lexemes (which are the normalized/base form of a word), which are words that have been normalized to merge different variants of the same word.
Sorting and duplicate-elimination is done automatically on input.

- Upon a search query, the input query string is converted to tsquery - a data type that stores lexemes that are to be searched for.
- All the web pages containing a certain query string are returned as search results

- Integrated logging functionality using Monolog, a powerful logging library for PHP.

## Project Dependencies

**Monolog** - the default logging library for PHP.

**Dotenv** - a library that helps manage environment variables in PHP

## Getting Started

### Note:
You should have PHP, XAMPP server and PostgreSQL version  12+ installed

- Navigate to \htdocs folder and clone the repository
```
cd C:\xampp\htdocs
git clone https://github.com/Zainab-Saad/web-search
```

- Install the various composer dependencies used in the project
```
composer install
```

- Create a .env file that would contain the host, username, database name and the password

- Run XAMPP server

- In your browser, type 
```
http://localhost/web-crawler/index.php
```

## References

- [Text Search Types](https://www.postgresql.org/docs/current/datatype-textsearch.html)
- [Postgres Full-Text Search: A Search Engine in a Database](https://www.crunchydata.com/blog/postgres-full-text-search-a-search-engine-in-a-database)