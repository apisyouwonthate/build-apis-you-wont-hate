<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Guzzle\Service\Client,
    Guzzle\Http\Exception\BadResponseException;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

require_once __DIR__.'/../../../../vendor/phpunit/phpunit/PHPUnit/Autoload.php';
require_once __DIR__.'/../../../../vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * The Guzzle HTTP Client.
     */
    protected $client;

    /**
     * The current resource
     */
    protected $resource;

    /**
     * The request payload
     */
    protected $requestPayload;

    /**
     * The Guzzle HTTP Response.
     */
    protected $response;

    /**
     * The decoded response object.
     */
    protected $responsePayload;

    /**
     * The current scope within the response payload
     * which conditions are asserted against.
     */
    protected $scope = [
        'property' => null,
        'position' => 'first',
    ];

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $config = isset($parameters['guzzle']) && is_array($parameters['guzzle']) ? $parameters['guzzle'] : [];

        $this->client = new Client($parameters['base_url'], $config);
        $this->client->setDefaultHeaders([
            'Accept' => 'application/vnd.com.kapture.api-v4+json',
            'Authorization' => "Bearer {$parameters['access_token']}",
        ]);
    }

    /**
     * @Given /^I have the payload:$/
     */
    public function iHaveThePayload(PyStringNode $requestPayload)
    {
        $this->requestPayload = $requestPayload;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $resource)
    {
        $this->resource = $resource;

        $method = strtolower($httpMethod);

        try {
            switch ($httpMethod) {
                case 'PUT':
                case 'POST':
                    $this->response = $this
                        ->client
                        ->$method($resource, null, $this->requestPayload)
                        ->send();
                    break;

                default:
                    $this->response = $this
                        ->client
                        ->$method($resource)
                        ->send();
            }
        }
        catch (BadResponseException $e) {

            $response = $e->getResponse();

            // Sometimes the request will fail, at which point we have
            // no response at all. Let Guzzle give an error here, it's
            // pretty self-explanatory.
            if ($response === null) {
                throw $e;
            }

            $this->response = $e->getResponse();
        }
    }

    /**
     * @Then /^I get a "([^"]*)" response$/
     */
    public function iGetAResponse($statusCode)
    {
        assertSame($statusCode, $this->getResponse()->getStatusCode(), $this->getResponse()->getBody());
    }

    /**
     * @Given /^the "([^"]*)" property exists$/
     */
    public function thePropertyExists($property)
    {
        $payload = $this->getScopePayload();

        assertTrue(
            property_exists($payload, $property),
            "Asserting the [$property] property exists in current scope.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an array$/
     */
    public function thePropertyIsAnArray($property)
    {
        $payload = $this->getScopePayload();

        assertTrue(
            is_array($payload->$property),
            "Asserting the [$property] property in current scope is an array.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an empty array$/
     */
    public function thePropertyIsAnEmptyArray($property)
    {
        $payload = $this->getScopePayload();

        assertTrue(
            is_array($payload->$property) and $payload->$property === [],
            "Asserting the [$property] property in current scope is an empty array.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property contains (\d+) items$/
     */
    public function thePropertyContainsItems($property, $count)
    {
        $payload = $this->getScopePayload();

        assertCount(
            $count,
            $payload->$property,
            "Asserting the [$property] property contains [$count] items.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an object$/
     */
    public function thePropertyIsAnObject($property)
    {
        $payload = $this->getScopePayload();

        assertInstanceOf(
            'stdClass',
            $payload->$property,
            "Asserting the [$property] property in current scope is an object.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an integer$/
     */
    public function thePropertyIsAnInteger($property)
    {
        $payload = $this->getScopePayload();

        isType(
            'int',
            $payload->$property,
            "Asserting the [$property] property in current scope is an integer.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a string$/
     */
    public function thePropertyIsAString($property)
    {
        $payload = $this->getScopePayload();

        isType(
            'string',
            $payload->$property,
            "Asserting the [$property] property in current scope is a string.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a boolean$/
     */
    public function thePropertyIsABoolean($property)
    {
        $payload = $this->getScopePayload();

        assertTrue(
            gettype($payload->$property) == 'boolean',
            "Asserting the [$property] property in current scope is a boolean.\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property equals "([^"]*)"$/
     */
    public function thePropertyEquals($property, $value)
    {
        $payload = $this->getScopePayload();

        assertEquals(
            $payload->$property,
            $value,
            "Asserting the [$property] property in current scope equals [$value].\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a boolean equalling "([^"]*)"$/
     */
    public function thePropertyIsABooleanEqualling($property, $value)
    {
        $payload = $this->getScopePayload();

        if ( ! in_array($value, ['true', 'false'])) {
            throw new \InvalidArgumentException("Testing for booleans must be represented by [true] or [false].");
        }

        $this->thePropertyIsABoolean($property);

        assertSame(
            $payload->$property,
            $value == 'true',
            "Asserting the [$property] property in current scope is a boolean equalling [$value].\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a string equalling "([^"]*)"$/
     */
    public function thePropertyIsAStringEqualling($property, $value)
    {
        $payload = $this->getScopePayload();

        $this->thePropertyIsAString($property);

        assertSame(
            $payload->$property,
            $value,
            "Asserting the [$property] property in current scope is a string equalling [$value].\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a integer equalling "([^"]*)"$/
     */
    public function thePropertyIsAIntegerEqualling($property, $value)
    {
        $payload = $this->getScopePayload();

        $this->thePropertyIsAnInteger($property);

        assertSame(
            $payload->$property,
            (int) $value,
            "Asserting the [$property] property in current scope is an integer equalling [$value].\n{$this->debug($payload)}"
        );
    }

    /**
     * @Given /^the "([^"]*)" property is either:$/
     */
    public function thePropertyIsEither($property, PyStringNode $options)
    {
        $payload = $this->getScopePayload();

        $valid = explode("\n", (string) $options);

        assertTrue(
            in_array($payload->$property, $valid),
            sprintf(
                "Asserting the [%s] property in current scope is in array of valid options [%s].\n%s",
                $property,
                implode(', ', $valid),
                $this->debug($payload)
            )
        );
    }

    /**
     * @Given /^scope into the first "([^"]*)" property$/
     *
     * @todo Adjust regex to remove redundent method.
     */
    public function scopeIntoTheFirstProperty($property)
    {
        $this->scopeIntoTheProperty($property);
    }

    /**
     * @Given /^scope into the "([^"]*)" property$/
     */
    public function scopeIntoTheProperty($property)
    {
        $position = 'first';
        $this->scope = compact('property', 'position');
    }

    /**
     * @Given /^the properties exist:$/
     */
    public function thePropertiesExist(PyStringNode $propertiesString)
    {
        foreach (explode("\n", (string) $propertiesString) as $property) {
            $this->thePropertyExists($property);
        }
    }

    /**
     * @Given /^reset scope$/
     */
    public function resetScope()
    {
        $this->scope = ['property' => null, 'position' => 'first'];
    }

    /**
     * @Transform /^(\d+)$/
     */
    public function castStringToNumber($string)
    {
        return intval($string);
    }

    /**
     * Checks the response exists and returns it.
     *
     * @return  Guzzle\Http\Message\Response
     */
    protected function getResponse()
    {
        if (!$this->response) {
            throw new Exception("You must first make a request to check a response.");
        }

        return $this->response;
    }

    /**
     * Return the response payload from the current response.
     *
     * @return  mixed
     */
    protected function getResponsePayload()
    {
        if (!$this->responsePayload) {
            $json = json_decode($this->getResponse()->getBody(true));

            if (json_last_error() !== JSON_ERROR_NONE) {
                $mesage = 'Failed to decode JSON body ';

                switch (json_last_error()) {
                    case JSON_ERROR_DEPTH:
                        $message .= '(Maximum stack depth exceeded).';
                    break;
                    case JSON_ERROR_STATE_MISMATCH:
                        $message .= '(Underflow or the modes mismatch).';
                    break;
                    case JSON_ERROR_CTRL_CHAR:
                        $message .= '(Unexpected control character found).';
                    break;
                    case JSON_ERROR_SYNTAX:
                        $message .= '(Syntax error, malformed JSON).';
                    break;
                    case JSON_ERROR_UTF8:
                        $message .= '(Malformed UTF-8 characters, possibly incorrectly encoded).';
                    break;
                    default:
                        $message .= '(Unknown error).';
                    break;
                }

                throw new Exception($message);
            }

            $this->responsePayload = $json;
        }

        return $this->responsePayload;
    }

    /**
     * Returns the payload from the current scope within
     * the response.
     *
     * @return mixed
     */
    protected function getScopePayload()
    {
        $payload = $this->getResponsePayload();

        if (!$this->scope['property']) {
            return $payload;
        }

        assertTrue(
            property_exists($payload, $this->scope['property']),
            "Ensuring the current property exists within the response payload to change scope.\n{$this->debug($payload)}"
        );

        $payload = $payload->{$this->scope['property']};

        if (is_array($payload)) {
            $position = $this->scope['position'];

            if (is_numeric($position)) {

                // When position is 1, index is 0
                $index = $position - 1;

                assertTrue(
                    array_key_exists($index, $payload),
                    "Ensuring index [$index] exists from numeric scope position [$position].\n{$this->debug($payload)}"
                );

                return $payload[$index];
            }

            switch ($position) {
                case 'first':
                    return reset($payload);

                case 'last':
                    return end($payload);

                default:
                    throw new Exception("Invalid scope position [$position] provided.\n{$this->debug($payload)}");
            }
        }

        return $payload->{$this->scope};
    }

    /**
     * Returns a payload in JSON form for debugging.
     *
     * @param  mixed  $payload
     * @return string
     */
    protected function debug($payload)
    {
        return json_encode($payload, JSON_PRETTY_PRINT);
    }

}
