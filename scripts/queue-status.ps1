param(
    [switch]$Watch,
    [int]$Interval = 5
)

$projectDir = Split-Path -Parent (Split-Path -Parent $PSScriptRoot)

function Get-QueueStatus {
    php "$projectDir\artisan" queue:check 2>&1
    Write-Host ""
    Write-Host "=== Jobs en cola por prioridad ===" -ForegroundColor Cyan
    $jobs = & php -r "
        echo json_encode(DB::table('jobs')->select('queue', DB::raw('count(*) as total'))->groupBy('queue')->get()->toArray());
    " 2>&1
    # Fallback: consulta directa
    php "$projectDir\artisan" queue:monitor 2>&1
}

function Show-JobDetails {
    $failed = php -r "
        \$count = DB::table('failed_jobs')->count();
        echo \"Jobs fallidos: \$count\n\";
    " 2>&1
    Write-Host $failed -ForegroundColor Yellow
}

if ($Watch) {
    Write-Host "=== MONITOREO DE COLAS ===" -ForegroundColor Green
    Write-Host "Actualizando cada $Interval segundos. Ctrl+C para salir.`n" -ForegroundColor Gray

    while ($true) {
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        Write-Host "[$date]" -ForegroundColor Cyan
        Get-QueueStatus
        Show-JobDetails
        Write-Host ("=" * 50) -ForegroundColor DarkGray
        Start-Sleep -Seconds $Interval
    }
} else {
    Get-QueueStatus
    Show-JobDetails
}
