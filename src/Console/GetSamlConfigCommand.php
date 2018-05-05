<?php

namespace HiHaHo\Saml\Console;

use HiHaHo\Saml\Models\SamlConfig;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;

class GetSamlConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saml:view {samlConfig : The ID of the SAML config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the details of a SAML configurations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $configId = $this->argument('samlConfig');

        $samlConfig = SamlConfig::findOrFail($configId);

        $table = new Table($this->output);

        $table->setHeaders([
            [new TableCell('SAML Config', ['colspan' => 2])],
            ['Key', 'Value']
        ]);

        $columns = Schema::getColumnListing('saml_configs');
        foreach ($columns as $column) {
            $table->addRow([$column, $samlConfig->{$column}]);
        }

        $table->render();
    }
}
