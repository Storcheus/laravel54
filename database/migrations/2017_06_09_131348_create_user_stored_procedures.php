<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $insert = " 
            CREATE PROCEDURE `sp_user_insert`(
                    IN inFirstname VARCHAR(255), 
                    IN inLastname VARCHAR(255), 
                    IN inEmail VARCHAR(255), 
                    IN inPersonalCode VARCHAR(255),
                    OUT outId INT
                )
            BEGIN
                INSERT INTO user(firstname, lastname, email, personal_code) 
                VALUES (inFirstname, inLastname, inEmail, inPersonalCode);
                SET outId = LAST_INSERT_ID();
            END
        ";

        $update = " 
            CREATE PROCEDURE `sp_user_update`(
                    IN inId INT, 
                    IN inFirstname VARCHAR(255), 
                    IN inLastname VARCHAR(255), 
                    IN inEmail VARCHAR(255), 
                    IN inPersonalCode VARCHAR(255)
                )
            BEGIN
                UPDATE user 
                SET 
                    firstname = inFirstname,
                    lastname = inLastname,
                    email = inEmail,
                    personal_code = inPersonalCode
                WHERE
                    id = inId;
            END
        ";

        $delete = " 
            CREATE PROCEDURE `sp_user_delete`(IN inId INT)
            BEGIN
                DELETE FROM user WHERE id = inId;
            END
        ";

        DB::unprepared($insert);
        DB::unprepared($update);
        DB::unprepared($delete);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP sp_user_insert IF EXISTS sp_user_insert");
        DB::unprepared("DROP sp_user_update IF EXISTS sp_user_update");
        DB::unprepared("DROP sp_user_delete IF EXISTS sp_user_delete");
    }
}
