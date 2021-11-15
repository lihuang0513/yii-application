<?php
namespace Deployer;

require 'recipe/yii2-app-advanced.php';

// Project name
set('application', '/usr/share/nginx/project');

// Project repository
set('repository', 'git@github.com:lihuang0513/yii-application.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

task('deploy:init', function () {
    run('{{bin/php}} {{release_path}}/init --env=Production --overwrite=No');
})->desc('Initialization');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:init',
    'deploy:shared',
    'deploy:writable',
//    'deploy:run_migrations',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy your project');

// Hosts
host('82.156.163.95')
    ->user('root')
    ->set('deploy_path', '{{application}}');

after('deploy:failed', 'deploy:unlock');

