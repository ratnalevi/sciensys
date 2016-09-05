<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TypeOfBusiness]].
 *
 * @see TypeOfBusiness
 */
class TypeOfBusinessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TypeOfBusiness[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TypeOfBusiness|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
