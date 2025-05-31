@component('mail::message')
    # Nuevo/a {{ $tipoConsulta }}

    @if ($tipoConsulta == 'Encargo de trabajo')
**Tipo de trabajo:** {{ $tipoTrabajo }}

        @if ($tipoTrabajo == 'Otros')
**Descripción del trabajo:** {{ $otroTrabajo }}
        @endif

**{{ $nombre }}**

**Dirección:** {{ $direccion }}

**Teléfono:** {{ $telefono }}

**Email:** {{ $email }}

**Mensaje:**

        {{ $mensaje }}
    @else
**{{ $nombre }}**
        
**Email:** {{ $email }}

**Mensaje:**

        {{ $mensaje }}
    @endif
@endcomponent
