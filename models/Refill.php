<?php

namespace app\models;

use Yii;
use app\models\Item;
use app\models\BaseModel;
use DateTime;
use DateTimeZone;

/**
 * This is the model class for table "refill".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $amount
 * @property string $refill_time
 * @property string $refill_time_local
 *
 * @property Item $item
 */
class Refill extends BaseModel
{
    /**
     * @var array 日付時間型のカラム名のリスト
     */
    protected static $datetimeColumns = ['refill_time'];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'amount', 'refill_time'], 'required'],
            [['item_id', 'amount'], 'integer'],
            [['refill_time', 'refill_time_local'], 'safe'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => '項目ID',
            'amount' => '補充数',
            'refill_time' => '交換日時',
            'refill_time_local' => '交換日時',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
    
    /**
     * @param boolean $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        $this->updateItemRefillInformation();
    }
    
    /**
     * 「項目」の情報を更新する
     */
    protected function updateItemRefillInformation() {
        $item = Item::findOne($this->item_id);
        if (!$item) {
            throw new RuntimeException('Item not found.');
        }
        
        $refills = Refill::find()
            ->where(['item_id' => $this->item_id])
            ->all();

        $minTime = $this->refill_time;
        $maxTime = $this->refill_time;
        $lastAmount = $this->amount;
        $totalAmount = 0;
        foreach ($refills as $refill) {
            if (strcmp($refill->refill_time, $minTime) < 0) {
                $minTime = $refill->refill_time;
            } else if (strcmp($refill->refill_time, $maxTime) > 0) {
                $maxTime = $refill->refill_time;
                $lastAmount = $refill->amount;
            }
            $totalAmount += $refill->amount;
        }
        $item->first_refill_time = $minTime;
        $item->last_refill_time = $maxTime;
        $item->last_amount = $lastAmount;
        $item->total_amount = $totalAmount;

        $UTC = new DateTimeZone('UTC');
        $min = new DateTime($minTime, $UTC);
        $max = new DateTime($maxTime, $UTC);
        $interval = $max->getTimestamp() - $min->getTimestamp();
        if ($interval > 0) {
            // 次回交換日を推測する
            $usedAmount = $totalAmount - $lastAmount;
            $frequency = $interval / $usedAmount;
            $estTime = (integer)round($max->getTimestamp() + $frequency * $lastAmount);
            $est = new DateTime('@' . $estTime, $UTC);
            
            $item->est_refill_time = $est->format('Y-m-d H:i:s');
            $item->refill_frequency = $frequency;
        }
        $item->save();
    }
}
