<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\TemplateCosts;
use app\models\TemplateProfit;
use app\models\Plan;
use app\models\PlanMonth;
use app\models\CostsPlan;

/**
 * Команды по распределению финансов
 */
class CommandController extends Controller
{
    /**
     * Формирование плана на Год
     */
    public function actionYearPlan()
    {
        // Получить шаблоны расходов и доходов
        $templateCosts = TemplateCosts::find()->asArray()->all();
        $templateProfit = TemplateProfit::find()->asArray()->all();

        // Почистить базу от старых записей
        Plan::deleteAll('date >= :date', ['date' => date('Yn')]);

        // Занести план на каждый месяц начиная от текущего включительно
        $months = range(date('n'), 12, 1);
        foreach ($months as $month) {
            foreach ($templateCosts as $item) {
                $costs = new Plan();
                $costs->total = $item['total'];
                $costs->name = $item['name'];
                $costs->type = 'COST';
                $costs->date = date('Y') . $month;
                $costs->save();
            };

            foreach ($templateProfit as $item) {
                $costs = new Plan();
                $costs->total = $item['total'];
                $costs->name = $item['name'];
                $costs->type = 'PROFIT';
                $costs->date = date('Y') . $month;
                $costs->save();
            }
        }

        echo 'План на год успешно сформирован.';
    }

    /**
     * Формирование плана на все месяцы в году
     */
    public function actionMonthPlan()
    {
        $plan = Plan::find('date >= :datestart AND date <= :dateend',
            ['datestart' => date('Y') . '1', 'dateend' => date('Y' . '12')])->asArray()->all();
        $data = [];
        foreach ($plan as $item) {
            if ($item['type'] == 'COST') {
                if (@isset($data[$item['date']]['totalCosts']))
                    $data[$item['date']]['totalCosts'] += $item['total'];
                else
                    $data[$item['date']]['totalCosts'] = $item['total'];
            } elseif ($item['type'] == 'PROFIT') {
                if (@isset($data[$item['date']]['totalProfit']))
                    $data[$item['date']]['totalProfit'] += $item['total'];
                else
                    $data[$item['date']]['totalProfit'] = $item['total'];
            }
        }

        foreach ($data as $date => $monthPlan) {
            // Дельта составляет свободный остаток, который может быть потрачен
            $delta = $monthPlan['totalProfit'] - $monthPlan['totalCosts'];

            if (($delta) < 0)
                die('Доходы выше расходов. Хватит так жить.');

            // Почистить базу от старых записей
            PlanMonth::deleteAll('date = :date', ['date' => $date]);

            // Количество дней в месяце
            $days = cal_days_in_month(CAL_GREGORIAN, substr($date, 4), date('Y'));

            // Цена одного дня в месяце
            $dayCost = floor($delta / $days);

            $planMonth = new PlanMonth;
            $planMonth->totalCosts = $monthPlan['totalCosts'];
            $planMonth->totalProfit = $monthPlan['totalProfit'];
            $planMonth->dayCost = $dayCost;
            $planMonth->date = $date;

            if (!$planMonth->save()) {
                var_dump($planMonth->getErrors());
                die('В базе ошибка');
            }
        }

    }

    /**
     * Формирование плана понедельно
     */
    public function actionWeekPlan()
    {
        $planMonth = PlanMonth::find('date >= :datestart AND date <= :dateend',
            ['datestart' => date('Y') . '1', 'dateend' => date('Y' . '12')])->asArray()->all();

        foreach ($planMonth as $month) {
            $totalMonth[substr($month['date'], 4)] = $month['dayCost'];
        }

        $data = [];
        $minus = 1 - date('N');
        for ($day = $minus; $day < 0; $day++) {
            $time = strtotime($day . ' day');
            $data[date('W', $time)][] = [
                'date' => date('Y-m-d', $time),
                'cost' => $totalMonth[date('n', $time)]
            ];
        }

        $data[date('W')][] = [
            'date' => date('Y-m-d'),
            'cost' => $totalMonth[date('n')]
        ];

        // Дней осталось
        $dayLost = 365 - date('z');
        $week = date('W');

        for ($i = 1; $i < $dayLost; $i++) {
            $time = strtotime('+' . $i . ' day');

            // На случай, если даты текущего месяца находятся в следующем году
            if (date('W', $time) < $week)
                break;

            $data[date('W', $time)][] = [
                'date' => date('Y-m-d', $time),
                'cost' => $totalMonth[date('n', $time)]
            ];

            // Для контроля дат
            $week = date('W', $time);
        }

        CostsPlan::deleteAll('week >= :week AND year = :year', ['week' => date('W'), 'year' => date('Y')]);

        foreach ($data as $weekNumber => $weekData) {
            $costPlan = new CostsPlan();
            $costPlan->week = $weekNumber;
            $costPlan->totalCost = 0;
            $costPlan->factCost = 0;
            $costPlan->factBalance = 0;
            $costPlan->year = date('Y');
            $costPlan->startWeek = $weekData[0]['date'];
            $costPlan->endWeek = $weekData[6]['date'];

            foreach ($weekData as $week) {
                $costPlan->totalCost += $week['cost'];
            }

            if (!$costPlan->save())
                die(var_export($costPlan->errors, true));
        }
    }
}
