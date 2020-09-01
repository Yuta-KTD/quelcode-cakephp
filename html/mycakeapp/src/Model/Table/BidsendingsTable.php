<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bidsendings Model
 *
 * @property \App\Model\Table\BidinfosTable&\Cake\ORM\Association\BelongsTo $Bidinfos
 *
 * @method \App\Model\Entity\Bidsending get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bidsending newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bidsending[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bidsending|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidsending saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidsending patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bidsending[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bidsending findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BidsendingsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('bidsendings');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('Bidinfo', [
            'foreignKey' => 'bidinfo_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 30)
            ->requirePresence('phone_number', 'create')
            ->notEmptyString('phone_number')
            //電話番号のバリデーション（正規表現）
            ->add('phone_number', 'custom', [
                'rule' => function ($value, $context) {
                    return (bool) preg_match('/\A[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}\z/', $value);
                },
                'message' => '電話番号は全て半角、ハイフン込みで正しく入力ください。'
            ]);;

        $validator
            ->boolean('is_sent')
            ->requirePresence('is_sent', 'create')
            ->notEmptyString('is_sent');

        $validator
            ->boolean('is_received')
            ->requirePresence('is_received', 'create')
            ->notEmptyString('is_received');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['bidinfo_id'], 'Bidinfo'));

        return $rules;
    }
}
