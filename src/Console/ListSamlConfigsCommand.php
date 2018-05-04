<?php

namespace HiHaHo\Saml\Console;

use HiHaHo\Saml\Models\SamlConfig;
use Illuminate\Console\Command;

class ListSamlConfigsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saml:list-configs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all SAML configurations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $headers = ['ID', 'Name', 'Slug', 'IdP Base URL'];

        $configs = SamlConfig::all(['id', 'name', 'slug', 'idp_base_url'])->toArray();

        $this->table($headers, $configs);
    }
}
