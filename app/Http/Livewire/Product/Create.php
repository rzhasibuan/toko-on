<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $price;
    public $description;
    public $image;

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
            'image' => 'image|max:1024|mimes:png,jpg'
        ]);

        $imageName = '';

        if($this->image) 
        {
            // make name for the file
            $imageName = \Str::slug($this->title, '-')
            . '-'
            .uniqid()
            . '-'.$this->image->getClientOriginalExtension();
            // save to directory 
            $this->image->storeAs('public', $imageName, 'local');
        }

        Product::create([
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $imageName,
        ]);

        $this->emit('productStore');
    }
}
