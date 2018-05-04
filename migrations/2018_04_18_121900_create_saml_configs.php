<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamlConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saml_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('login_handler')->nullable();
            $table->string('idp_base_url')->nullable();
            $table->string('idp_entity_id');
            $table->string('idp_sso_url');
            $table->string('idp_sso_binding');
            $table->string('idp_slo_url');
            $table->string('idp_slo_binding');
            $table->text('idp_x509_cert')->nullable();
            $table->string('idp_cert_fingerprint')->nullable();
            $table->string('idp_cert_fingerprint_algorithm')->nullable();

            $table->string('sp_name_id_format')->nullable();
            $table->text('sp_x509_cert')->nullable();
            $table->string('sp_private_key')->nullable();
//            $table->string('sp_private_key_pass')->nullable();
            $table->string('sp_entity_id')->nullable();

            $table->string('sp_assertion_consumer_service_url')->nullable();
            $table->string('sp_single_logout_service_url')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['slug', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saml_configs');
    }
}
