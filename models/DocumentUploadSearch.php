<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocumentUpload;

/**
 * DocumentUploadSearch represents the model behind the search form about `app\models\DocumentUpload`.
 */
class DocumentUploadSearch extends DocumentUpload
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['archivoprograma_id', 'programa_id', 'usuario_id', 'estado_id'], 'integer'],
            [['archivo', 'fecha', 'mode_reg'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DocumentUpload::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'archivoprograma_id' => $this->archivoprograma_id,
            'programa_id' => $this->programa_id,
            'usuario_id' => $this->usuario_id,
            'estado_id' => $this->estado_id,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'archivo', $this->archivo])
            ->andFilterWhere(['like', 'mode_reg', $this->mode_reg]);

        return $dataProvider;
    }
        
	public function searchPorIdPrograma($idprograma){
        $query = DocumentUpload::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'programa_id' => $idprograma,

        ]);

        return $dataProvider;
    }

}
