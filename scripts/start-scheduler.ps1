param(
    [int]$SleepSeconds = 60,
    [int]$MaxRetries = 5,
    [int]$RetryDelaySeconds = 10
)

$projectDir = Split-Path -Parent (Split-Path -Parent $PSScriptRoot)
$logDir = Join-Path $projectDir "storage\logs"
$logFile = Join-Path $logDir "scheduler.log"
$pidFile = Join-Path $logDir "scheduler.pid"

if (-not (Test-Path $logDir)) {
    New-Item -ItemType Directory -Path $logDir -Force | Out-Null
}

# Guardar PID
$PID.ToString() | Out-File -FilePath $pidFile -Force

$date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
"[$date] [INICIO] Scheduler iniciado (cada $SleepSeconds segundos, max reintentos: $MaxRetries)" | Out-File -FilePath $logFile -Append
Write-Host "[$date] [INICIO] Scheduler iniciado - PID: $PID"

$retryCount = 0

while ($true) {
    try {
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        $output = & php "$projectDir\artisan" schedule:run 2>&1
        "$date [OK] $output" | Out-File -FilePath $logFile -Append
        $retryCount = 0  # Resetear contador tras éxito
    }
    catch {
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        $retryCount++
        "$date [ERROR] Intento $retryCount/$MaxRetries: $_" | Out-File -FilePath $logFile -Append
        Write-Host "[$date] [ERROR] $_ (intento $retryCount/$MaxRetries)"

        if ($retryCount -ge $MaxRetries) {
            $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
            "$date [CRITICO] Demasiados errores consecutivos ($MaxRetries). Reiniciando contador..." | Out-File -FilePath $logFile -Append
            Write-Host "[$date] [CRITICO] Demasiados errores. Esperando $RetryDelaySeconds s..."
            Start-Sleep -Seconds $RetryDelaySeconds
            $retryCount = 0
        }

        Start-Sleep -Seconds $RetryDelaySeconds
    }

    Start-Sleep -Seconds $SleepSeconds
}
