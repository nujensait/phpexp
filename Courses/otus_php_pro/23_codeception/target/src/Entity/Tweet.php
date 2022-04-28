<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2020, raptor_MVK
 *
 * @Mapping\Table(name="tweet")
 * @Mapping\Entity
 * @Mapping\Entity(repositoryClass="App\Repository\TweetRepository")
 * @Mapping\HasLifecycleCallbacks
 */
class Tweet
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    /**
     * @Mapping\Column(name="id", type="bigint", unique=true)
     * @Mapping\Id
     * @Mapping\GeneratedValue(strategy="IDENTITY")
     * @OA\Property(property="id", type="integer", description="ID твита", example="123")
     */
    private $id;

    /**
     * @var User
     *
     * @Mapping\ManyToOne(targetEntity="User")
     * @Mapping\JoinColumns({
     *   @Mapping\JoinColumn(name="author_id", referencedColumnName="id")
     * })
     * @Serializer\Type("string")
     * @Serializer\Accessor(getter="getAuthorLogin")
     * @OA\Property(property="author", type="string", description="Логин автора", example="my_author")
     */
    private $author;

    /**
     * @var string
     *
     * @Mapping\Column(type="string", length=140, nullable=false)
     * @OA\Property(property="text", type="string", description="Текст твита", example="My tweet")
     */
    private $text;

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getAuthorLogin(): string
    {
        return $this->author->getLogin();
    }
}