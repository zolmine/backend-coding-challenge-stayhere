Technical challenge Stayhere
========

## project installation
* install dependencies `composer install`
* run `php artisan serve`

## Description

A trainee created the code in the app/Controllers/HomeController.php.

This controller retrieves content from an RSS feed and call a news api. The result is filtered to fetch those containing images and verify if aren't duplicated.
This script should get an image from each page.

The lead developer is not satisfied by this result, so you need to improve it.

## Questions:
1. What do you suggest improving the run time of this script?
2. How can we make this script scalable (make it support thousands of image sources)


## Answers :
1. here is some suggestions to improve the run time of this script
    * Optimize the RSS feed retrieval: Depending on the size of the RSS feed, it may take a significant amount of time to retrieve and parse the feed. Consider using a library that can efficiently retrieve and parse the RSS feed, such as feedparser.
    * Parallelizing computationally expensive tasks.
    * Caching intermediate results
    * Using built-in library functions instead of writing custom implementations.
    * Avoid duplicates: To avoid duplicates, you could create a hash table to store the URLs of the images that have already been processed and check against this table before retrieving an image.

2. How can we make this script scalable (make it support thousands of image sources)
    * by using a queue, a queue can be used to store the URLs of the image sources that need to be processed. The script can then retrieve URLs from the queue and process them in parallel
    * by using a load balancer, load balancer can be used to distribute incoming requests to multiple machines running the script, which can help to reduce the load on a single machine and increase scalability.


## Resources
https://refactoring.guru/
https://refactoring.com/catalog/
