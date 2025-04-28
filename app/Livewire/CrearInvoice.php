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
        $this->cancelar();
        $this->dispatch('mensaje', 'Factura Subida');
    }

    public function guardarConcepto(int $id) {
        Invoice::findOrFail($id);
        $this->conceptForm->storeConcept($id);
        $this->crearConcepto = false;
        $this->cform->updateInvoice();
    }

    public function cancelarConcepto() {
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
    }

    public function cancelar() {
        $this->cform->updateInvoice();
        $this->dispatch('facturaSubida')->to(ShowInvoices::class);
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
        $this->openCrear = false;
        $this->cform->formReset();
    }
}
