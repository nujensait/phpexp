<?php


class Order
{
    public function createOrder(){
        // $discount

        // apply discount
        if($discount instanceof DiscountInterface){
            if($discount->validateDiscount()){
                $discount->applyDiscount();
            }
        }
    }
}