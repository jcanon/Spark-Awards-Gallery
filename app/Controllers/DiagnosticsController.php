<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class DiagnosticsController extends BaseController
{
    public function health(): ResponseInterface
    {
        $checks = $this->collectChecks();

        $status = ($checks['database_ok'] && $checks['writable_ok']) ? 'ok' : 'degraded';
        $code   = $status === 'ok' ? 200 : 503;

        return $this->response
            ->setStatusCode($code)
            ->setJSON([
                'status'      => $status,
                'environment' => ENVIRONMENT,
                'timestamp'   => date(DATE_ATOM),
                'checks'      => [
                    'database_ok' => $checks['database_ok'],
                    'writable_ok' => $checks['writable_ok'],
                ],
            ]);
    }

    public function diagnostics(): ResponseInterface
    {
        $checks = $this->collectChecks();

        return $this->response->setJSON([
            'environment' => ENVIRONMENT,
            'timestamp'   => date(DATE_ATOM),
            'checks'      => $checks,
        ]);
    }

    private function collectChecks(): array
    {
        $databaseOK = false;
        try {
            $db = \Config\Database::connect();
            $db->query('SELECT 1');
            $databaseOK = true;
        } catch (Throwable) {
            $databaseOK = false;
        }

        $paths = [
            'writable'       => WRITEPATH,
            'writable_cache' => WRITEPATH . 'cache',
            'writable_logs'  => WRITEPATH . 'logs',
            'writable_session' => WRITEPATH . 'session',
        ];

        $pathChecks = [];
        $writableOK = true;
        foreach ($paths as $label => $path) {
            $exists    = is_dir($path);
            $writable  = $exists && is_writable($path);
            $pathChecks[$label] = [
                'path'     => $path,
                'exists'   => $exists,
                'writable' => $writable,
            ];

            if (! $writable) {
                $writableOK = false;
            }
        }

        return [
            'database_ok' => $databaseOK,
            'writable_ok' => $writableOK,
            'paths'       => $pathChecks,
        ];
    }
}
