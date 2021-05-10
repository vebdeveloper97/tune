<?php


namespace app\modules\api\forms;


use app\modules\api\resources\PostResource;

class PostForm extends BaseForm
{
    /**
     * @param array $params
     * @param null $id
     * @return array
     */
    public function update($params = [], $id = null): array
    {
        if ($id !== null) {
            $model = PostResource::findOne(['id' => $id]);
            $model->load($params,'');
            if ($model->save()) {
                return [
                    'message' => 'data update',
                    'id' => $model->id
                ];
            }
        } else {
            $model = new PostResource();
            $model->load($params,'');
            if ($model->save()) {
                return [
                    'message' => 'data created!',
                    'id' => $model->id
                ];
            }
        }
    }
}