<?php

namespace app\models;

use Yii;
use app\models\BaseModel;
use DateTime;
use DateTimeZone;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sort
 * @property string $name
 * @property string $unit
 * @property integer $last_amount
 * @property integer $total_amount
 * @property string $last_refill_time
 * @property string $est_refill_time
 * @property double $refill_frequency
 *
 * @property User $user
 * @property Refill[] $refills
 */
class Item extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'sort', 'last_amount', 'total_amount'], 'integer'],
            [['refill_frequency'], 'double'],
            [['first_refill_time', 'last_refill_time', 'est_refill_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 16],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'sort' => Yii::t('app/item', 'Order'),
            'name' => Yii::t('app/item', 'Item name'),
            'unit' => Yii::t('app/item', 'Unit'),
            'last_amount' => Yii::t('app/item', 'Last refilled amount'),
            'total_amount' => Yii::t('app/item', 'Total refilled amount'),
            'first_refill_time' => Yii::t('app/item', 'First refilling date'),
            'last_refill_time' => Yii::t('app/item', 'Last refilling date'),
            'est_refill_time' => Yii::t('app/item', 'Estimated next refilling date'),
            'refill_frequency' => Yii::t('app/item', 'Refill frequency'),
        ];
    }

    /**
     * @param boolean $runValidation
     * @param array $attributes
     * @return boolean
     */
    public function insert($runValidation = true, $attributes = null)
    {
        if (!isset($this->sort)) {
            $newItemOrder = Yii::$app->db->createCommand('SELECT (MAX(sort) + 1) AS newItemOrder FROM item')->queryScalar();
            $this->sort = isset($newItemOrder) ? intval($newItemOrder, 10) : 0;
        }
        return parent::insert($runValidation, $attributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefills()
    {
        return $this->hasMany(Refill::className(), ['item_id' => 'id']);
    }

    /**
     * @return string?
     */
    public function getFrequency()
    {
        if (!isset($this->refill_frequency, $this->last_amount, $this->unit)) {
            return null;
        }

        $freq = $this->refill_frequency * $this->last_amount;
        return $this->getFrequencyPeriodNotation($freq) . ' / ' . $this->last_amount . ' ' . $this->unit;
    }

    private function getFrequencyPeriodNotation($freq) {
        $freq /= 86400; // sec → day

        if ($freq > 28.5) {
            $weeks = round(10 * $freq / 30) / 10;
            return $weeks . 'ヶ月';
        }
        $days = round(10 * $freq) / 10;
        return $days . '日';
    }

    /**
     * 次回交換目安に応じた状態を返す
     * @return string
     */
    public function getStatus() {
        if (empty($this->est_refill_time)) {
            return 'unknown';
        }
        $now = time();
        $est = strtotime($this->est_refill_time);
        $exhausting = ($est - $now) / 86400;
        if ($exhausting < 1) {
            return 'stretto';
        } else if ($exhausting < 3.5) {
            return 'espresso';
        } else if ($exhausting < 7.5) {
            return 'andante';
        } else {
            return 'largo';
        }
    }

    /**
     * カンマ区切りのIDで並び順を更新する
     * @param string $aOrders カンマ区切りの item_id
     * @return boolean 成功なら true
     */
    public static function updateOrders($aOrders) {
        if (!preg_match('/\\A[1-9][0-9]*(?:,[1-9][0-9]*)*\\z/', $aOrders)) {
            return false;
        }

        $orders = explode(',', $aOrders);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $command = Yii::$app->db->createCommand('UPDATE item SET sort = :sort WHERE id = :id');
            foreach ($orders as $order => $id) {
                $command->bindValue(':sort', $order);
                $command->bindValue(':sort', $id);
                $command->execute();
            }
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

}
