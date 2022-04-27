<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

class FollowersDTO
{
    /**
     * @var User[]
     * @Serializer\Type("array")
     * @OA\Property(
     *     property="followers",
     *     type="array",
     *     description="Подписчики",
     *     items=@OA\Items(ref=@Model(type=User::class))
     * )
     */
    private $followers;

    /**
     * @var integer
     * @Serializer\Exclude()
     */
    private $code;

    /**
     * @param User[] $followers
     */
    public function __construct(array $followers)
    {
        $this->followers = $followers;
        $this->code = Response::HTTP_OK;
    }

    /**
     * @return User[]
     */
    public function getFollowers(): array
    {
        return $this->followers;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}