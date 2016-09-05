<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FormOfBusiness]].
 *
 * @see FormOfBusiness
 */
class FormOfBusinessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FormOfBusiness[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FormOfBusiness|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
