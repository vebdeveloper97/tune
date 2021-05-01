<?php


namespace app\commands;


use Yii;
use yii\base\Event;
use yii\base\InvalidCallException;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class CustomBehaviors extends AttributeBehavior
{
    public string $createdByAttribute = '';
    public string $updatedByAttribute = '';

    public $value;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            if (!empty($this->updatedByAttribute)) {
                $this->attributes = [
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedByAttribute
                ];
            }
            if (!empty($this->createdByAttribute)) {
                $this->attributes = [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdByAttribute
                ];
            }
            if (!empty($this->createdByAttribute) && !empty($this->updatedByAttribute)) {
                $this->attributes = [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdByAttribute,
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedByAttribute,
                ];
            }
        }
    }


    /**
     * @param Event $event
     * @return array|int|mixed|string
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return strtotime(date('Y-m-d H:i:s'));
        }

        return parent::getValue($event);
    }

    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array)$attribute, $this->getValue(null)));
    }
}