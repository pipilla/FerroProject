<?php

namespace App\Livewire;

use App\Mail\ContactForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class FormularioContacto extends Component
{
    public string $tipoConsulta = '';
    public string $tipoTrabajo = '';
    public string $otroTrabajo = '';
    public string $nombre = '';
    public string $direccion = '';
    public string $telefono = '';
    public string $email = '';
    public string $mensaje = '';

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

        $this->dispatch('mensaje', 'Correo enviado');
        $this->redirect(route('welcome'));
    }

    protected function rules()
    {
        if ($this->tipoConsulta === 'Encargo de trabajo') {
            return [
                'tipoConsulta' => 'required|string',
                'tipoTrabajo' => 'required|string',
                'otroTrabajo' => $this->tipoTrabajo == 'Otros' ? 'required|string' : 'nullable',
                'nombre' => 'required|string|min:3|max:50',
                'direccion' => 'required|string',
                'telefono' => [
                    'required',
                    'string',
                    'regex:/^(?:(?:\+34|0034)?\s?)?(6\d{8}|7\d{8}|9\d{8})$/'
                ],
                'mensaje' => 'required|string|min:10|max:500',
                'email' => (Auth::check()) ? 'nullable' : 'required|email',
            ];
        }

        return [
            'tipoConsulta' => 'required|string',
            'nombre' => 'required|string',
            'mensaje' => 'required|string',
            'email' => (Auth::check()) ? 'nullable' : 'required|email',
        ];
    }
}
