<?php
/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      André Rocha
 *
 * @link        http://mjlogan.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTextLocalSmsBundle\Api;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Mautic\CoreBundle\Helper\PhoneNumberHelper;
use Mautic\PageBundle\Model\TrackableModel;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use Monolog\Logger;

class TextLocalApi extends AbstractSmsApi
{
    private $username;
    private $password;



    /**
     * @var \Services_TextLocal
     */
    protected $client;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var string
     */
    protected $sendingPhoneNumber;

    

    /**
     * TextLocalApi constructor.
     *
     * @param TrackableModel    $pageTrackableModel
     * @param PhoneNumberHelper $phoneNumberHelper
     * @param IntegrationHelper $integrationHelper
     * @param Logger            $logger
     */

    // public function __construct(TrackableModel $pageTrackableModel, PhoneNumberHelper $phoneNumberHelper, IntegrationHelper $integrationHelper, Logger $logger, $username, $password)
    public function __construct(TrackableModel $pageTrackableModel, PhoneNumberHelper $phoneNumberHelper, IntegrationHelper $integrationHelper, Logger $logger)
    {
        $this->logger = $logger;

        $integration = $integrationHelper->getIntegrationObject('TextLocal');

        if ($integration && $integration->getIntegrationSettings()->getIsPublished()) {
            $this->sendingPhoneNumber = $integration->getIntegrationSettings()->getFeatureSettings()['sending_phone_number'];

            $keys = $integration->getDecryptedApiKeys();

            //$this->client = new \Services_TextLocal($keys['username'], $keys['password']);
            $this->username = $keys['username'];
            $this->password = $keys['password'];
        }

        parent::__construct($pageTrackableModel);
    }

    /**
     * @param string $number
     *
     * @return string
     */
    protected function sanitizeNumber($number)
    {
        $util   = PhoneNumberUtil::getInstance();
        $parsed = $util->parse($number, 'US');

        return $util->format($parsed, PhoneNumberFormat::E164);
    }

    /**
     * @param string $number
     * @param string $content
     *
     * @return bool|string
     */
    public function sendSms($number, $content)
    {

        if ($number === null) {
            return false;
        }

        $messageBody = $content;

        try{
            $number = $number;
            $sid = $this->username;
            $accessToken = $this->password;

           // Authorisation details.
            $username = $sid;
            $hash = $accessToken;

            // Config variables. Consult http://api.textlocal.in/docs for more info.
            $test = "0";

            // Data for text message. This is the text message data.
            $sender = $this->sendingPhoneNumber; // This is who the message appears to be from.
            $numbers = $number; // A single number or a comma-seperated list of numbers
            // 612 chars or less
            // A single number or a comma-seperated list of numbers
            $message = urlencode($messageBody);
            $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
            $ch = curl_init('http://api.textlocal.in/send/?');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch); // This is the result from the API
            curl_close($ch);

            //echo "<pre>",print_r($result);

            
        }
        catch(Exception $e) {
            $this->logger->addWarning(
                $e->getMessage(),
                ['exception' => $e]
            );
            return false;
        }

		return true;

    }
}

