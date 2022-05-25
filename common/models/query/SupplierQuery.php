<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\entity\Supplier]].
 *
 * @see \common\models\entity\Supplier
 */
class SupplierQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\entity\Supplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\entity\Supplier|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
