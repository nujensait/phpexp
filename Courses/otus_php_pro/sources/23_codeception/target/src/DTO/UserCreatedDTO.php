<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class UserCreatedDTO
{
    /**
     * @var bool
     * @Serializer\Type("boolean")
     * @OA\Property(property="success", type="boolean", example="true")
     */
    private $success;

    /**
     * @var integer
     * @Serializer\Type("integer")
     * @OA\Property(property="userId", type="integer", description="ID созданного пользователя", example="123")
     */
    private $userId;

    /**
     * @var integer
     * @Serializer\Exclude()
     */
    private $code;

    public function __construct(int $userId)
    {
        $this->success = true;
        $this->userId = $userId;
        $this->code = Response::HTTP_OK;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}