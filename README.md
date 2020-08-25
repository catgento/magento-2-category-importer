# Magento Category Importer for Magento 2 >= 2.1.x

This is a Magento module which adds a new command to the bin/magento shell to import categories from a CSV file.

It has been copied from https://github.com/macopedia/CategoryImporter, but I've removed the new category attribute 
creation (which is specific for the developer who created the module).

I have also included a custom Magento 1 export shell script (https://gist.github.com/paugnu/2c680ea9f452a5b671e8d3c0f35ca34f) so that you can generate the csv file from your Magento 1 installation.

## Installation
### Composer
```
    composer require catgento/magento-2-category-importer
```
### ZIP file
Download the module and unzip it under the folder app/code/Catgento/CategoryImporter.  

## How to use it

### Create a CSV file with the categories information

Mandatory columns:
```
id
name
parent_id
is_active
is_anchor
include_in_menu
custom_use_parent_settings
description
```
Optional columns:
```
meta_title
meta_keywords
meta_description
url_key
url_path
```

You can also add custom columns and specify them when calling the script.

#### Magento 1 shell script to export the Categories
Copy the shell script from this gist https://gist.github.com/catgento/2c680ea9f452a5b671e8d3c0f35ca34f (exportCategoriesCsv.php) in the shell/ folder of your Magento 1 installation. 
You only need to execute it from inside that folder and put the output inside csv file like this:
```
php exportCategoriesCsv.php > categories_m1.csv
```

Note:
* This script replaces '"' by '«' and '»'. There are better ways, but I preferred doing it that way to avoid
scaping issues.

### Import the CSV file in Magento 2

As explained in the Macomedia module, you can use this module by:
```
bin/magento import:categories [--path|-p <path to file in Magento dir>] [--additional|-a <additional attributes separated by comma>]
bin/magento import:categories -p var/import/categories-example.csv 	
bin/magento import:categories -p var/import/categories-example.csv -a my_custom_attribute1,my_custom_attribute2,my_custom_attribute3
```
