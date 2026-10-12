<?php

require_once 'abstract.php';

class LCB_Pluxee_Shell extends Mage_Shell_Abstract
{
    /**
     * @var bool
     */
    protected $update = false;

    /**
     * @var int
     */
    protected $productsForUpdate = 0;

    /**
     * Run command against given action
     *
     * @return void
     */
    public function run()
    {
        $this->update = (bool) $this->getArg('update');

        $api = Mage::getModel('lcb_pluxee/api');
        $api->login();

        $categories = $api->getCategories();
        foreach ($categories as $categoryData) {
            $categoryId = $categoryData['id'];
            unset($categoryData['id']);

            $category = Mage::getModel('lcb_pluxee/category')->load($categoryId, 'category_id');
            $category->setCategoryId($categoryId);
            $category->addData($categoryData);
            $category->save();

            $products = $api->getProducts(['category_id' => $categoryId]);

            foreach ($products as $productData) {
                $this->importProduct($productData, $categoryId);
            }
        }

        $brands = $api->getBrands();
        foreach ($brands as $brandData) {
            $brandId = $brandData['id'];
            unset($brandData['id']);

            $brand = Mage::getModel('lcb_pluxee/brand')->load($brandId, 'brand_id');
            $brand->setBrandId($brandId);
            $brand->addData($brandData);
            $brand->save();

            $products = $api->getProducts(['brand_id' => $brandId]);

            foreach ($products as $productData) {
                $this->importProduct($productData);
            }
        }

        if (!$this->update && $this->productsForUpdate) {
            $this->output(sprintf("There are %d products that were not updated. Use --update param to update them.", $this->productsForUpdate));
        }

        $api->logout();
    }

    /**
     * Import/update a single product and its brand
     *
     * @param array $productData
     * @param int|null $categoryId
     * @return void
     */
    protected function importProduct($productData, $categoryId = null)
    {
        $product = Mage::getModel('lcb_pluxee/product')->load($productData['id'], 'product_id');
        if (!$this->update && $product->getId()) {
            $this->productsForUpdate++;
            return;
        }
        $action = $product->getId() ? 'Updated' : 'Imported';
        $product->setProductId($productData['id']);
        unset($productData['id']);

        if ($categoryId !== null) {
            $product->setCategoryId($categoryId);
        }
        $product->setPosition($productData['priority']);
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

        $this->output(sprintf("%s product %s", $action, $product->getLabel()));

        if (!empty($productData['brand_id'])) {
            $brand = Mage::getModel('lcb_pluxee/brand')->load($productData['brand_id'], 'brand_id');
            $isNewBrand = !$brand->getId();
            $brand->setBrandId($productData['brand_id']);
            $brand->setLabel($productData['brand']);
            $brand->save();

            if ($isNewBrand) {
                $this->output(sprintf("Imported brand %s", $brand->getLabel()));
            }
        }
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
