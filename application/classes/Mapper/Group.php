<?php

namespace Mapper;

use Aggregate\Permission as PermissionAggregate;
use Entity\Permission as PermissionEntity;
use Entity\Group as GroupEntity;
use Entity\Subscription as SubscriptionEntity;
use Entity\Subscription;
use Type\Money;
use Type\FileSize;
use Aggregate\FileExtension as FileExtensionAggregate;
use DateInterval;
use Aggregate\Group as GroupAggregate;

class Group
{
    public static function convertToEntities($resultSet)
    {
        $groups = array();

        foreach($resultSet as $result)
        {
            $groups[] = self::convertToEntity($result);
        }

        return new GroupAggregate($groups);
    }

    public static function convertToEntity($result)
    {
        $group = new GroupEntity($result->id);

        $group->setName($result->name);
        $group->setActiveFlag( (int) $result->status === 1 );
        $group->setDescription($result->descr);

        switch($result->repeat_billing) {
            case 'm':
                $billingInterval = Subscription::REPEAT_MONTHLY;
                break;

            case 'y':
                $billingInterval = Subscription::REPEAT_YEARLY;
                break;

            default:
                $billingInterval = Subscription::REPEAT_NEVER;
                break;
        }

        $group->setSubscription(
            // TODO: Be able to store things that are not USD.
            new SubscriptionEntity( new Money($result->price, 'USD'), $billingInterval)
        );

        $group->setPermissions(new PermissionAggregate(array(
            'SpeedLimit' => new PermissionEntity('SpeedLimit', new FileSize((int)$result->speed_limit, 'KB')),
            'UploadSizeLimit' => new PermissionEntity('UploadSizeLimit', new FileSize((int)$result->upload_size_limit, 'MB')),
            'WaitTimeLimit' => new PermissionEntity('WaitTimeLimit', new DateInterval("PT{$result->wait_time}S")),
            'FileTypeLimit' => new PermissionEntity('FileTypeList', FileExtensionAggregate::createFromPipedList($result->files_types, $result->file_types_allow_deny === 1 ? FileExtensionAggregate::FILTER_WHITELIST : FileExtensionAggregate::FILTER_BLACKLIST)),
            'HasCaptchaOnDownload' => new PermissionEntity('HasCaptchaOnDownload', (int) $result->download_captcha === 1),
            'HasAutoDownload' => new PermissionEntity('HasAutoDownload', (int) $result->auto_download === 1),
            'MaxFilesInSessionUploadedLimit' => new PermissionEntity('MaxFilesInSessionUploadedLimit', (int) $result->upload_num_limit),
            'FileStorageLimit' => new PermissionEntity('FileStorageLimit', new FileSize((int) $result->storage_limit, 'MB')),
            'HasSearchCapability' => new PermissionEntity('HasSearchCapability', (int) $result->can_search === 1),
            'HasFlashUploadCapability' => new PermissionEntity('HasFlashUploadCapability', (int) $result->can_flash_upload === 1),
            'HasUrlUploadCapability' => new PermissionEntity('HasUrlUploadCapability', (int) $result->can_url_upload === 1),
            'FileExpirationLimit' => new PermissionEntity('FileExpirationLimit', new DateInterval("P{$result->file_expire}D")),
            'HasAdminCapability' =>new PermissionEntity('HasAdminCapability', (int) $result->admin === 1)
        )));

        return $group;
    }

    public function __construct()
    {
        $ci = &get_instance();

        $this->db = $ci->db;
    }

    public function findById($id)
    {
        $group = $this->db->get_where('groups', array('id' => $id))->row();

        return self::convertToEntity($group);
    }

    public function findAvailablePackages()
    {
        $groups = $this->db->get_where('groups', array('status' => 1))->result();

        return self::convertToEntities($groups);
    }
}