<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuditAuthScannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:auth-scan';

    protected $description = 'Analiza las Policies y Gates registradas en el sistema';

    public function handle(): int
    {
        $this->info("🛡️ Escaneando autorizaciones...");

        // 1. Policies
        $policies = \Illuminate\Support\Facades\Gate::policies();
        $this->info("\n📋 Policies registradas (" . count($policies) . "):");
        $policyData = [];
        foreach ($policies as $model => $policy) {
            $policyData[] = ['Modelo' => $model, 'Policy' => $policy];
        }
        $this->table(['Modelo', 'Policy'], $policyData);

        // 2. Gates/Abilities
        $abilities = \Illuminate\Support\Facades\Gate::abilities();
        $this->info("\n🔑 Gates/Abilities registradas (" . count($abilities) . "):");
        $abilityData = [];
        foreach ($abilities as $ability => $callback) {
            $abilityData[] = ['Ability' => $ability];
        }
        $this->table(['Ability'], $abilityData);

        return Command::SUCCESS;
    }

}
