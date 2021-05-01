<?php


namespace app\modules\api\filters;


use app\modules\api\forms\PostForm;
use app\modules\api\resources\PostResource;
use yii\data\ActiveDataProvider;

class PostSearchFilters extends PostForm
{
    public $id;
    public $user_id;
    public $status;
    public $updated_at;
    public $title;
    public $text;
    public $date;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'status', 'updated_at'], 'integer'],
            [['title', 'text'], 'string'],
            [['date'], 'date', 'format' => 'php:d.m.Y']
        ];
    }


    /**
     * @param array $params
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function search($params = [], int $pageSize = 20): ActiveDataProvider
    {
        $query = PostResource::find()->joinWith('user');

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%post}}.id'      => $this->id,
            '{{%post}}.user_id' => $this->user_id,
            'date'              => $this->date,
            'status'            => $this->status,
            'updated_at'        => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}