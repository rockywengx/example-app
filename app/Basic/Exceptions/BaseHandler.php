 <?php
/*
namespace App\Basic\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use App\Basic\Http\Controllers\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BaseHandler extends ExceptionHandler
{
    use ApiResponse;


    public function handlerQuery(Request $request, Throwable $exception): Response|null
    {
        if ($exception instanceof \Illuminate\Database\QueryException) {
            $exception->getTrace();
            $data = [];
            if (env('APP_DEBUG')) {
                $data = ['msg' => $exception->getMessage(), 'sql' => $exception->getSql(), 'value' => $exception->getBindings()];
            }
            // return $msg('資料庫錯誤', $data);
            return $this->error('資料庫錯誤' , 500);
        }
        return null;
    }

    public function handler405(Request $request, Throwable $exception): Response|null
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return $this->error($exception->getMessage(), 404);
        }
        return null;
    }

    public function handler404(Request $request, Throwable $exception): Response|null
    {
        if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
            return $this->error($exception->getMessage(), 404);
        }
        return null;
    }

    public function handler400(Request $request, Throwable $exception): Response|null
    {
        if ($exception instanceof \InvalidArgumentException) {
            return $this->error($exception->getMessage(), 404);
        }
        return null;
    }

    public function handler401(Request $request, Throwable $exception): Response|null
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return $this->error($exception->getMessage(), 401);
        }
        return null;
    }


    public function handlerValidated(Request $request, Throwable $exception): Response|null
    {
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $errorMsg = [];
            $originFailRule = $exception->validator->failed();
            foreach ($originFailRule as $colName => $faileRules) {
                $rule = [];
                foreach ($faileRules as $faileRule => $value) {
                    switch ($faileRule) {
                        case 'Required':
                            $faileRuleTitle = '沒有資料';
                            break;

                        case 'Email':
                            $faileRuleTitle = '不是正常的電子郵件地址';
                            break;

                        case 'Numeric':
                            $faileRuleTitle = '內容非數字';
                            break;

                        case 'Min':
                            $faileRuleTitle = '內容或長度未達最小值';
                            break;

                        case 'Max':
                            $faileRuleTitle = '內容或長度超過最大值';
                            break;

                        default:
                            $faileRuleTitle = '不符合 ' . $faileRule . ' 規則';
                            break;
                    }
                    $rule[] = $faileRuleTitle . ($value ? ('(' . implode($value) . ')') : '');
                }
                $errorMsg[] = $colName . ' 驗證錯誤：' . implode('、', $rule);
            }
            // dump($exception->validator->failed());
            $errorMessageData = $exception->validator->getMessageBag();
            // 規則用陣列 'faileRules' => $originFailRule,

            return $this->success(['msg' => $errorMessageData->getMessages()], implode(PHP_EOL, $errorMsg));
        }
        return null;
    }


    public function render($request, Throwable $exception): Response
    {
        if ($request->is('api/*')) {

            $authenticationException = $this->handler401($request, $exception);
            if(!is_null($authenticationException)) return $authenticationException;

            $queryException = $this->handlerQuery($request, $exception);
            if(!is_null($queryException)) return $queryException;

            $methodNotAllowedException = $this->handler405($request, $exception);
            if(!is_null($methodNotAllowedException)) return $methodNotAllowedException;

            $notFoundException = $this->handler404($request, $exception);
            if(!is_null($notFoundException)) return $notFoundException;

            $InvalidArgumentException = $this->handler400($request, $exception);
            if(!is_null($InvalidArgumentException)) return $InvalidArgumentException;
            // return $msg('');
        }
        Log::error($exception->getMessage());

        return parent::render($request, $exception);
    }
} */
