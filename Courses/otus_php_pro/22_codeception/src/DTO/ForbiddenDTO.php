<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ForbiddenDTO
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @OA\Property(property="message", type="string", example="Access denied")
     */
    private $message;

    /**
     * @var integer
     * @Serializer\Exclude()
     */
    private $code;

    public function __construct()
    {
        $this->message = "Access denied";
        $this->code = Response::HTTP_FORBIDDEN;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}