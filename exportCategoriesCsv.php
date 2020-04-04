<?php
/**
 * This is a shell script that has to be placed in a Magento 1 shell/ directory
 * It outputs the category information
 *
 * @category    Mage
 * @package     Mage_Shell
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once 'abstract.php';

/**
 * Magento Categories Export
 *
 * @category    Mage
 * @package     Mage_Shell
 */
class Mage_Shell_Categories_Export extends Mage_Shell_Abstract
{
    protected $categoryAttributes = [
        'id',
        'name',
        'parent_id',
        'is_active',
        'is_anchor',
        'include_in_menu',
        'custom_use_parent_settings',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'url_key',
        'url_path',
        'position'
    ];

    protected $customCategoryAttributes = [
        //'thumbnail',
        //'seo_titleh1'
    ];

    /**
     * Run script
     *
     */
    public function run()
    {
        $categories = Mage::getModel('catalog/category')->getCollection();

        echo $this->printRowTitles();

        foreach ($categories as $category) {
            $line = '';
            $category->load();
            foreach ($this->categoryAttributes as $categoryAttribute) {
                if ($categoryAttribute == 'id') {
                    $categoryAttribute = 'entity_id';
                }
                $value = str_replace(' "', '«', $category->getData($categoryAttribute));
                $value = str_replace('" ', '»', $value);
                $value = str_replace('"', "'", $value);

                if ($categoryAttribute == 'parent_id' && $value == '1') {
                    $value = '0';
                }

                $line .= '"' . $value . '";';
            }

            if (count($this->customCategoryAttributes) > 0) {
                foreach ($this->customCategoryAttributes as $customCategoryAttribute) {
                    $line .= '"' . $category->getData($customCategoryAttribute) . '";';
                }
            }

            $line = substr($line, 0, -1);
            echo $line . "\n";
        }
    }

    /**
     * Return First Row
     *
     * @return string
     */
    public function printRowTitles()
    {
        $line = '';
        foreach ($this->categoryAttributes as $attribute) {
            $line .= '"' . $attribute . '";';
        }
        $line = substr($line, 0, -1);

        return $line . "\n";
    }
}

$shell = new Mage_Shell_Categories_Export();
$shell->run();
