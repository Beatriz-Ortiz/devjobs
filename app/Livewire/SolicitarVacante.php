<?php

namespace App\Livewire;

use App\Models\Candidato;
use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\WithFileUploads;

class SolicitarVacante extends Component
{
    public $cv;
    public $vacante;

    use WithFileUploads;

    protected $rules = [
        'cv' => 'required|mimes:pdf'
    ];

    public function mount(Vacante $vacante)
    {
        $this->vacante = $vacante;
    }

    public function solicitar()
    {
        $datos = $this->validate();

        // Almacenar CV
        $cv = $this->cv->store('public/cv');
        $datos['cv'] = str_replace('public/cv/', '', $cv);

        // Crear un candidato
        $this->vacante->candidatos()->create([
            'user_id' => auth()->user()->id,
            // No hace falta asignar el candidato_id porque lo toma de la propia relacion candidatos()
            'cv' => $datos['cv']
        ]);

        // Crear notificacion y enviar email
        $this->vacante->reclutador->notify(
            new NuevoCandidato($this->vacante->id, $this->vacante->titulo, auth()->user()->id)
        );

        // Mostrar mensaje de sesión
        session()->flash('mensaje', 'Se envió correctamente tu información, mucha suerte!');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.solicitar-vacante');
    }
}
