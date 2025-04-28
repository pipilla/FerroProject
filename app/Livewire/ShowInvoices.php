<?php

namespace App\Livewire;

use App\Livewire\Forms\FormShowInvoices;
use App\Models\Invoice;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowInvoices extends Component
{
    public bool $openShow = false;
    public FormShowInvoices $sform;

    #[On('facturaSubida')]
    public function render()
    {
        $invoices = Invoice::orderBy('date', 'desc')->paginate(24);
        return view('livewire.show-invoices', compact('invoices'));
    }

    public function show(int $id){
        $invoice = Invoice::findOrFail($id);
        $this->sform->setInvoice($invoice);
        $this->openShow = true;
    }

    public function cerrarShow(){
        $this->openShow = false;
        $this->sform->resetForm();
        $this->reset();
    }
}
