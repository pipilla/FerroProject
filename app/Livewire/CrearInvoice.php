<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearConcept;
use App\Livewire\Forms\FormCrearInvoice;
use App\Models\Invoice;
use App\Models\Tax;
use Livewire\Component;

class CrearInvoice extends Component
{
    public bool $openCrear = false;

    public FormCrearInvoice $cform;
    
    public bool $crearConcepto = false;
    public FormCrearConcept $conceptForm;

    public function render()
    {
        $taxes = Tax::orderBy('id')->get();
        return view('livewire.crear-invoice', compact('taxes'));
    }

    public function createInvoice() {
        $this->cform->createInvoice();
        $this->openCrear = true;
    }

    public function store()
    {
        $this->cform->storeInvoice();
        $this->dispatch('facturaSubida')->to(ShowMedia::class);
        $this->cancelar();
        $this->dispatch('mensaje', 'Factura Subida');
    }

    public function crearConcepto(int $id) {
        Invoice::findOrFail($id);
        $this->conceptForm->storeConcept($id);
    }

    public function cancelar() {
        $this->openCrear = false;
        $this->cform->formReset();
    }
}
