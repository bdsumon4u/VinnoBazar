<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function purchase()
    {
        return $this->hasMany('App\Purchase');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }
    public function media(){
        return $this->belongsToMany('App\Media')->withTimestamps();
    }

    public function order(){
        return $this->belongsToMany('App\Order')->withTimestamps();
    }

    public function url()
    {
        return url('product/'.$this->ProductSlug.'/'.$this->id);

    }
    public function price()
    {
        if($this->productSalePrice > 0){
            return $this->productSalePrice;
        }else{
            return $this->productRegularPrice;
        }
    }
    public function htmlPrice()
    {
        if($this->productSalePrice > 0){
            return '<div class="product-price-old">
                    <del>
                        ৳ '.number_format($this->productRegularPrice).'
                    </del>
                    <span class="product-price">
                            <strong>
                                ৳ '.number_format($this->productSalePrice).'
                            </strong>
                        </span>
                </div>';
        }else{
            return '<div class="product-price-old">
                        <span class="product-price">
                                <strong>
                                    ৳ '.number_format($this->productRegularPrice).'
                                </strong>
                            </span>
                    </div>';

        }
    }
}
