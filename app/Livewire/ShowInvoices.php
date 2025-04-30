<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCrearConcept;
use App\Livewire\Forms\FormShowInvoices;
use App\Livewire\Forms\FormUpdateConcept;
use App\Livewire\Forms\FormUpdateInvoice;
use App\Models\Concept;
use App\Models\Invoice;
use App\Models\Tax;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowInvoices extends Component
{
    public bool $openShow = false;
    public FormShowInvoices $sform;

    public bool $openEdit = false;
    public FormUpdateInvoice $uform;

    public bool $crearConcepto = false;
    public FormCrearConcept $conceptForm;

    public bool $editarConcepto = false;
    public FormUpdateConcept $conceptUpdateForm;

    #[On('facturaSubida')]
    public function render()
    {
        $taxes = Tax::orderBy('id')->get();
        $invoices = Invoice::orderBy('updated_at', 'desc')->paginate(24);
        return view('livewire.show-invoices', compact('invoices', 'taxes'));
    }

    public function show(int $id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->sform->resetForm();
        $this->sform->setInvoice($invoice);
        $this->openShow = true;
    }

    public function update()
    {
        $this->uform->setInvoice($this->sform->invoice);
        $this->openEdit = true;
        $this->openShow = false;
    }

    public function edit()
    {
        $this->uform->updateInvoice();
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
        $this->cerrarEdit();
        $this->dispatch('facturaSubida')->to(ShowInvoices::class);
        $this->dispatch('mensaje', 'Factura Subida');
    }

    public function cerrarEdit()
    {
        $this->crearConcepto = false;
        $this->conceptForm->formReset();
        $this->uform->formReset();
        $this->openEdit = true;
    }

    public function guardarConcepto(int $id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->conceptForm->storeConcept($id);
        $this->crearConcepto = false;
        $this->sform->resetForm();
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
        $invoice = Invoice::findOrFail($this->conceptUpdateForm->concept->invoice_id);
        $this->conceptUpdateForm->updateConcept();
        $this->sform->resetForm();
        $this->sform->setInvoice($invoice);
        $this->cancelarUpdateConcepto();
    }

    public function cancelarUpdateConcepto()
    {
        $this->editarConcepto = false;
        $this->conceptUpdateForm->formReset();
    }

    public function borrarConcepto(int $id)
    {
        $invoice = $this->sform->invoice;
        $concept = Concept::findOrFail($id);
        $concept->delete();
        $this->sform->resetForm();
        $this->sform->setInvoice($invoice);
    }

    public function cerrarShow()
    {
        $this->openShow = false;
        $this->sform->resetForm();
        $this->reset();
    }

    public function confirmarBorrar(int $id) {
        Invoice::findOrFail($id);
        $this->dispatch('confirmarBorrarInvoice', $id);
    }

    #[On('borrarInvoiceOk')]
    public function borrar(int $id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->cerrarShow();
        $invoice->delete();
        $this->dispatch('mensaje', 'Factura eliminada');
    }
}
