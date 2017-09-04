<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model;

use Brownie\CartsGuru\Exception\ValidateException;

/**
 * Order Model.
 *
 * @method  Order   setId($id)
 * @method  Order   setSiteId($siteId)
 * @method  Order   setCartId($cartId)
 * @method  Order   setCreationDate($craeteDdate)
 * @method  Order   setTotalATI($totalATI)
 * @method  Order   setTotalET($totalET)
 * @method  Order   setCurrency($currency)
 * @method  Order   setPaymentMethod($paymentMethod)
 * @method  Order   setState($state)
 * @method  Order   setIp($ip)
 * @method  Order   setAccountId($accountId)
 * @method  Order   setCivility($civility)
 * @method  Order   setLastname($lastName)
 * @method  Order   setFirstname($firstName)
 * @method  Order   setEmail($email)
 * @method  Order   setHomePhoneNumber($homePhoneNumber)
 * @method  Order   setMobilePhoneNumber($mobilePhoneNumber)
 * @method  Order   setCountry($country)
 * @method  Order   setCountryCode($countryCode)
 * @method  Order   setCustom($custom)
 * @method  ItemList    getItems()
 */
class Order extends DataModel
{

    protected $fields = array(
        'id' => null,                   // Order reference, the same display to the buyer
        'siteId' => null,               // SiteId is part of configuration
        'cartId' => null,               // Cart reference, source of the order (optional)
        'creationDate' => null,         // Date of the order as string in json format (2016-07-26T08:21:25.689Z) (optional)
        'totalATI' => null,             // Amount included taxes and excluded shipping
        'totalET' => null,              // Amount excluded taxes and excluded shipping
        'currency' => null,             // Currency, ISO code (optional)
        'paymentMethod' => null,        // Payment method used (optional)
        'state' => null,                // Status of the order
        'ip' => null,                   // Visitor ip address (optional)
        'accountId' => null,            // Account id of the buyer (use same identifier as Carts)
        'civility' => null,             // Use string in this list : ‘mister','madam','miss' (optional)
        'lastname' => null,             // Lastname of the buyer (optional)
        'firstname' => null,            // Firstname of the buyer
        'email' => null,                // Email address of the buyer
        'homePhoneNumber' => null,      // Landline phone number of buyer (optional)
        'mobilePhoneNumber' => null,    // Mobile phone number of buyer (optional)
        'country' => null,              // Country of the buyer (you can send country or country code)
        'countryCode' => null,          // Country ISO code of the buyer (you can send country or country code)
        'custom' => null,               // Any custom fields you want to send with the cart. Standard fields are language (ISO code), customerGroup and isNewCustomer (Boolean)
        'items' => null,                // Details of each items
    );

    /**
     * Validates contact data.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        $args = array_filter(parent::toArray());

        $keys = array_diff(array(
            'id',
            'siteId',
            'totalATI',
            'totalET',
            'state',
            'accountId',
            'firstname',
            'email',
            'country',
            'countryCode',
            'items',
        ), array_keys($args));

        if ($keys) {
            throw new ValidateException('No required fields: ' . implode(', ', $keys));
        }

        foreach ($this->getItems()->toArray() as $item) {
            $item->validate();
        }
    }
}
