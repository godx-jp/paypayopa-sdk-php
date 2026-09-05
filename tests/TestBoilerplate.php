<?php

declare(strict_types=1);
require_once(__DIR__ . '/../src/Client.php');

use PHPUnit\Framework\TestCase;
use PayPay\OpenPaymentAPI\Client;

class BoilerplateTest extends TestCase
{
    /**
     * Open API Client
     *
     * @var Client
     */
    protected $client;
    /**
     * Buffer array to communicate data between tests
     *
     * @var Array
     */
    protected $data;
    /**
     * Test configuration
     *
     * @var Array
     */
    protected $config;
    /**
     * Set up the shared API client for every test case.
     *
     * This used to be a constructor. PHPUnit 10 changed TestCase::__construct()
     * to require the test name (`__construct(string $name)`), so the old
     * `parent::__construct()` call raised ArgumentCountError before a single
     * test could be built. Fixture set-up belongs in setUp() anyway.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        require('config.php');
        $this->client = new Client([
            /** @phpstan-ignore-next-line */
            'API_KEY' => $config['key'],
            /** @phpstan-ignore-next-line */
            'API_SECRET' => $config['secret'],
            /** @phpstan-ignore-next-line */
            'MERCHANT_ID' => $config['mid']
        ], 'test');
        /** @phpstan-ignore-next-line */
        $this->config = $config;
    }
    /**
     * Initialization check
     *
     * @return void
     */
    public function InitCheck()
    {
        $this->assertInstanceOf(Client::class, $this->client, 'Client initialized incorrectly.');
    }
}