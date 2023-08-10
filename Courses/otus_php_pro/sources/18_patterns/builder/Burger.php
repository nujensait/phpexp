<?php

class Burger
{
    protected $size; // mandatory

    protected $cheese;
    protected $pepperoni;
    protected $lettuce;
    protected $tomato;

    public function __construct(BurgerBuilder $builder)
    {
        $this->size = $builder->size;
        $this->cheese = $builder->cheese;
        $this->pepperoni = $builder->pepperoni;
        $this->lettuce = $builder->lettuce;
        $this->tomato = $builder->tomato;
    }

    public function consume(){

    }
}