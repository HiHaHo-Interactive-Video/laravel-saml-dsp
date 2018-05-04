<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamlSecurity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saml_security', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('saml_config_id');

            $table->boolean('name_id_encrypted')->default(false);
            $table->boolean('authn_requests_signed')->default(false);
            $table->boolean('logout_request_signed')->default(false);
            $table->boolean('logout_response_signed')->default(false);
            $table->boolean('sign_metadata')->default(false);
            $table->json('sign_metadata_key_file_name');
            $table->boolean('want_messages_signed')->default(false);
            $table->boolean('want_assertions_encrypted')->default(false);
            $table->boolean('want_assertions_signed')->default(false);
            $table->boolean('want_name_id')->default(true);
            $table->boolean('want_name_id_encrypted')->default(false);
            $table->boolean('requested_authn_context')->default(true);
            $table->boolean('want_XML_validation')->default(true);
            $table->boolean('relax_destination_validation')->default(false);
            $table->enum('signature_algorithm', [
                'http://www.w3.org/2000/09/xmldsig#rsa-sha1',
                'http://www.w3.org/2000/09/xmldsig#dsa-sha1',
                'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
                'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384',
                'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512',
            ])->default('http://www.w3.org/2001/04/xmldsig-more#rsa-sha256');
            $table->enum('digest_algorithm', [
                'http://www.w3.org/2000/09/xmldsig#sha1',
                'http://www.w3.org/2001/04/xmlenc#sha256',
                'http://www.w3.org/2001/04/xmldsig-more#sha384',
                'http://www.w3.org/2001/04/xmlenc#sha512',
            ])->default('http://www.w3.org/2001/04/xmlenc#sha256');
            $table->boolean('lowercase_urlencoding')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saml_security');
    }
}
