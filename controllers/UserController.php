<?php
namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Users;
use yii\web\Response;
use yii\web\BadRequestHttpException;

class UserController extends Controller
{
     public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['http://localhost:5173'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Allow-Headers' => ['Authorization', 'Content-Type', 'X-Requested-With'],
                    'Access-Control-Allow-Origin' => true,
                ],
            ],
        ];
    }

    // SignUp API
    public function actionSignup()
    {
        $model = new Users();
        $data = Yii::$app->request->post();

        // Validate input data
        if (empty($data['email']) || empty($data['password_hash']) || empty($data['mobile_number'])) {
            throw new BadRequestHttpException('Missing required parameters.');
        }

        $model->attributes = $data;

        if ($model->save()) {
            return [
                'status' => 'success',
                'data' => [
                    'id' => $model->id,
                    'email' => $model->email,
                    'mobile_number' => $model->mobile_number,
                ],
            ];
        }

        return [
            'status' => 'error',
            'errors' => $model->errors,
        ];
    }

    // SignIn API
    public function actionSignin()
    {
        $email = Yii::$app->request->post('email');
        $password = Yii::$app->request->post('password_hash');

        if (!$email || !$password) {
            throw new BadRequestHttpException('Missing required parameters.');
        }

        $user = Users::findOne(['email' => $email]);

        if ($user && Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            return [
                'status' => 'SignIn Success',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'mobile_number' => $user->mobile_number,
                ],
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Invalid email or password',
        ];
    }
}
