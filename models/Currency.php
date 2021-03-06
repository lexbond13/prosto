<?php

namespace app\models;

use SimpleXMLElement;
use Yii;
use yii\base\ErrorException;
use yii\web\HttpException;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property string $rate
 */
class Currency extends \yii\db\ActiveRecord
{
    const CURRENCY_URL = "http://www.cbr.ru/scripts/XML_daily.asp";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название валюты',
            'rate' => 'Курс',
        ];
    }

    /**
     * @return SimpleXMLElement
     * @throws HttpException
     */
    private function getCurrenciesFromSite()
    {
        try {
            $data = file_get_contents(self::CURRENCY_URL);
            $xml = new SimpleXMLElement($data);
            if(isset($xml->Valute[0]->Name) && isset($xml->Valute[0]->Value)) {
                return $xml;
            } else {
                throw new HttpException(400, 'Неверная структура файла валют');
            }
        } catch (ErrorException $e) {
            throw new HttpException(400, "Не могу получить доступ к ресурсу ".self::CURRENCY_URL.". Ошибка: $e");
        }
    }

    /**
     * @throws HttpException
     */
    public function updateCurrencies()
    {
        if($currency_data = $this->getCurrenciesFromSite()) {
            $added = 0;
            $updated = 0;

            $currencies_from_db = $this->getCurrenciesFromDb();

            foreach ($currency_data as $item) {

                $key = strval($item->Name);

                if(array_key_exists($key, $currencies_from_db)) {
                    $model = $currencies_from_db[$key];
                    $rate = $this->toDecimal($item->Value);
                    if($model->rate!=$rate) {
                        $model->rate = $rate;
                        $model->save();
                        $updated++;
                    }

                } else {
                    $model = new self();
                    $model->name = $this->toString($item->Name);
                    $model->rate = $this->toDecimal($item->Value);
                    $model->save();
                    $added++;
                }
            }
            return "Добавлено: $added, Обновлено: $updated \n";
        } else {
            return "Не могу получить данные о курсах валют \n";
        }
    }

    /**
     * @param $val
     * @return mixed
     */
    private function toDecimal($val)
    {
        return floatval($val);
    }

    private function toString($val)
    {
        return strval($val);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCurrenciesFromDb()
    {
        return self::find()
            ->indexBy('name')
            ->all();
    }
}
