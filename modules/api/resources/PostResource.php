<?php


namespace app\modules\api\resources;


use app\models\Post;

class PostResource extends Post
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id',
            'title',
            'text',
            'user' => function () {
                return [
                    'id'       => $this->user->id ?? '',
                    'username' => $this->user->username ?? ''
                ];
            }
        ];
    }
}