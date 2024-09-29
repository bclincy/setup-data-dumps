
[![goodtables.io](https://goodtables.io/badge/github/datasets/country-codes.svg)](https://goodtables.io/github/datasets/country-codes)

# Purpose
I've developed a streamlined project setup tool that automates the population of essential data,
 such as states and board member titles, and city and zipcodes into your database. This tool leverages GitHub for easy version control and distribution. Originally written in PHP, it can be adapted to any language that supports JSON and YAML. By utilizing this tool, I've significantly reduce the time spent on initial project setup, my hopes is it will help you too.

# Start Up Data for Projects.

If resources are outdated you can update the sources with process.php script. Updating sources you will need to have:
* [PHP](https://php.net/download) command line installed
* PHP's Package Manager [Composer](https://getcomposer.org/download) 


Make any edit to sources and in the terminal run the script:

```bash 
composer install

php process.php
```

### Using the Data

You can download the repo or the dataset you want to use. If you want to use the JSON version of the states and countries you can click on the file in the repo download the raw data.

I consume it via a URL inside of my programming using both using YAML, I've included the file in my project.

### Help

Please feel free to create a pull request. Fork the repo and make your changes and submit a pull request.

## Shoutouts!

Without these folks I couldn't make this happen without these people's code. Thank you! Don't know how much work they've saved me.

* [dataSets](https://github.com/datasets/country-codes) Country Codes
* [Pbojinov](https://gist.github.com/pbojinov/a87adf559d2f7e81d86ae67e7bd883c7) Canadian Provinces
* [Scpike](https://github.com/scpike/us-state-county-zip) Zipcodes
