<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;

class Index extends Component
{
    // public variabel
    public $paginate = 10;
    public $search ;
    
    // this method for the make pretty url from search using except 
    public $updatesQueryString = [
        ['search' => ['except' => '']] 
    ];

    // method mount mirip seperti counstract  
    public function mount()
    {
        $this->search = request()->query('search',$this->search);
    }
    
    public function render()
    // if search is null show tables with paginate 
    {
        return view('livewire.product.index', [
            'products' => $this->search === null ?
                Product::latest()->paginate($this->paginate) : 
            //  if search have a value show data
                Product::latest()->where('title', 'like', '%' .$this->search. '%')
                ->paginate($this->paginate)
        ]);
    }

    
    
}
