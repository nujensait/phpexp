<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class AuthorsDTO
{
    /**
     * @var User[]
     * @Serializer\Type("array")
     * @OA\Property(
     *     property="authors",
     *     type="array",
     *     description="Авторы",
     *     items=@OA\Items(ref=@Model(type=User::class))
     * )
     */
    private $authors;

    /**
     * @var integer
     * @Serializer\Exclude()
     */
    private $code;

    /**
     * @param User[] $authors
     */
    public function __construct(array $authors)
    {
        $this->authors = $authors;
        $this->code = Response::HTTP_OK;
    }

    /**
     * @return User[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}