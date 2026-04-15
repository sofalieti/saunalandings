<html>
    <head>
        <script type="text/javascript">
            //var container;
            window.addEventListener("load", function (event) {
                parent.postMessage(document.body.scrollHeight, "https://dev.enlightensauna.com/");
            });
        </script>
    </head>
    <body>



        <?php
//header("Access-Control-Allow-Origin: https://dev.enlightensauna.com/");

        $cscartapi = new CSCartApi(
                array(
            'api_key' => 'SpaFj7059Ii28vM5b25iDI30X334wMJf',
            'user_login' => 'archinc@yandex.ru',
            'api_url' => 'https://enlightensauna.com/'
                )
        );

        try {
            $category_ids = [3, 378];
            $params = [
                'sort_by' => 'product',
                'sort_order' => 'asc',
                'status' => 'A',
                'cid' => [3, 378]
            ];
            $params = http_build_query($params);
            $products = $cscartapi->get("products?{$params}");
            //print_r($products);

            $categories = [];
            foreach ($category_ids as $category_id) {
                $categories [] = $cscartapi->get("categories/{$category_id}");
            }

            foreach ($categories as $category) {
                echo "<h1>{$category['category']}</h1>";
                foreach ($products['products'] as $product) {
                    echo "<div style='float: left'>";
                    echo "<h2>" . $product->product . "</h2>";
                    echo "<img src='" . $product->main_pair->detailed->image_path . "' width='200'/><br/>";
                    echo "</div>";
                }
            }
        } catch (Exception $e) {
            print $e->getMessage();
        }




        if (!function_exists('curl_init')) {
            throw new Exception('CS-Cart API Class needs the CURL PHP extension.');
        }
        if (!function_exists('json_decode')) {
            throw new Exception('CS-Cart API Class needs the JSON PHP extension.');
        }

        class CSCartApi {

            const VERSION = '0.2';
            const ERROR_API_CALLING = 'You have to specify a method (eg. POST, PUT, ...) and a correct object url to call the API';
            const ERROR_CURL_ERROR = 'HTTP error while calling the API. Error code and message: ';
            const ERROR_CSCART_API_MESSAGE = 'Message from CS-Cart API: ';

            public static $CURL_OPTS = array(
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_USERAGENT => 'cscart-api-php-beta-0.1',
            );
            protected $apiKey;
            protected $userLogin;
            protected $apiUrl;

            public function __construct($config) {
                $this->setUserLogin($config['user_login']);
                $this->setApiKey($config['api_key']);
                $this->setApiUrl($config['api_url']);
            }

            public function setApiKey($apiKey) {
                $this->apiKey = $apiKey;
            }

            public function setUserLogin($userLogin) {
                $this->userLogin = $userLogin;
            }

            public function setApiUrl($apiUrl) {
                $this->apiUrl = trim($apiUrl, '/') . '/api/';
            }

            public function getApiKey() {
                return $this->apiKey;
            }

            public function getUserLogin() {
                return $this->userLogin;
            }

            public function getApiUrl() {
                return $this->apiUrl;
            }

            public function api($method, $objectUrl, $data = '', $params = array()) {
                if (!empty($method) && !empty($objectUrl)) {
                    return $this->makeRequest($objectUrl, $method, $data, $params);
                } else {
                    throw new Exception(self::ERROR_API_CALLING);
                }
            }

            protected function makeRequest($objectUrl, $method, $data = '', $params = array()) {
                $ch = curl_init();

                $opts = self::$CURL_OPTS;

                $opts[CURLOPT_URL] = $this->initUrl($objectUrl, $params);
                $opts[CURLOPT_USERPWD] = $this->getAuthString();
                //die($this->initUrl($params));
                $this->setHeader($opts, 'Content-Type: application/json');


                if ($method == 'POST' || $method == 'PUT') {
                    $postdata = $this->generatePostData($data);
                } else {
                    unset($data);
                }

                switch ($method) {
                    case 'GET':
                        break;
                    case 'POST':
                        $opts[CURLOPT_CUSTOMREQUEST] = 'POST';
                        $opts[CURLOPT_RETURNTRANSFER] = TRUE;
                        $opts[CURLOPT_POSTFIELDS] = $postdata;
                        $this->setHeader($opts, 'Content-Length: ' . strlen($postdata));
                        break;
                    case 'PUT':
                        $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                        $opts[CURLOPT_RETURNTRANSFER] = TRUE;
                        $opts[CURLOPT_POSTFIELDS] = $postdata;
                        $this->setHeader($opts, 'Content-Length: ' . strlen($postdata));
                        break;
                    case 'DELETE':
                        $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                        break;
                }

                curl_setopt_array($ch, $opts);
                $result = curl_exec($ch);

                if ($result === false) {
                    throw new Exception(self::ERROR_CURL_ERROR . curl_errno($ch) . ': ' . curl_error($ch));
                    curl_close($ch);
                }
                curl_close($ch);
                return $this->parseResult($result);
            }

            protected function initUrl($objectUrl, $params) {
                $params = http_build_query($params);
                $params = $params ? '?' . $params : '';
                return $this->apiUrl . $objectUrl . $params;
            }

            protected function getAuthString() {
                return $this->userLogin . ":" . $this->apiKey;
            }

            protected function setHeader(&$opts, $headerString) {
                $opts[CURLOPT_HTTPHEADER][] = $headerString;
            }

            protected function generatePostData($data) {
                return json_encode($data);
            }

            protected function parseResult($jsonResult) {
                $result = (array) json_decode($jsonResult);
                if (!empty($result['message'])) {
                    throw new Exception(self::ERROR_CSCART_API_MESSAGE . $result['message']);
                } else {
                    return $result;
                }
            }

            public function get($objectUrl, $params = array()) {
                return $this->makeRequest($objectUrl, 'GET', '', $params);
            }

            public function update($objectUrl, $data) {
                return $this->makeRequest($objectUrl, 'PUT', $data);
            }

            public function create($objectUrl, $data) {
                return $this->makeRequest($objectUrl, 'POST', $data);
            }

            public function delete($objectUrl) {
                return $this->makeRequest($objectUrl, 'DELETE');
            }

            public function getApiVersion() {
                return self::VERSION;
            }

            public function getCartVersion() {
                return str_replace("CS-Cart: version ", "", strip_tags(file_get_contents($this->apiUrl . '?version')));
            }

        }
        ?>
    </body>
</html>