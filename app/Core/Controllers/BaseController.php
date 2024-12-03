<?php

namespace App\Core\Controllers;

use App\Core\Traits\ApiResponse;
use App\Core\Traits\ExceptionHandler;
use App\Core\Traits\ImageUpload;
use App\Core\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * [abstract class BaseController]
 */
abstract class BaseController extends Controller
{
    use ImageUpload;
    use ApiResponse;
    use ExceptionHandler;
    use ResponseMessage;

    /**
     * model
     *
     * @deprecated This variable will be deprecated in next version
     *
     * @var [object]
     */
    public $model;

    /**
     * Resource transformer
     *
     * @deprecated This variable will be deprecated in next version
     *
     * @var [object]
     */
    protected $transformer;
    /**
     * Service class
     *
     * @deprecated This variable will be deprecated in next version
     *
     * @var [object]
     */
    protected $service;

    protected array $responseMessages;
    protected array $exceptionMessages;
    protected array $exceptionStatusCodes;
    protected ?string $modelName = null;

    /**
     * Resource transformer
     *
     * @deprecated This variable will be deprecated in next version
     *
     * @var [object]
     */
    protected array $policies = [];

    public function __construct()
    {
        $this->modelName = $this->modelName ?? Str::headline(Str::replace("Controller", "", class_basename($this)));
        $this->responseMessages = array();
        $this->exceptionStatusCodes = array();
        $this->exceptionMessages = [
            ModelNotFoundException::class => $this->lang("not-found"),
        ];
    }

    /**
     * handleException handles the exception and formats exception code and messages.
     *
     * @param  object $exception
     * @return JsonResponse
     */
    public function handleException(object $exception): JsonResponse|array
    {
        if ($path = session()->pull("filepath")) {
            $this->deleteImage($path);
        }
        // Set exception logs.
        $this->setFatalExceptionLog($exception);

        // returns exception in proper API format.
        return $this->errorResponse(
            message: $this->getExceptionMessage($exception),
            responseCode: $this->getExceptionStatus($exception)
        );
    }


    protected function view(string $view, array $data = [])
    {
        $commonData = $this->commonData();
        $data = array_merge($data, $commonData);
        return view($view, $data);
    }

    protected function allow(string $functionName): void
    {
        $originalNamespace = get_called_class();
        $convertedNamespace = strtolower(str_replace('\\', '.', $originalNamespace));

        $permission = "{$convertedNamespace}.{$functionName}";

        $authRole = auth()->user()->role?->slug;
        $permissions = config("permissions")[$authRole] ?? [];

        if (!in_array($permission, $permissions)) {
            abort(403);
        }
    }
}
