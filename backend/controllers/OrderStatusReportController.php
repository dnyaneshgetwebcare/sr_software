<?php

namespace backend\controllers;

use Yii;
use backend\models\BookingHeader;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * OrderStatusReportController shows total earning amount grouped by order_status
 * from booking_header, filtered by month on pickup_date (skip = 0).
 */
class OrderStatusReportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['filter', 'report', 'orders'],
                        'allow' => true,
                        'roles' => ['reports'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Filter screen: Month + Year selector.
     */
    public function actionFilter()
    {
        $month = isset($_GET['month']) && $_GET['month'] !== '' ? $_GET['month'] : date('m');
        $year  = isset($_GET['year']) && $_GET['year'] !== '' ? $_GET['year'] : date('Y');

        return $this->render('filter', [
            'month' => $month,
            'year'  => $year,
        ]);
    }

    /**
     * Report screen: total earning_amount grouped by order_status
     * for booking_header rows whose pickup_date falls in the selected month
     * and skip = 0.
     */
    public function actionReport()
    {
        $request = Yii::$app->request;

        $month = $request->post('month', $request->get('month', date('m')));
        $year  = $request->post('year', $request->get('year', date('Y')));

        // Normalise (accept 1..12 as well as 01..12)
        $month = str_pad((string)(int)$month, 2, '0', STR_PAD_LEFT);
        $year  = (string)(int)$year;

        $monthYear = $month . '-' . $year;

        $rows = BookingHeader::find()
            ->select([
                'order_status',
                'SUM(earning_amount) AS total_earning',
            ])
            ->where('DATE_FORMAT(pickup_date, "%m-%Y") = :my', [':my' => $monthYear])
            ->andWhere(['skip' => 0])
            ->groupBy('order_status')
            ->orderBy(['order_status' => SORT_ASC])
            ->asArray()
            ->all();

        $dataProvider = new ArrayDataProvider([
            'allModels'  => $rows,
            'pagination' => false,
            'sort'       => false,
        ]);

        return $this->render('report', [
            'dataProvider' => $dataProvider,
            'month'        => $month,
            'year'         => $year,
        ]);
    }

    /**
     * JSON endpoint: list of bookings for a given month/year and order_status
     * (with skip = 0). Used by the report modal drill-down.
     */
    public function actionOrders()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $month = str_pad((string)(int)$request->get('month', date('m')), 2, '0', STR_PAD_LEFT);
        $year  = (string)(int)$request->get('year', date('Y'));
        $statusRaw = (string)$request->get('order_status', '');
        $monthYear = $month . '-' . $year;

        $query = BookingHeader::find()
            ->select(['booking_id', 'earning_amount'])
            ->where('DATE_FORMAT(pickup_date, "%m-%Y") = :my', [':my' => $monthYear])
            ->andWhere(['skip' => 0]);

        if ($statusRaw === '__blank__') {
            $query->andWhere(['or', ['order_status' => null], ['order_status' => '']]);
        } else {
            $query->andWhere(['order_status' => $statusRaw]);
        }

        $rows = $query->orderBy(['booking_id' => SORT_ASC])->asArray()->all();

        $total = 0.0;
        $orders = array_map(function ($r) use (&$total) {
            $amt = (float)$r['earning_amount'];
            $total += $amt;
            return [
                'booking_id'     => (int)$r['booking_id'],
                'earning_amount' => $amt,
            ];
        }, $rows);

        return [
            'orders' => $orders,
            'total'  => $total,
        ];
    }
}
