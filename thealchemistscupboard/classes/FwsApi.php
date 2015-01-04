<?php

class FwsApi {

    protected $_apiRequest;
    protected $_apiResponse;
    protected $_baseUrl = 'http://api.freewebstore.org';
    protected $_curlInfo;
    protected $_pass = 'fd1bef625a361462d6f79a17d91d3be1';
    protected $_resorce;
    protected $_timeout = 20;
    protected $_user = '184807';
    protected $_verb;

    protected function _send() {
        $curl = curl_init($this->_baseUrl . $this->_resorce);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "{$this->_user}:{$this->_pass}");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if ($this->_verb == 'POST') {
            $contentLength = strlen($this->_apiRequest);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-type: text/xml',
                "Content-length: {$contentLength}")
            );
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->_xmlRequest);
        }

        $this->_apiResponse = curl_exec($curl);
        $this->_curlInfo = curl_getinfo($curl);

        if (!$this->_apiResponse) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }

        curl_close($curl);
    }

    public function getNewOrders()
    {
        $this->_verb = 'GET';
        $this->_resorce = '/order/?isnew=1&status=1';
        $this->_send();
        $response = simplexml_load_string($this->_apiResponse);
        echo "<!-- ";
        var_dump($response);
        echo " -->\n";
        return $response;
    }

    public function getNewOrderCount()
    {
        $this->_verb = 'GET';
        $this->_resorce = '/order/new';
        $this->_send();
        $response = simplexml_load_string($this->_apiResponse);
        return (string) $response->unread;
    }

    public function getOrderDetails($order)
    {
        $this->_verb = 'GET';
        $this->_resorce = "/order/{$order->id}";
        $this->_send();
        $response = simplexml_load_string($this->_apiResponse);
        //$response = simplexml_load_file('returned-order.xml');
        return $response;
    }
}
