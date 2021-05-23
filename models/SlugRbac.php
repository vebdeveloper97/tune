<?php


namespace app\models;


use yii\base\Model;
class SlugRbac extends Model
{
    const AUTH_ITEM = 'auth-item';
    const AUTH_ASSIGNMENT = 'auth-assignment';
    const AUTH_ITEM_CHILD = 'auth-item-child';
    const AUTH_RULE = 'auth-rule';
}