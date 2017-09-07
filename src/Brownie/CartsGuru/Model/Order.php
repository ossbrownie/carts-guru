<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model;

/**
 * Order Model.
 *
 * @method  Order       setId($id)                                  Set order reference.
 * @method  Order       setSiteId($siteId)                          Set siteId.
 * @method  Order       setCartId($cartId)                          Set cart reference.
 * @method  Order       setCreationDate($creationDate)              Set date of the order.
 * @method  Order       setTotalATI($totalATI)                      Set total price including taxes.
 * @method  Order       setTotalET($totalET)                        Set total price excluding taxes.
 * @method  Order       setCurrency($currency)                      Set currency, ISO code.
 * @method  Order       setPaymentMethod($paymentMethod)            Set payment method.
 * @method  Order       setState($state)                            Set status of the order.
 * @method  Order       setIp($ip)                                  Set visitor ip address.
 * @method  Order       setAccountId($accountId)                    Set account id of the buyer.
 * @method  Order       setCivility($civility)                      Set string in this list : 'mister','madam','miss'.
 * @method  Order       setLastname($lastName)                      Set lastname of the buyer.
 * @method  Order       setFirstname($firstName)                    Set firstname of the buyer.
 * @method  Order       setEmail($email)                            Set email address of the buyer.
 * @method  Order       setHomePhoneNumber($homePhoneNumber)        Set landline phone number.
 * @method  Order       setMobilePhoneNumber($mobilePhoneNumber)    Set mobile phone number.
 * @method  Order       setCountry($country)                        Set country of the buyer.
 * @method  Order       setCountryCode($countryCode)                Set country ISO code of the buyer.
 * @method  Order       setCustom($custom)                          Set any custom fields.
 * @method  ItemList    getItems()                                  Get items.
 */
class Order extends DataModel
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = array(
        'id' => null,                   // Order reference, the same display to the buyer.
        'siteId' => null,               // SiteId is part of configuration.
        'cartId' => null,               // Cart reference, source of the order (optional).
        'creationDate' => null,         // Date of the order as string in json format
                                        //      (2016-07-26T08:21:25.689Z) (optional).
        'totalATI' => null,             // Amount included taxes and excluded shipping.
        'totalET' => null,              // Amount excluded taxes and excluded shipping.
        'currency' => null,             // Currency, ISO code (optional).
        'paymentMethod' => null,        // Payment method used (optional).
        'state' => null,                // Status of the order.
        'ip' => null,                   // Visitor ip address (optional).
        'accountId' => null,            // Account id of the buyer (use same identifier as Carts).
        'civility' => null,             // Use string in this list : ‘mister','madam','miss' (optional).
        'lastname' => null,             // Lastname of the buyer (optional).
        'firstname' => null,            // Firstname of the buyer.
        'email' => null,                // Email address of the buyer.
        'homePhoneNumber' => null,      // Landline phone number of buyer (optional).
        'mobilePhoneNumber' => null,    // Mobile phone number of buyer (optional).
        'country' => null,              // Country of the buyer (you can send country or country code).
        'countryCode' => null,          // Country ISO code of the buyer (you can send country or country code).
        'custom' => null,               // Any custom fields you want to send with the cart.
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
        'state',
        'accountId',
        'firstname',
        'email',
        'country',
        'countryCode',
        'items',
    );
}
