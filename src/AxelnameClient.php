<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 06.11.2018
 * Time: 16:46
 * Contact: lander931@mail.ru
 */

namespace Lander931\Axelname;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Lander931\Axelname\Auth\AuthInterface;

/**
 * Class AxelnameClient
 * @see https://axelname.ru/static/content/files/axelname_api_rest_lite.pdf
 * @package Lander931\Axelname
 */
class AxelnameClient
{

    const API_URL = 'https://my.axelname.ru/rest/';

    /**
     * @var AuthInterface
     */
    private $auth;
    /**
     * @var ClientInterface
     */
    private $http_client;

    public function __construct(AuthInterface $auth, ClientInterface $http_client = null)
    {
        $this->auth = $auth;
        $this->http_client = $http_client ? $http_client : new Client();
    }

    /**
     * @param string|array $domain
     * @param string $profile
     * @param array $ns
     * @param bool $is_test
     * @return \stdClass
     */
    public function domainReg($domain, $profile, array $ns = [], $is_test = false)
    {
        if (is_array($domain)) $domain = array_values($domain);
        $params = [
            'domain' => $domain,
            'nichdl' => $profile,
        ];

        $ns = array_values($ns);
        for ($i = 0; $i < 3 && $i < count($ns); $i++) {
            $params['ns' . ($i + 1)] = $ns[$i];
        }

        if ($is_test) $params['nop'] = true;

        return $this->request('domain_reg', $params);
    }

    /**
     * @param string $domain
     * @return \stdClass
     */
    public function domainCheck($domain)
    {
        $params = [
            'domain' => $domain,
        ];

        return $this->request('domain_check', $params);
    }

    public function domainList()
    {
        return $this->request('domains_list');
    }

    /**
     * @param array $params
     * @see https://axelname.ru/static/content/files/axelname_api_rest_lite.pdf#[{%22num%22%3A51%2C%22gen%22%3A0}%2C{%22name%22%3A%22XYZ%22}%2C56.7%2C785.9%2C0]
     * @return \stdClass
     */
    public function stealSearch(array $params)
    {
        return $this->request('steal_search', $params);
    }

    /**
     * @return \stdClass
     */
    public function stealList()
    {
        return $this->request('steal_list');
    }

    /**
     * @param string $domain
     * @param string $profile
     * @param integer $bid
     * @param bool $is_test
     * @return \stdClass
     */
    public function stealBid($domain, $profile, $bid, $is_test = false)
    {
        $params = [
            'domain' => $domain,
            'nichdl' => $profile,
            'bid' => $bid,
        ];

        if ($is_test) $params['nop'] = true;

        return $this->request('steal_bid', $params);
    }

    /**
     * @param string $domain
     * @return \stdClass
     */
    public function stealGet($domain)
    {
        $params = [
            'domain' => $domain,
        ];

        return $this->request('steal_get', $params);
    }

    /**
     * @return \stdClass
     */
    public function balance()
    {
        return $this->request('balance');
    }

    /**
     * @param $method
     * @param array $params
     * @return \stdClass
     */
    private function request($method, $params = [])
    {
        $params = array_merge($this->auth->toArray(), $params);
        $url = self::API_URL . $method . '/?' . http_build_query($params);

        return json_decode(($this->http_client->request('GET', $url))->getBody()->getContents());
    }
}