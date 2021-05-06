<?php


namespace app\commands;


use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\captcha\CaptchaAction;

class CaptchaHelper extends CaptchaAction
{
    private $code;
    public $foreColor = 0x003c7b;

    public function __construct()
    {
        $this->init();
        $id = Yii::$app->controller->action->id;
        $controller = Yii::$app->controller;
        parent::__construct($id, $controller);
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function generateImage(): string
    {
        $code = $this->generateCode();
        $base64 = 'data:image/png;base64,'.base64_encode($this->renderImage($code));
        Yii::$app->cache->set($this->generateSessionKey($code), $code, 60);
        return $base64;
    }

    /**
     * @return int|string
     * @throws \Exception
     */
    public function generateCode()
    {
        if ($this->code) {
            return $this->code;
        }

        return $this->code = $this->generateVerifyCode();
    }

    /**
     * @return int|string
     * @throws \Exception
     */
    protected function generateVerifyCode()
    {
        $length = 4;
        $digits = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $digits[random_int(0, 9)];
        }

        if (YII_DEBUG) {
            $code = '1111';
        }

        return $code;
    }

    /**
     * @param $code
     * @return bool
     * @throws Exception
     */
    public function verify(string $code): bool
    {
        if (Yii::$app->cache->get($this->generateSessionKey($code)) === $code) {
            return true;
        }

        throw new Exception("Code is not valid \"{$code}\"");
    }

    /**
     * @param string $code
     * @return string
     */
    private function generateSessionKey(string $code): string
    {
        return base64_encode(Yii::$app->request->getRemoteIP() . Yii::$app->request->getUserAgent() . $code);
    }
}