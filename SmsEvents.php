<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticTextLocalSmsBundle;

/**
 * Class SmsEvents
 * Events available for MauticTextLocalSmsBundle.
 */
final class SmsEvents
{
    /**
     * The mautic.sms_token_replacement event is thrown right before the content is returned.
     *
     * The event listener receives a
     * Mautic\CoreBundle\Event\TokenReplacementEvent instance.
     *
     * @var string
     */
    const TOKEN_REPLACEMENT = 'mautic.textlocal.sms_token_replacement';

    /**
     * The mautic.sms_on_send event is thrown when a sms is sent.
     *
     * The event listener receives a
     * MauticPlugin\MauticTextLocalSmsBundle\Event\SmsSendEvent instance.
     *
     * @var string
     */
    const SMS_ON_SEND = 'mautic.textlocal.sms_on_send';

    /**
     * The mautic.sms_pre_save event is thrown right before a sms is persisted.
     *
     * The event listener receives a
     * MauticPlugin\MauticTextLocalSmsBundle\Event\SmsEvent instance.
     *
     * @var string
     */
    const SMS_PRE_SAVE = 'mautic.textlocal.sms_pre_save';

    /**
     * The mautic.sms_post_save event is thrown right after a sms is persisted.
     *
     * The event listener receives a
     * MauticPlugin\MauticTextLocalSmsBundle\Event\SmsEvent instance.
     *
     * @var string
     */
    const SMS_POST_SAVE = 'mautic.textlocal.sms_post_save';

    /**
     * The mautic.sms_pre_delete event is thrown prior to when a sms is deleted.
     *
     * The event listener receives a
     * MauticPlugin\MauticTextLocalSmsBundle\Event\SmsEvent instance.
     *
     * @var string
     */
    const SMS_PRE_DELETE = 'mautic.textlocal.sms_pre_delete';

    /**
     * The mautic.sms_post_delete event is thrown after a sms is deleted.
     *
     * The event listener receives a
     * MauticPlugin\MauticTextLocalSmsBundle\Event\SmsEvent instance.
     *
     * @var string
     */
    const SMS_POST_DELETE = 'mautic.textlocal.sms_post_delete';

    /**
     * The mautic.sms.on_campaign_trigger_action event is fired when the campaign action triggers.
     *
     * The event listener receives a
     * Mautic\CampaignBundle\Event\CampaignExecutionEvent
     *
     * @var string
     */
    const ON_CAMPAIGN_TRIGGER_ACTION = 'mautic.textlocal.sms.on_campaign_trigger_action';
}
