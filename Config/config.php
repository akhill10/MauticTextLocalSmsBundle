<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return [
    'services' => [
        'events' => [
            'mautic.textlocal.sms.campaignbundle.subscriber' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\EventListener\CampaignSubscriber',
                'arguments' => [
                    'mautic.helper.integration',
                    'mautic.textlocal.sms.model.sms',
                ],
            ],
            'mautic.textlocal.sms.mautictextlocalsmsbundle.subscriber' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\EventListener\SmsSubscriber',
                'arguments' => [
                    'mautic.core.model.auditlog',
                    'mautic.page.model.trackable',
                    'mautic.page.helper.token',
                    'mautic.asset.helper.token',
                ],
            ],
            'mautic.textlocal.sms.channel.subscriber' => [
                'class'     => \MauticPlugin\MauticTextLocalSmsBundle\EventListener\ChannelSubscriber::class,
                'arguments' => [
                    'mautic.helper.integration',
                ],
            ],
            'mautic.textlocal.sms.message_queue.subscriber' => [
                'class'     => \MauticPlugin\MauticTextLocalSmsBundle\EventListener\MessageQueueSubscriber::class,
                'arguments' => [
                    'mautic.textlocal.sms.model.sms',
                ],
            ],
            'mautic.textlocal.sms.stats.subscriber' => [
                'class'     => \MauticPlugin\MauticTextLocalSmsBundle\EventListener\StatsSubscriber::class,
                'arguments' => [
                    'doctrine.orm.entity_manager',
                ],
            ],
        ],
        'forms' => [
            'mautic.textlocal.form.type.sms' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\Form\Type\SmsType',
                'arguments' => 'mautic.factory',
                'alias'     => 'textlocalsms',
            ],
            'mautic.textlocal.form.type.textlocalsmsconfig' => [
                'class' => 'MauticPlugin\MauticTextLocalSmsBundle\Form\Type\ConfigType',
                'alias' => 'textlocalsmsconfig',
            ],
            'mautic.textlocal.form.type.textlocalsmssend_list' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\Form\Type\SmsSendType',
                'arguments' => 'router',
                'alias'     => 'textlocalsmssend_list',
            ],
            'mautic.textlocal.form.type.textlocalsmssms_list' => [
                'class' => 'MauticPlugin\MauticTextLocalSmsBundle\Form\Type\SmsListType',
                'alias' => 'textlocalsmssms_list',
            ],
        ],
        'helpers' => [
            'mautic.textlocal.helper.sms' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\Helper\SmsHelper',
                'arguments' => [
                    'doctrine.orm.entity_manager',
                    'mautic.lead.model.lead',
                    'mautic.helper.phone_number',
                    'mautic.textlocal.sms.model.sms',
                    'mautic.helper.integration',
                ],
                'alias' => 'textlocalsms_helper',
            ],
        ],
        'other' => [
            'mautic.textlocal.sms.api' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\Api\TextLocalApi',
                'arguments' => [
                    'mautic.page.model.trackable',
                    'mautic.helper.phone_number',
                    'mautic.helper.integration',
                    'monolog.logger.mautic',
                ],
                'alias' => 'textlocalsms_api',
            ],

        ],
        'models' => [
            'mautic.textlocal.sms.model.sms' => [
                'class'     => 'MauticPlugin\MauticTextLocalSmsBundle\Model\SmsModel',
                'arguments' => [
                    'mautic.page.model.trackable',
                    'mautic.lead.model.lead',
                    'mautic.channel.model.queue',
                    'mautic.textlocal.sms.api',
                ],
            ],
        ],
    ],
    'routes' => [
        'main' => [
            'mautic_sms_index' => [
                'path'       => '/textlocalsms/{page}',
                'controller' => 'MauticTextLocalSmsBundle:Sms:index',
            ],
            'mautic_sms_action' => [
                'path'       => '/textlocalsms/{objectAction}/{objectId}',
                'controller' => 'MauticTextLocalSmsBundle:Sms:execute',
            ],
            'mautic_sms_contacts' => [
                'path'       => '/textlocalsms/view/{objectId}/contact/{page}',
                'controller' => 'MauticTextLocalSmsBundle:Sms:contacts',
            ],
        ],
        'public' => [
            'mautic_receive_sms' => [
                'path'       => '/textlocalsms/receive',
                'controller' => 'MauticTextLocalSmsBundle:Api\SmsApi:receive',
            ],
        ],
        'api' => [
            'mautic_api_smsesstandard' => [
                'standard_entity' => true,
                'name'            => 'smses',
                'path'            => '/textlocales',
                'controller'      => 'MauticTextLocalSmsBundle:Api\SmsApi',
            ],
        ],
    ],
    'menu' => [
        'main' => [
            'items' => [
                'mautic.sms.smses' => [
                    'route'  => 'mautic_sms_index',
                    'access' => ['sms:smses:viewown', 'sms:smses:viewother'],
                    'parent' => 'mautic.core.channels',
                    'checks' => [
                        'integration' => [
                            'TextLocal' => [
                                'enabled' => true,
                            ],
                        ],
                    ],
                    'priority' => 70,
                ],
            ],
        ],
    ],
    'parameters' => [
        'sms_enabled'              => false,
        'sms_username'             => null,
        'sms_password'             => null,
        'sms_sending_phone_number' => null,
        'sms_frequency_number'     => null,
        'sms_frequency_time'       => null,
        'sms_transport'            => 'mautic.sms.transport.textlocal',
    ],
];
