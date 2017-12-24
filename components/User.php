<?php

namespace app\components;
use amnah\yii2\user\components\User as BaseUser;

class User extends BaseUser
{
    /**
     * @var array the configuration of the identity cookie. This property is used only when [[enableAutoLogin]] is `true`.
     * @see Cookie
     */
    public $identityCookie = ['name' => '_zaiko_arunke_identity', 'httpOnly' => true];

}
