<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model;

use Brownie\CartsGuru\Exception\ValidateException;

/**
 * Cart Model.
 *
 * @method  Cart    setId($id)
 * @method  Cart    setSiteId($siteId)
 * @method  Cart    setCreationDate($creationDate)
 * @method  Cart    setTotalATI($totalATI)
 * @method  Cart    setTotalET($totalET)
 * @method  Cart    setCurrency($currency)
 * @method  Cart    setAccountId($accountId)
 * @method  Cart    setIp($ip)
 * @method  Cart    setRecoverUrl($recoverUrl)
 * @method  Cart    setCivility($civility)
 * @method  Cart    setLastname($lastname)
 * @method  Cart    setFirstname($firstname)
 * @method  Cart    setEmail($email)
 * @method  Cart    setHomePhoneNumber($homePhoneNumber)
 * @method  Cart    setMobilePhoneNumber($mobilePhoneNumber)
 * @method  Cart    setPhoneNumber($phoneNumber)
 * @method  Cart    setCountry($country)
 * @method  Cart    setCountryCode($countryCode)
 * @method  Cart    setCustom($custom)
 */
class Cart extends DataModel
{

    protected $fields = array(
        'id' => null,                   // Cart reference (use SessionId if you don’t have specific ID)
        'siteId' => null,               // SiteId is part of configuration
        'creationDate' => null,         // Date of the cart as string in json format (2016-07-26T08:21:25.689Z) (optional)
        'totalATI' => null,             // Total price including taxes
        'totalET' => null,              // Total price excluding taxes
        'currency' => null,             // Currency, ISO code (optional)
        'accountId' => null,            // Account id of the buyer (we advise to use the email address)
        'ip' => null,                   // Visitor IP address (optional)
        'recoverUrl' => null,           // Link to recover the cart (link to cart with security token included) (optional)
        'civility' => null,             // Use string in this list : 'mister','madam','miss' (optional)
        'lastname' => null,             // Lastname (optional)
        'firstname' => null,            // Firstname
        'email' => null,                // Email address
        'homePhoneNumber' => null,      // Landline phone number (optional)
        'mobilePhoneNumber' => null,    // Mobile phone number (optional)
        'phoneNumber' => null,          // Phone number of buyer, if you don’t know the kind of it (optional)
        'country' => null,              // Country of the buyer (you can send country or country code)
        'countryCode' => null,          // Country ISO code of the buyer (you can send country or country code)
        'custom' => null,               // Any custom fields you want to send with the cart. Standard fields are language (ISO code), customerGroup and isNewCustomer (Boolean).
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
