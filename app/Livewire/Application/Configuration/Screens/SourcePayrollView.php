<?php

namespace App\Livewire\Application\Configuration\Screens;

use App\Models\Hospital;
use App\Models\PayrollSource;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SourcePayrollView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name = '';
    public ?PayrollSource $payrollSourceToEdit = null;
    public string $formLabel = 'CREATION SOURCE DEPENSE';

    public function store()
    {
        $this->validate();
        try {
            PayrollSource::create([
                'name' => $this->name,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function edit(?PayrollSource $payrollSource)
    {
        $this->payrollSourceToEdit = $payrollSource;
        $this->name = $this->payrollSourceToEdit->name;
        $this->formLabel = 'EDITION SOURCE DEPENSE';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->payrollSourceToEdit->name = $this->name;
            $this->payrollSourceToEdit->update();
            $this->payrollSourceToEdit = null;
            $this->formLabel = 'CREATION SOURCE DEPENSE';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->payrollSourceToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(PayrollSource $payrollSource)
    {
        try {
            if ($payrollSource->payrolls->isEmpty()) {
                $this->dispatch('error', ['message' => "Action impossible, car la source contients des dépenses"]);
            } else {
                $payrollSource->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.application.configuration.screens.source-payroll-view', [
            'payrollSources' => PayrollSource::orderBy('name', 'asc')
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
