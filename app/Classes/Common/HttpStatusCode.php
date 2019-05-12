<?php namespace App\Classes\Common;

class HttpStatusCode
{
    const STATUS_0_NONE = 0;
    const STATUS_1_UNKNOWN = 1;

    const STATUS_200_OK = 200;
    const STATUS_201_CREATED = 201;
    const STATUS_202_ACCEPTED = 202;
    const STATUS_203_NON_AUTHORITATIVE_INFORMATION = 203;
    const STATUS_204_NO_CONTENT = 204;
    const STATUS_205_RESET_CONTENT = 205;
    const STATUS_206_PARTIAL_CONTENT = 206;
    const STATUS_207_MULTI_STATUS = 207;

    const STATUS_300_MULTIPLE_CHOICES = 300;
    const STATUS_301_MOVED_PERMANENTLY = 301;
    const STATUS_302_FOUND = 302;
    const STATUS_303_SEE_OTHER = 303;
    const STATUS_304_NOT_MODIFIED = 304;
    const STATUS_305_USE_PROXY = 305;
    const STATUS_306_SWITCH_PROXY = 306;
    const STATUS_307_TEMPORARY_REDIRECT = 307;

    const STATUS_400_BAD_REQUEST = 400;
    const STATUS_401_UNAUTHORIZED = 401;
    const STATUS_402_PAYMENT_REQUIRED = 402;
    const STATUS_403_FORBIDDEN = 403;
    const STATUS_404_NOT_FOUND = 404;
    const STATUS_405_METHOD_NOT_ALLOWED = 405;
    const STATUS_406_NOT_ACCEPTABLE = 406;
    const STATUS_407_PROXY_AUTHENTICATION_REQUIRED = 407;
    const STATUS_408_REQUEST_TIMEOUT = 408;
    const STATUS_409_CONFLICT = 409;
    const STATUS_410_GONE = 410;
    const STATUS_411_LENGTH_REQUIRED = 411;
    const STATUS_412_PRECONDITION_FAILED = 412;
    const STATUS_413_REQUEST_ENTITY_TOO_LARGE = 413;
    const STATUS_414_REQUEST_URI_TOO_LONG = 414;
    const STATUS_415_UNSUPPORTED_MEDIA_TYPE = 415;
    const STATUS_416_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const STATUS_417_EXPECTATION_FAILED = 417;
    const STATUS_418_IM_A_TEAPOT = 418;
    const STATUS_421_THERE_ARE_TOO_MANY_CONNECTIONS_FROM_YOUR_INTERNET_ADDRESS = 421;
    const STATUS_422_UNPROCESSABLE_ENTITY = 422;
    const STATUS_423_LOCKED = 423;
    const STATUS_424_FAILED_DEPENDENCY = 424;
    const STATUS_425_UNORDERED_COLLECTION = 425;
    const STATUS_426_UPGRADE_REQUIRED = 426;
    const STATUS_449_RETRY_WITH = 449;

    const STATUS_500_INTERNAL_SERVER_ERROR = 500;
    const STATUS_501_NOT_IMPLEMENTED = 501;
    const STATUS_502_BAD_GATEWAY = 502;
    const STATUS_503_SERVICE_UNAVAILABLE = 503;
    const STATUS_504_GATEWAY_TIMEOUT = 504;
    const STATUS_505_HTTP_VERSION_NOT_SUPPORTED = 505;
    const STATUS_506_VARIANT_ALSO_NEGOTIATES = 506;
    const STATUS_507_INSUFFICIENT_STORAGE = 507;
    const STATUS_509_BANDWIDTH_LIMIT_EXCEEDED = 509;
    const STATUS_510_NOT_EXTENDED = 510;

    protected $code = HttpStatusCode::STATUS_1_UNKNOWN;

    /**
     * 建構子
     * HttpStatusCode constructor.
     * @param $code
     */
    public function __construct(int $code)
    {
        $this->code = $code;
    }

    /**
     * 取得 HTTP 狀態碼
     * @return int
     */
    public function getCode()
    {
        return (int)$this->code;
    }
}
