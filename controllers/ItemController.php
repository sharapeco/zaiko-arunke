<?php

namespace app\controllers;

use Yii;
use app\models\Item;
use app\models\ItemSearch;
use app\models\Refill;
use app\models\RefillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ItemController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        // この項目
        $item = $this->findModel($id);

        // 新規追加用
        $newRefill = new Refill();
        $newRefill->amount = $item->last_amount;
        $newRefill->refill_time_local = date('Y/m/d H:i');

        // 補充履歴
        $refillSearchModel = new RefillSearch();
        $refillSearchModel->item_id = $id;
        $refillsDataProvider = $refillSearchModel->search([]);

        return $this->render('view', [
            'item' => $item,
            'newRefill' => $newRefill,
            'refillsDataProvider' => $refillsDataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Item;

        // デフォルト値を設定する
        $model->unit = Yii::t('app/item', 'unit');

        // POSTされた場合は保存する
        if ($model->load(Yii::$app->request->post())) {
            // 値を設定する
            $model->user_id = Yii::$app->user->identity->id;

            if ($model->save()) {
                Yii::$app->session->setFlash("Entry-success", Yii::t('app/item', 'Item added'));
                return $this->redirect(['index']);
            } else {
                // error in saving model
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // POSTされた場合は保存する
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash("Entry-success", Yii::t('app/item', 'Item updated'));
                return $this->redirect(['view', 'id' => $id]);
            } else {
                // error in saving model
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Refill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash("Entry-success", Yii::t('app/item', 'Item deleted'));
        return $this->redirect(['index']);
    }

    public function actionSort()
    {
        $items = Item::find()->orderBy(['sort' => SORT_ASC])->all();
        if (count($items) < 2) {
            return $this->redirect(['index']);
        }

        if (($post = Yii::$app->request->post()) && isset($post['orders'])) {
            if (Item::updateOrders($post['orders'])) {
                Yii::$app->session->setFlash("Entry-success", Yii::t('app/item', 'Order changed'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash("Entry-danger", Yii::t('app', 'Failed to change order'));
                return $this->redirect(['sort']);
            }
        }

        $keys = array_map(function($item) {
            return $item->id;
        }, $items);

        $contents = array_map(function($item) {
            return [
                'content' => $item->name,
            ];
        }, $items);

        return $this->render('sort', [
            'items' => array_combine($keys, $contents),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) === null) {
            throw new NotFoundHttpException('The page you requested is not available or does not exist.');
        } else if ($model->user_id != Yii::$app->user->id) {
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        } else {
            return $model;
        }
    }

}
