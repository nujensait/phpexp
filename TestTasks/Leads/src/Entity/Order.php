<?php

namespace App\Entity;

use App\Service\BillGenerator;
use App\Service\BillMicroserviceClient;

const CONTRACTOR_TYPE_PERSON = 1;
const CONTRACTOR_TYPE_LEGAL = 2;

class Order
{
    /** @var string */
    public $id;

    /** @var int */
    public $sum;

    /** @var Item[] */
    public $items = [];

    /** @var int */
    public $contractorType;

    /** @var bool */
    public $isPaid;

    /** @var BillGenerator */
    public $billGenerator;

    /** @var BillMicroserviceClient */
    public $billMicroserviceClient;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getPayUrl()
    {
        return "http://some-pay-agregator.com/pay/" . $this->id;
    }

    public function setBillGenerator($billGenerator)
    {
        $this->billGenerator = $billGenerator;
    }

    public function getBillUrl()
    {
        return $this->billGenerator->generate($this);
    }

    public function setBillClient(BillMicroserviceClient $cl)
    {
        $this->billMicroserviceClient = $cl;
    }

    public function isPaid()
    {
        if ($this->contractorType == CONTRACTOR_TYPE_PERSON) {
            return $this->isPaid;
        }
        if ($this->contractorType == CONTRACTOR_TYPE_LEGAL) {
            return $this->billMicroserviceClient->IsPaid($this->id);
        }
    }
}