<?php

class Base_Model extends Eloquent
{
    /**
     * バリデーションのルールを表す配列です
     * 遅延性的束縛を用いているので、継承した子モデル側に記述します
     *
     * 例）
     * array(
     *      param_name1 => 'required|max:255',
     *      param_name2 => 'unique:users,email_address',
     *      ...
     * )
     *
     * @var array
     */
    protected static $rules = array();

    /**
     * モデルがリクエストから取り出すパラメータのリストです
     * バリデーションルールのキーを返しますので、
     * ルールを一つ以上設定しないと受け取れません
     *
     * @return array
     */
    public static function knownParams()
    {
        return array_keys(static::$rules);
    }

    /**
     * リクエストデータから必要なパラメータを抽出します
     *
     * @param array $data
     * @return array
     */
    public static function extractParams(array $data)
    {
        $tmp = array();
        foreach (self::knownParams() as $param) {
            if (array_key_exists($param, $data)) {
                $tmp[$param] = $data[$param];
            }
        }
        return $tmp;
    }

    /**
     * データを渡してバリデーションを実行します
     * 成功時にバリデーションを通過したパラメータを、失敗時に false を返します
     *
     * @param array $input 省略時は Input::all()
     * @return array|bool
     */
    public static function validate(array $input = null)
    {
        if (is_null($input)) {
            $input = Input::all();
        }
        $params = self::extractParams($input);
        $v = Validator::make($params, static::$rules);
        if ($v->passes()) {
            return $params;
        }
        self::flashErrorMessages($v);
        return false;
    }

    /**
     * バリデーション失敗時のエラーメッセージをSessionに詰めます
     *
     * @param Validator $v
     */
    protected  static function flashErrorMessages(Validator $v)
    {
        $errors = $v->errors;
        foreach (self::knownParams() as $param) {
            if ($errors->has($param)) {
                $msg = '<span class="label label-warning">Check</span> ';
                $msg .= implode('<br/>', $errors->get($param));
                Session::flash('invalid_'.$param, "<div class='alert alert-error'>{$msg}</div>");
            }
        }
    }
}
