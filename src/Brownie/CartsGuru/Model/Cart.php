<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model;

/**
 * Cart Model.
 *
 * @method  Cart    setId($id)                                  Set cart reference.
 * @method  Cart    setSiteId($siteId)                          Set siteId.
 * @method  Cart    setCreationDate($creationDate)              Set date of the cart.
 * @method  Cart    setTotalATI($totalATI)                      Set total price including taxes.
 * @method  Cart    setTotalET($totalET)                        Set total price excluding taxes.
 * @method  Cart    setCurrency($currency)                      Set currency, ISO code.
 * @method  Cart    setAccountId($accountId)                    Set account id of the buyer.
 * @method  Cart    setIp($ip)                                  Set visitor IP address.
 * @method  Cart    setRecoverUrl($recoverUrl)                  Set link to recover the cart.
 * @method  Cart    setCivility($civility)                      Set string in this list : 'mister','madam','miss'.
 * @method  Cart    setLastname($lastname)                      Set lastname of the buyer.
 * @method  Cart    setFirstname($firstname)                    Set firstname of the buyer.
 * @method  Cart    setEmail($email)                            Set email address.
 * @method  Cart    setHomePhoneNumber($homePhoneNumber)        Set landline phone number.
 * @method  Cart    setMobilePhoneNumber($mobilePhoneNumber)    Set mobile phone number.
 * @method  Cart    setPhoneNumber($phoneNumber)                Set phone number of buyer.
 * @method  Cart    setCountry($country)                        Set country of the buyer.
 * @method  Cart    setCountryCode($countryCode)                Set country ISO code of the buyer.
 * @method  Cart    setCustom($custom)                          Set any custom fields.
 * @method  string  getEndpoint()                               Returns a endpoint name.
 */
class Cart extends DataModel
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = array(
        'id' => null,                   // Cart reference (use SessionId if you don’t have specific ID).
        'siteId' => null,               // SiteId is part of configuration.
        'creationDate' => null,         // Date of the cart as string in json format
                                        //      (2016-07-26T08:21:25.689Z) (optional).
        'totalATI' => null,             // Total price including taxes.
        'totalET' => null,              // Total price excluding taxes.
        'currency' => null,             // Currency, ISO code (optional).
        'accountId' => null,            // Account id of the buyer (we advise to use the email address).
        'ip' => null,                   // Visitor IP address (optional).
        'recoverUrl' => null,           // Link to recover the cart.
                                        //      (link to cart with security token included) (optional).
        'civility' => null,             // Use string in this list : 'mister','madam','miss' (optional).
        'lastname' => null,             // Lastname of the buyer (optional).
        'firstname' => null,            // Firstname of the buyer.
        'email' => null,                // Email address.
        'homePhoneNumber' => null,      // Landline phone number (optional).
        'mobilePhoneNumber' => null,    // Mobile phone number (optional).
        'phoneNumber' => null,          // Phone number of buyer, if you don’t know the kind of it (optional).
        'country' => null,              // Country of the buyer (you can send country or country code).
        'countryCode' => null,          // Country ISO code of the buyer (you can send country or country code).
        'custom' => null,               // Any custom fields you want to send with the cart
                                        //      Standard fields are language (ISO code),
                                        //      customerGroup and isNewCustomer (Boolean).
        'items' => null,                // Details of each items.
    );

    /**
     * List of required fields.
     *
     * @var array
     */
    protected $requiredFields = array(
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
    );

    /**
     * Endpoint name.
     *
     * @var string
     */
    protected $endpoint = 'carts';
}
