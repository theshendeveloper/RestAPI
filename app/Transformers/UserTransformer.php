<?php

namespace App\Transformers;

use App\User;
use Illuminate\Support\Facades\Schema;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'verified_at' => (string)$user->email_verified_at,
            'isAdmin' => ($user->admin ==='true'),
            'createDate' => $user->created_at,
            'lastChange' => $user->updated_at,
            'deletedDate' => isset($user->deleted_at) ? (string) $user->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show', $user->id),
                ],
            ]

        ];
    }
    public static function originalAttribute($index)
    {

        $attributes = [
            'verified_at' => 'email_verified_at',
            'createDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' =>  'deleted_at',

        ];
        if (!Schema::hasColumn('users',$index) and !isset($attributes[$index])){
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
    public static function transformedAttribute($index)
    {

        $attributes = [
            'email_verified_at' => 'verified_at',
            'created_at' => 'createDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',

        ];
        if (!Schema::hasColumn('users',$index) and !isset($attributes[$index])){
            return null;
        }
        return isset($attributes[$index]) ? $attributes[$index] : $index;
    }
}
