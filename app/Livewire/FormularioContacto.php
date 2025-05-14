<?php

namespace App\Livewire;

use Livewire\Component;

class FormularioContacto extends Component
{
    public $tipoConsulta = '';
    public $tipoTrabajo = '';
    public $otroTrabajo = '';
    public $nombre = '';
    public $direccion = '';
    public $telefono = '';
    public $email = '';
    public $mensaje = '';
    
    public function render()
    {
        return view('livewire.formulario-contacto');
    }

    public function send() {
        $this->validate($this->rules());

        $this->redirect(route('welcome'));
        $this->dispatch('mensaje', 'Correo enviado');
    }

    protected function rules()
    {
        if ($this->tipoConsulta === 'Encargo de trabajo') {
            return [
                'tipoConsulta' => 'required',
                'tipoTrabajo' => 'required',
                'otroTrabajo' => $this->tipoTrabajo == 'Otros' ? 'required|string' : 'nullable',
                'nombre' => 'required|string',
                'direccion' => 'required|string',
                'telefono' => 'required|string',
                'email' => 'required|email',
            ];
        }

        return [
            'tipoConsulta' => 'required',
            'nombre' => 'required|string',
            'mensaje' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
