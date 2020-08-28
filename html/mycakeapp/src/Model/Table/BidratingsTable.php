<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bidratings Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Bidinfo
 * @property &\Cake\ORM\Association\BelongsTo $Users
 * @property &\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Bidrating get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bidrating newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bidrating[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bidrating|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidrating saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bidrating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bidrating[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bidrating findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BidratingsTable extends Table
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

        $this->setTable('bidratings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Bidinfo', [
            'foreignKey' => 'bidinfo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RateUsers', [
            'className' => 'Users',
            'foreignKey' => 'rate_user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('IsRatedUsers', [
            'className' => 'Users',
            'foreignKey' => 'is_rated_user_id',
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
            ->integer('rating')
            ->requirePresence('rating', 'create')
            ->notEmptyString('rating')
            ->add('rating', 'custom', [
                'rule' => function ($value, $context) {
                    return (bool) preg_match('/\A[1-5]{1}\z/', $value);
                },
                'message' => '評価は1-5までの数値で入力ください。'
            ]);;

        $validator
            ->scalar('comment')
            ->maxLength('comment', 1000)
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

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
        $rules->add($rules->existsIn(['rate_user_id'], 'RateUsers'));
        $rules->add($rules->existsIn(['is_rated_user_id'], 'IsRatedUsers'));

        return $rules;
    }
}
