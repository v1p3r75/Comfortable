<?php

namespace System\Models;

interface MigrationInterface {

    public function up();
    public function down();
    public function runMigration();
}