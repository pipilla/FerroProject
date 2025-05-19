<?php

namespace App\Livewire;

use App\Mail\ContactForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    public function send()
    {
        $this->validate($this->rules());

        Mail::to('contacto@email.com')->send(new ContactForm(
            $this->tipoConsulta,
            $this->tipoTrabajo,
            $this->otroTrabajo,
            $this->nombre,
            $this->direccion,
            $this->telefono,
            (Auth::check()) ? Auth::user()->email : $this->email,
            $this->mensaje
        ));

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
                'mensaje' => 'required|string',
                'email' => (Auth::check()) ? 'nullable' : 'required|email',
            ];
        }

        return [
            'tipoConsulta' => 'required',
            'nombre' => 'required|string',
            'mensaje' => 'required|string',
            'email' => (Auth::check()) ? 'nullable' : 'required|email',
        ];
    }
}
