<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Expression\Expression;

final class M260520135219CreateProjectModuleTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $cb = $b->columnBuilder();

        $b->createTable('project_module', [
            'id' => $cb::primaryKey(),
            'title' => $cb::string()->notNull(),
            'description' => $cb::text(),
            'status' => $cb::string(20)->notNull()->defaultValue('new'),
            'sort' => $cb::integer()->notNull()->defaultValue(0),
            'created_at' => $cb::datetime()->notNull()->defaultValue(new Expression('CURRENT_TIMESTAMP')),
            'updated_at' => $cb::datetime(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('project_module');
    }
}
