<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bidrating Entity
 *
 * @property int $id
 * @property int $bidinfo_id
 * @property int $rate_user_id
 * @property int $is_rated_user_id
 * @property int $rating
 * @property string $comment
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\Bidinfo $bidinfo
 * @property \App\Model\Entity\User $user
 */
class Bidrating extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'bidinfo_id' => true,
        'rate_user_id' => true,
        'is_rated_user_id' => true,
        'rating' => true,
        'comment' => true,
        'created' => true,
        'bidinfo' => true,
        'user' => true,
    ];
}
