<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class BadRequestDTO
{
    /**
     * @var bool
     * @Serializer\Type("boolean")
     * @OA\Property(property="success", type="boolean", example="false")
     */
    private $success;

    /**
     * @var integer
     * @Serializer\Exclude()
     */
    private $code;

    public function __construct()
    {
        $this->success = false;
        $this->code = Response::HTTP_BAD_REQUEST;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}