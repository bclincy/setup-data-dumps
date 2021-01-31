[![goodtables.io](https://goodtables.io/badge/github/datasets/country-codes.svg)](https://goodtables.io/github/datasets/country-codes)

# Start Up Data for Projects.

I have composed this repo to populate apps setup data. A list of states and country in one YAML. I got the information and translated in process.php

### Using the Data

You can download the repo or the dataset you want to use. If you want to use the JSON version of the states and countries you can click on the file in the repo download the raw data.

I consume it via a URL inside of my programming using both using YAML, I've included the file in my project.

### Help

Please feel free to create a pull request. Fork the repo and make your changes and submit a pull request.

### Running new Dataset

The PHP process will use repos and outside sources to rebuild files. You'll need the package Manager [Composer](http://getcomposer.org)
On the bash or terminal:
```bash 
composer install
php process.php
```

## Shoutouts!

Without these folks I couldn't make this happen without these people's code. Thank you! Don't know how much work they've saved me.

* [dataSets](https://github.com/datasets/country-codes) Country Codes
* [Pbojinov](https://gist.github.com/pbojinov/a87adf559d2f7e81d86ae67e7bd883c7) Canadian Provinces
* [Scpike](https://github.com/scpike/us-state-county-zip) Zipcodes
