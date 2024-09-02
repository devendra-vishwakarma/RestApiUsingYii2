<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Coin extends ActiveRecord
{
      public static function tableName()
    {
        return 'coin'; // The name of the table in the database
    }
    public function rules()
    {
        return [
            [['id', 'name', 'symbol', 'image', 'current_price', 'market_cap', 'price_change_percentage_24h'], 'required'],
            ['id', 'string', 'max' => 50],
            ['name', 'string', 'max' => 255],
            ['symbol', 'string', 'max' => 10],
            ['image', 'string', 'max' => 255],
            ['current_price', 'number'],
            ['market_cap', 'integer'],
            ['price_change_percentage_24h', 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'symbol' => 'Symbol',
            'image' => 'Image',
            'current_price' => 'Current Price',
            'market_cap' => 'Market Cap',
            'price_change_percentage_24h' => 'Price Change Percentage (24h)',
        ];
    }


}
