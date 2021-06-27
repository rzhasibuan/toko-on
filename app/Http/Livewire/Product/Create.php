<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $price;
    public $description;

    public function render()
    {
        return view('livewire.product.create');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|min:3',
            'description' => 'required|max:100',
            'price' => 'required|numeric',
        ]);
        
        Product::create([
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description
        ]);

        $this->emit('productStore');
    }
}
