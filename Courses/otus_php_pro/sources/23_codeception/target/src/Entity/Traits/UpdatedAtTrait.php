<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2020, raptor_MVK
 *
 * @Mapping\HasLifecycleCallbacks
 */
trait UpdatedAtTrait
{
    /**
     * @var DateTime
     *
     * @Mapping\Column(name="updated_at", type="datetime", nullable=true)
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     description="Дата+время последнего обновления описания пользователя",
     *     example="2020-01-01T01:01:01+00:00"
     * )
     */
    protected $updatedAt;

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    /**
     * @Mapping\PreUpdate
     * @Mapping\PrePersist
     */
    public function updateUpdatedAt(): void {
        $this->updatedAt = new DateTime();
    }
}