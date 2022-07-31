<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tweet;

class TweetsDTO
{
    /**
     * @var Tweet[]
     * @Serializer\Type("array")
     * @OA\Property(
     *     property="tweets",
     *     type="array",
     *     description="Твиты",
     *     items=@OA\Items(ref=@Model(type=Tweet::class))
     * )
     */
    private $tweets;

    /**
     * @var integer
     * @Serializer\Exclude()
     */
    private $code;

    /**
     * @param Tweet[] $tweets
     */
    public function __construct(array $tweets)
    {
        $this->tweets = $tweets;
        $this->code = Response::HTTP_OK;
    }

    /**
     * @return Tweet[]
     */
    public function getTweets(): array
    {
        return $this->tweets;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}