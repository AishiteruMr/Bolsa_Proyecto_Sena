<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuditReportMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reportArray;
    public $csvContent;

    public function __construct($reportArray, $csvContent)
    {
        $this->reportArray = $reportArray;
        $this->csvContent = $csvContent;
    }

    public function build()
    {
        return $this->subject('Reporte de Auditoría de Seguridad - Bolsa de Proyectos SENA')
                    ->markdown('emails.audit_report_markdown', ['report' => $this->reportArray])
                    ->attachData($this->csvContent, 'audit_report.csv', [
                        'mime' => 'text/csv',
                    ]);
    }
}
