<?php

namespace app\models;

use Yii;
use app\models\Item;
use DateTime;
use DateTimeZone;

/**
 * 日付時間型をローカル時間で扱えるようにするクラス
 */
abstract class BaseModel extends \yii\db\ActiveRecord
{
    /**
     * @var array 日付時間型のカラム名のリスト
     */
    protected static $datetimeColumns = [];

    /**
     * @var string ローカル時間のカラム名の接尾辞
     */
    protected static $localDatetimeSuffix = '_local';

    /**
     * @param string $column
     * @return string? $sourceColumn
     */
    protected function sourceColumn($column) {
        $columnLength = strlen($column) - strlen(static::$localDatetimeSuffix);
        if (strpos($column, static::$localDatetimeSuffix) !== $columnLength) {
            return null;
        }
        $sourceColumn = substr($column, 0, $columnLength);
        if (!in_array($sourceColumn, static::$datetimeColumns, true)) {
            return null;
        }
        return $sourceColumn;
    }

    public function __get($column) {
        if (($sourceColumn = $this->sourceColumn($column))) {
            if (empty($this->$sourceColumn)) {
                return '';
            }
            $localTimezone = new DateTimezone(date_default_timezone_get());
            $UTC = new DateTimeZone('UTC');
            $date = new DateTime($this->$sourceColumn, $UTC);
            $date->setTimezone($localTimezone);
            return $date->format('Y/m/d H:i:s');
        } else {
            return parent::__get($column);
        }
    }

    public function __set($column, $value) {
        if (($sourceColumn = $this->sourceColumn($column))) {
            if (empty($value)) {
                $this->$sourceColumn = '';
                return;
            }
            $localTimezone = new DateTimezone(date_default_timezone_get());
            $UTC = new DateTimeZone('UTC');
            $date = new DateTime($value, $localTimezone);
            $date->setTimezone($UTC);
            $this->$sourceColumn = $date->format('Y/m/d H:i:s');
        } else {
            parent::__set($column, $value);
        }
    }

    public function __isset($column) {
        if (in_array($column, static::$datetimeColumns, true)) {
            return true;
        } else {
            return parent::__isset($column);
        }
    }

}
