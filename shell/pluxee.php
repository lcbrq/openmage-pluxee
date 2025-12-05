<?php

require_once 'abstract.php';

class LCB_Pluxee_Shell extends Mage_Shell_Abstract
{
    /**
     * Run command against given action
     *
     * @return void
     */
    public function run()
    {
        $api = Mage::getModel('lcb_pluxee/api');

        $api->login();

        $categories = $api->getCategories();
        foreach ($categories as $categoryData) {
            $category = Mage::getModel('lcb_pluxee/category')->load($categoryData['id'], 'category_id');

            $category->setCategoryId($categoryData['id']);
            unset($categoryData['id']);
            $category->addData($categoryData);
            $category->save();

            $products = $api->getProducts($category->getCategoryId());

            foreach ($products as $productData) {
                $product = Mage::getModel('lcb_pluxee/product')->load($productData['id'], 'product_id');
                $product->setProductId($productData['id']);
                unset($productData['id']);
                $product->addData($productData);
                foreach ($productData['references'] as $reference) {
                    $product->setReferenceId($reference['id']);
                    $product->setSku($reference['sku']);
                    $product->setPrice($reference['price']['grand_total']);
                }
                foreach ($productData['pictures'] as $picture) {
                    $product->setPicture($picture['path']);
                }
                $product->save();

                $this->output(sprintf("Imported product %s", $product->getLabel()));
            }
        }

        $api->logout();
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
    Usage:  php pluxee.php
USAGE;
    }

    /**
     * Print output
     *
     * @param string $message
     */
    public function output($message)
    {
        echo "$message\n";
    }
}

$shell = new LCB_Pluxee_Shell();
$shell->run();
