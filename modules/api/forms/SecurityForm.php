<?php


namespace app\modules\api\forms;


use app\commands\CaptchaHelper;
use app\modules\api\resources\UserResource;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;

class SecurityForm extends BaseForm
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $auth_token = null;
    public ?string $code;

    public const SCENARIO_LOGIN = 'login';
    public const SCENARIO_RESET_PASSWORD = 'reset password';

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['username', 'password', 'code'], 'required', 'on' => self::SCENARIO_LOGIN],
            [['password'], 'required', 'on' => self::SCENARIO_RESET_PASSWORD],
            ['auth_token', 'string', 'max' => 100],
            ['code', 'checkCaptcha']
        ];
    }

    /**
     * @param $attribute
     */
    public function checkCaptcha($attribute): void
    {
        $captcha = new CaptchaHelper();
        if ($this->scenario == self::SCENARIO_LOGIN) {
            try {
                $captcha->verify($this->code);
            } catch (Exception $e) {
                $this->addError($attribute, Yii::t('app', 'Captcha is invalid code!'));
            }
        }
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_LOGIN          => ['username', 'password', 'code'],
            self::SCENARIO_RESET_PASSWORD => ['password']
        ]);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            $this->addError('username', "validate error {$this->getErrorMessage($this->firstErrors)}");
            return false;
        }

        $user = UserResource::findOne(['username' => $this->username]);

        if ($user === null) {
            $this->addError('username', "username error {$this->username}");
            return false;
        }

        if (Yii::$app->security->validatePassword($this->password, $user->password)) {
            $user->generateToken();

            if (!$user->save()) {
                $this->addError('username', "try again error {$this->getErrorMessage($this->firstErrors)}");
                return false;
            }

            $this->auth_token = $user->auth_token;
            return true;
        }

        $this->addError('username', "username or password error");
        return false;
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function makeCaptcha(): string
    {
        return (new CaptchaHelper())->generateImage();
    }

}