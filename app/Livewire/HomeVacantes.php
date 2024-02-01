<?php

namespace App\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class HomeVacantes extends Component
{
    public $termino;
    public $categoria;
    public $salario;

    protected $listeners = [
        // Cuando se actica el listerner terminosBusqueda se ejecuta
        // la funcion buscar
        'terminosBusqueda' => 'buscar'
    ];

    public function buscar($termino, $categoria, $salario)
    {
        $this->termino = $termino;
        $this->categoria = $categoria;
        $this->salario = $salario;
    }

    public function render()
    {
        //$vacantes = Vacante::all();

        $vacantes = Vacante::when($this->termino, function($query) {
            $query->where('titulo', 'LIKE',  '%'.$this->termino.'%');
        })
        // Si no encuentra el termino en el titulo lo buscara en la empresa
        ->when($this->termino, function($query) {
            $query->orWhere('empresa', 'LIKE',  '%'.$this->termino.'%');
        })
        ->when($this->categoria, function($query) {
            $query->where('categoria_id', $this->categoria);
        })
        ->when($this->salario, function($query) {
            $query->where('salario_id', $this->salario);
        })
        ->paginate(20);

        return view('livewire.home-vacantes', [
            'vacantes' => $vacantes
        ]);
    }
}
