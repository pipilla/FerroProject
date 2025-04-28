<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearConcept;
use App\Livewire\Forms\FormCrearInvoice;
use App\Livewire\Forms\FormShowInvoices;
use App\Livewire\Forms\FormUpdateConcept;
use App\Models\Concept;
use App\Models\Invoice;
use App\Models\Tax;
use Livewire\Component;

class CrearInvoice extends Component
{
    public bool $openCrear = false;

    public FormCrearInvoice $cform;

    public bool $crearConcepto = false;
    public FormCrearConcept $conceptForm;

    public bool $editarConcepto = false;
    public FormUpdateConcept $conceptUpdateForm;

    public FormShowInvoices $sform;

    public function render()
    {
        $taxes = Tax::orderBy('id')->get();
        return view('livewire.crear-invoice', compact('taxes'));
    }

    public function createInvoice()
    {
        $this->cform->createInvoice();
        $this->openCrear = true;
    }

    public function store()
    {
        $this->cform->updateInvoice();
        $this->dispatch('facturaSubida')->to(ShowInvoices::class);
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
        $this->openCrear = false;
        $this->cform->formReset();
        $this->dispatch('mensaje', 'Factura Subida');
    }

    public function guardarConcepto(int $id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->conceptForm->storeConcept($id);
        $this->crearConcepto = false;
        $this->sform->setInvoice($invoice);
    }

    public function cancelarConcepto()
    {
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
    }

    public function updateConcepto(int $id)
    {
        Concept::findOrFail($id);
        $this->editarConcepto = true;
        $this->conceptUpdateForm->setConcept($id);
    }

    public function editConcepto()
    {
        $this->sform->setInvoice(Invoice::findOrFail($this->conceptUpdateForm->concept->invoice_id));
        $this->conceptUpdateForm->updateConcept();
        $this->cancelarUpdateConcepto();
    }

    public function cancelarUpdateConcepto()
    {
        $this->editarConcepto = false;
        $this->conceptUpdateForm->formReset();
    }

    public function cancelar()
    {
        $this->dispatch('facturaSubida')->to(ShowInvoices::class);
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
        $this->openCrear = false;
        $this->cform->formReset();
    }
}
