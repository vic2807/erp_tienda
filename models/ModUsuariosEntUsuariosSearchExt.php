<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ModUsuariosEntUsuariosSearch;

/**
 * ModUsuariosEntUsuariosSearch represents the model behind the search form of `app\models\ModUsuariosEntUsuarios`.
 */
class ModUsuariosEntUsuariosSearchExt extends ModUsuariosEntUsuariosSearch
{
    /**
     * {@inheritdoc}
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
        $query = ModUsuariosEntUsuarios::find();

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
            'id_usuario' => $this->id_usuario,
            'fch_creacion' => $this->fch_creacion,
            'fch_actualizacion' => $this->fch_actualizacion,
            'id_status' => $this->id_status,
            'b_remember_me' => $this->b_remember_me,
            'id_rol_usuario' => $this->id_rol_usuario,
        ]);

        $query->andFilterWhere(['like', 'txt_token', $this->txt_token])
            ->andFilterWhere(['like', 'txt_imagen', $this->txt_imagen])
            ->andFilterWhere(['like', 'txt_username', $this->txt_username])
            ->andFilterWhere(['like', 'txt_apellido_paterno', $this->txt_apellido_paterno])
            ->andFilterWhere(['like', 'txt_apellido_materno', $this->txt_apellido_materno])
            ->andFilterWhere(['like', 'txt_auth_key', $this->txt_auth_key])
            ->andFilterWhere(['like', 'txt_password_hash', $this->txt_password_hash])
            ->andFilterWhere(['like', 'txt_password_reset_token', $this->txt_password_reset_token])
            ->andFilterWhere(['like', 'txt_email', $this->txt_email])
            ->andFilterWhere(['like', 'txt_password', $this->txt_password]);

        return $dataProvider;
    }
}
