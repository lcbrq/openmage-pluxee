<?php

use Symfony\Component\HttpClient\HttpClient;

/**
 * @author Tomasz Gregorczyk <tomasz@silpion.com.pl>
 */
class LCB_Pluxee_Model_Api
{
    public const SESSION_FLAG_CODE = 'pluxee_session';

    /**
     * @var string
     */
    private $endpoint = 'https://programlojalnosciowy.sayreward.pl';

    /**
     * @var string
     */
    private $username = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $sessionId = '';

    /**
     * @var string
     */
    private $userId = '';

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
        if (Mage::getStoreConfig('pluxee/api/test')) {
            $this->endpoint = 'https://programlojalnosciowy.dev.sayreward.pl';
        }

        $this->username = Mage::getStoreConfig('pluxee/api/username');
        $this->password = Mage::getModel('core/encryption')->decrypt((string) Mage::getStoreConfig('pluxee/api/password'));
    }

    /**
     * @return array
     */
    public function login()
    {
        if (!$this->sessionId || !$this->userId) {
            $response = $this->request('api/Authentication/Login/authenticate', array(
                "username" => $this->username,
                "password" => $this->password,
            ));

            $result = json_decode($response, true);

            if (!empty($result['Response']['user_id']) && !empty($result['Response']['sessionId'])) {
                $this->userId = $result['Response']['user_id'];
                $this->sessionId = $result['Response']['sessionId'];

                Mage::getModel('lcb_pluxee/api_session')->create($result['Response']);
            }
        }

        return $result;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->request('api/Authentication/Session/logout');
    }


    /**
     * @return array
     */
    public function getCategories()
    {
        $this->login();

        $response = $this->request('api/Catalogue/Cache/listCategories');

        $result = json_decode($response, true);

        return $result['Response']['list'];
    }

    /**
     * @param int $categoryId
     * @return array
     */
    public function getProducts($categoryId)
    {
        $this->login();

        $response = $this->request('api/Catalogue/Cache/getCategoryProducts', ['id' => $categoryId]);
        $result = json_decode($response, true);

        return $result['Response']['list'];
    }


    /**
     * @param  int   $brandId
     * @return array
     */
    public function getBrand($brandId)
    {
        $this->login();
        $response = $this->request("api/get_brand/$brandId/");
        $brandData = json_decode($response, true);

        return $brandData;
    }

    /**
     * @param Gtx_Customer_Model_Customer_Customer
     * @param LCB_Pluxee_Model_Product
     * @param Varien_Object|null $card
     * @return LCB_Pluxee_Model_Order|string
     */
    public function purchase($customer, $product, $card = null)
    {
        $this->login();

        if (!$card) {
            $data = array(
              'id' => $this->userId,
              'references' => array(
                  array(
                    'reference_id' => (int) $product->getReferenceId(),
                    "quantity" => 1,
                  )
               )
            );
        } else {
            $data = array(
              'id' => $this->userId,
              'references' => array(
                  array(
                    'reference_id' => (int) $product->getReferenceId(),
                    'card' => array(
                        'number' => $card->getNumber(),
                        'amount' => $card->getAmount(),
                    )
                  )
               )
            );
        }

        $response = $this->request('api/Catalogue/Selections/addItems', $data);

        $result = json_decode($response, true);
        $errors = $this->getErrors($result);

        if ($errors) {
            foreach ($errors as $error) {
                Mage::log($error, null, 'pluxee.log', true);
            }
            Mage::throwException($error);
        }

        if (Mage::getStoreConfigFlag('lcb_pluxee/api/log_all_responses')) {
            Mage::helper('lcb_pluxee')->log($response);
        }

        if ($errors = $this->getErrors($result)) {
            Mage::helper('lcb_pluxee')->log($response);
            return $errors[0];
        }

        $selectionId = $result['Response']['id'];

        $response = $this->request('api/Catalogue/Orders/add', ['selection_id' => $selectionId]);
        $result = json_decode($response, true);

        if ($errors = $this->getErrors($result)) {
            Mage::helper('lcb_pluxee')->log($response);
            return $errors[0];
        }

        if ($pluxeeOrderId = $result['Response']['id']) {
            $pluxeeOrderData = $result['Response'];
            $order = Mage::getModel('lcb_pluxee/order');
            try {
                $purchasedProducts = (array)$pluxeeOrderData['lines'];
                foreach ($purchasedProducts as $purchasedProduct) {
                    $order->setCustomerId($customer->getId());
                    $order->setOrderId($pluxeeOrderId);
                    $order->setGrandTotal($pluxeeOrderData['grand_total']);
                    $order->setProductId($purchasedProduct['id']);
                    $order->save();
                    return $order;
                }
            } catch (Exception $e) {
                Mage::logException($e);
                return $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @param string $number
     * @return stdClass
     */
    public function getOrder($number)
    {
        $this->login();
        $response = $this->request('api/get_order/' . $number);

        return json_decode($response);
    }

    public function getUsers()
    {
        $this->login();

        $response = $this->request('api/UserManagement/Users/getList');

        $result = json_decode($response, true);

        return $result['Response'];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getUser()
    {
        $this->login();

        $response = $this->request('api/UserManagement/Users/get', ['id' => (int) $this->userId]);

        $result = json_decode($response, true);

        return $result['Response'];
    }


    /**
     *
     * @param Mage_Customer_Model_Customer $customer
     * @param Mage_Customer_Model_Customer_Address $address
     * @return array
     */
    public function addUser($customer, $address)
    {
        $data = [
            'login' => $customer->getEmail(),
            'first_name' => $customer->getFirstname(),
            'last_name' => $customer->getLastname(),
            'language' => Mage::app()->getLocale()->getLocaleCode(),
            'email' => $customer->getEmail(),
            'phone' => $address->getTelephone(),
            'address_line_1' =>  $address->getStreet1(),
            'address_line_2' =>  $address->getStreet2(),
            'zipcode' =>  $address->getPostcode(),
            'city' =>  $address->getCity(),
            'country' =>  $address->getCountryId(),
        ];

        $this->login();

        $response = $this->request('api/UserManagement/Users/add', $data);
        $result = json_decode($response, true);

        return $result['Response'];
    }

    /**
     *@param array $result
    @return array
    */
    protected function getErrors($result)
    {
        $errors = [];
        if (!empty($result['Status']['errors'])) {
            foreach ($result['Status']['errors'] as $error) {
                $errors[] = $error['error'];
            }

            return $errors;
        }
    }

    /**
 * @param  string $path
 * @param  array  $data
 * @return string
 */
    private function request($path, $data = array())
    {
        $url = rtrim($this->endpoint, '/') . '/' . ltrim($path, '/');

        $headers = [];
        if ($this->sessionId) {
            $headers['Authorization'] = 'Bearer ' . $this->sessionId;
        }
        if (!empty($data)) {
            $headers['Content-Type'] = 'application/json';
        }

        if (!empty($this->cookies)) {
            $cookieHeader = [];
            foreach ($this->cookies as $name => $value) {
                $cookieHeader[] = $name . '=' . $value;
            }
            $headers['Cookie'] = implode('; ', $cookieHeader);
        }

        $client = HttpClient::create([
            'headers' => $headers,
            'timeout' => 10,
        ]);

        $options = [];

        if (!empty($data)) {
            $options['json'] = $data;
        }

        $response = $client->request(empty($data) ? 'GET' : 'POST', $url, $options);

        foreach ($response->getHeaders(false)['set-cookie'] ?? [] as $setCookie) {
            $parts = explode(';', $setCookie);
            list($name, $value) = explode('=', trim($parts[0]), 2);
            $this->cookies[$name] = $value;
        }

        return $response->getContent();
    }
}
