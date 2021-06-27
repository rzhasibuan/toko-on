<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    // public variabel
    public $paginate = 10;
    public $search ;
    public $formVisible;
    public $formUpdate = false;

    protected $listeners = [
        'formClose' => 'formCloseHandler',
        'productStore' => 'produkStoreHandler',
        'productUpdated' => 'productUpdatedHandler'
    ];
    
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

    public function formCloseHandler()
    {
        $this->formVisible = false;
    }

    public function produkStoreHandler()
    {
        $this->formVisible = false;
        session()->flash('message', 'Your product has been created');
    }

    public function editProduct($productId)
    {
        $this->formUpdate = true;
        $this->formVisible = true;

        $product = Product::find($productId);
        $this->emit('editProduct', $product);
    }

    public function productUpdatedHandler()
    {
        $this->formVisible = false;
        session()->flash('message', 'Your product has been updated');
    }

    public function deleteProduct($productId)
    {
        $product = Product::find($productId);

        if($product->image)
        {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        session()->flash('message','Your product hs been deleted!');
    }
    
}
